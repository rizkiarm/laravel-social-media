<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Services\MainService;

use App\Models\Post;
use App\Models\User;

class MainController extends Controller
{
    public function home(MainService $service)
    {
        if(!Auth::user()) return redirect()->route('explore');
        return view('main.home', [
            'posts' => Post::following()->posts()->get()->merge(Auth::user()->posts()->get())->sortByDesc('created_at')->paginate(10), 
            'users' => $service->getRecommendedUsers(5),
        ]);
    }

    public function explore(MainService $service)
    {
        return view('main.explore', [
            'posts' => Post::public()->posts()->orderBy('created_at', 'desc')->paginate(10),
            'users' => $service->getRecommendedUsers(5),
        ]);
    }

    public function searchPost(Request $request)
    {
        $keyword = $request->input('keyword');
        if(!$keyword) return back();
        return redirect()->route('search.get', ['keyword' => $keyword]);
    }

    public function searchGet(string $keyword)
    {
        return view('main.search', [
            'keyword' => $keyword,
            'posts' => Post::where('text', 'like', '%'.$keyword.'%')
                            ->orWhereHas('user', function($q) use ($keyword){
                                $q->where('name', 'like', '%'.$keyword.'%')
                                  ->orWhere('username', 'like', '%'.$keyword.'%')
                                  ->orWhere('email', 'like', '%'.$keyword.'%');
                            })
                            ->orderBy('created_at', 'desc')
                            ->paginate(10),
            'users' => User::where('name', 'like', '%'.$keyword.'%')
                            ->orWhere('username', 'like', '%'.$keyword.'%')
                            ->orWhere('email', 'like', '%'.$keyword.'%')
                            ->simplePaginate(10, $columns=['*'], $pageName='users'),
        ]);
    }
}
