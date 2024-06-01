<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Media;
use App\Models\Like;
use App\Models\Bookmark;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['parent_id', 'text'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'parent_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Post::class, 'parent_id');
    }

    public function medias(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    public function likedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes')->using(Like::class)->withTimestamps();
    }

    public function bookmarkedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'bookmarks')->using(Bookmark::class)->withTimestamps();
    }

    public function scopePosts($q)
    {
        return $q->where('parent_id', null);
    }

    public function scopePublic($q)
    {
        return $q->whereHas('user', function($q){
            return $q->whereHas('profile', function($q){
                return $q->where('private', false);
            });
        });
    }

    public function scopeFollowing($q)
    {
        return $q->whereHas('user', function($q){
            return $q->whereHas('followers', function($q){
                return $q->where('id', Auth::user()->id)->whereStatus('approved');
            });
        });
    }

    public function getMainAttribute()
    {
        $post = $this;
        while($post->parent){
            $post = $post->parent;
        }
        return $post;
    }

    public function getLikedAttribute()
    {
        if(!Auth::user()) return false;
        return $this->likes()->where(['user_id' => Auth::user()->id])->exists();
    }

    public function getBookmarkedAttribute()
    {
        if(!Auth::user()) return false;
        return $this->bookmarks()->where(['user_id' => Auth::user()->id])->exists();
    }
}
