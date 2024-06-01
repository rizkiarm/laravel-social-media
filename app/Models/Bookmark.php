<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Bookmark extends Pivot
{
    use HasFactory;

    public $table = "bookmarks";

    protected $fillable = ['user_id', 'post_id'];
}
