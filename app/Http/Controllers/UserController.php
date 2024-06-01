<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\StoreUserRequestt;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users.index', ['users' => User::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request, UserService $service)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, UserService $service)
    {
        return view('users.show', [
            'user' => $user,
            'posts' => $user->posts->sortByDesc('created_at')->paginate(10),
            'notifications' => $service->getNotifications($user)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        if($data['password'] == ''){
            unset($data['password']);
        }
        if(isset($data['photo']))
        {
            $data['photo_path'] = $data['photo']->store('media', 'public');
        }
        $user->update($data);
        $user->profile->update($data);
        return redirect()->route('users.show', ['user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return back();
    }

    public function media(User $user, UserService $service)
    {
        return view('users.media', [
            'user' => $user, 
            'posts' => $user->posts()->has('medias')->get()->sortByDesc('created_at')->paginate(10),
            'notifications' => $service->getNotifications($user)
        ]);
    }

    public function followings(User $user, UserService $service)
    {
        return view('users.followings', [
            'user' => $user, 
            'users' => $user->followings()->paginate(10),
            'notifications' => $service->getNotifications($user)
        ]);
    }

    public function followers(User $user, UserService $service)
    {
        return view('users.followers', [
            'user' => $user, 
            'users' => $user->followers()->paginate(10),
            'notifications' => $service->getNotifications($user)
        ]);
    }

    public function follow(User $user)
    {
        Auth::user()->followings()->attach($user, ['status' => $user->profile->private ? 'pending' : 'approved']);

        activity()->causedBy(Auth::user())->performedOn($user)->event('followed'. ($user->profile->private ? ' (pending)' : ''))->log('');

        return back(); 
    }

    public function unfollow(User $user)
    {
        Auth::user()->followings()->detach($user);

        activity()->causedBy(Auth::user())->performedOn($user)->event('unfollowed')->log('');

        return back(); 
    }

    public function approve(User $user, UserService $service)
    {
        $service->changeStatus($user, 'approved');

        activity()->causedBy(Auth::user())->performedOn($user)->event('approved')->log('');

        return back();  
    }

    public function reject(User $user, UserService $service)
    {
        $service->changeStatus($user, 'rejected');

        activity()->causedBy(Auth::user())->performedOn($user)->event('rejected')->log('');

        return back(); 
    }
}
