<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;

use App\Models\Post;
use App\Models\Like;
use App\Models\Bookmark;
use App\Models\Profile;
use App\Models\Follow;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function follows(): HasMany
    {
        return $this->hasMany(Follow::class);
    }

    public function likedPosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'likes')->using(Like::class)->withTimestamps();
    }

    public function bookmarkedPosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'bookmarks')->using(Bookmark::class)->withTimestamps();
    }

    public function followings(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'target_id')->using(Follow::class)->withTimestamps()->withPivot('status');
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'target_id', 'user_id')->using(Follow::class)->withTimestamps()->withPivot('status');
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function scopeRecommended($q)
    {
        return $q->whereHas('followers', function($q){
            return $q->whereNot('id', Auth::user()->id);
        })->orWhereDoesntHave('followers');
    }

    public function getFollowingAttribute()
    {
        if(!Auth::user()) return false;
        $follow = Follow::where(['user_id' => Auth::user()->id, 'target_id' => $this->id])->first();
        if($follow){
            return $follow->status;
        }
        return false;
    }

    public function getProtectedAttribute()
    {
        if(!$this->profile->private) return false;
        if(!Auth::user()) return true;
        if(Auth::user()->id == $this->id) return false;
        return $this->profile->private && $this->following != 'approved';
    }

}
