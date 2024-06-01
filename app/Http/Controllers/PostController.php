<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Services\PostService;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect()->route('home');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request, PostService $service)
    {
        $data = $request->validated();
        $medias = $service->uploadMedias($request);

        $post = Auth::user()->posts()->create($data);

        $post->medias()->createMany($medias);

        activity()->causedBy(Auth::user())->performedOn($post)->event('posted')->log('');

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', [
            'post' => $post,
            'comments' => $post->comments()->paginate(5, $columns=['*'], $pageName='comments')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $parent = $post->parent;
        $main = $post->main;

        $post->delete();

        activity()->causedBy(Auth::user())->performedOn($post)->event('deleted')->log('');

        return redirect()->route('home');
    }

    public function bookmarks()
    {
        return view('posts.bookmarks', ['posts' => Auth::user()->bookmarkedPosts()->paginate(10)]);
    }

    public function bookmark(Post $post)
    {
        Auth::user()->bookmarkedPosts()->attach($post);

        activity()->causedBy(Auth::user())->performedOn($post)->event('bookmarked')->log('');

        return back();
    }

    public function unbookmark(Post $post)
    {
        Auth::user()->bookmarkedPosts()->detach($post);

        activity()->causedBy(Auth::user())->performedOn($post)->event('unbookmarked')->log('');

        return back();
    }

    public function likes()
    {
        return view('posts.likes', ['posts' => Auth::user()->likedPosts()->paginate(10)]);
    }

    public function like(Post $post)
    {
        Auth::user()->likedPosts()->attach($post);

        activity()->causedBy(Auth::user())->performedOn($post)->event('liked')->log('');

        return back();
    }

    public function unlike(Post $post)
    {
        Auth::user()->likedPosts()->detach($post);

        activity()->causedBy(Auth::user())->performedOn($post)->event('unliked')->log('');

        return back();
    }
}
