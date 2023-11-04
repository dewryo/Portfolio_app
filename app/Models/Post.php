<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    use HasFactory;

    public function images()
    {
    return $this->hasMany(Image::class);
    }

    public function postTags()
    {
    return $this->hasMany(PostTag::class);
    }

    public function tags()
    {
    return $this->belongsToMany(Tag::class, 'post_tags');
    }

    public function likes()
    {
    return $this->hasMany(Like::class);
    }
    
    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'post_user', 'post_id', 'user_id');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
    ];
}
