<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

use App\Models\User;

class Profile extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';

    protected $fillable = ['user_id', 'photo_path', 'description', 'gender', 'birthdate', 'location', 'private'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getPhotoAttribute()
    {
        if($this->photo_path){
            return Storage::url($this->photo_path);
        }
        return Storage::url('default_photo.png');
    }
}