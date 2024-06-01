<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

use App\Models\Post;

class Media extends Model
{
    use HasFactory;

    public $table = "medias";

    protected $fillable = ['post_id', 'path', 'type'];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function getUrlAttribute()
    {
        return Storage::url($this->path);
    }
}
