<?php

namespace App\Services;

use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class MainService {
    
    public function getRecommendedUsers(int $max_count)
    {
    	$users = Auth::user() ? User::recommended() : User::query();
		return $users->withCount('followers')
                    ->orderBy('followers_count', 'desc')
                    ->simplePaginate($max_count, $columns=['*'], $pageName='users');
   	}
    
}