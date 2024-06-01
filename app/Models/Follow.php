<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Follow extends Pivot
{
    use HasFactory;

    public $table = "follows";

    protected $fillable = ['user_id', 'post_id', 'status'];
}
