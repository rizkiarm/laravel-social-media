<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\Follow;
use App\Models\User;

use Spatie\Activitylog\Models\Activity;

class UserService {
    
    public function changeStatus(User $user, string $status)
    {
        $follower = $user->followers()->wherePivot('target_id', Auth::user()->id)->first();
        if($follower){
            $user->followers()->updateExistingPivot($user->id, [
			    'status' => $status,
			]);
        }
    }

    public function getNotifications($user)
    {
        return Activity::where('causer_id', $user->id)->orWhere(function($q) use ($user) {
                    $q->where('subject_id', $user->id)->where('subject_type', 'App\Models\User');
                })->orderBy('created_at', 'desc')->simplePaginate(10, $columns=['*'], $pageName='notifications');
    }
    
}