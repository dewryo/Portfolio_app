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

    public function post_tags()
    {
    return $this->hasMany(PostTag::class);
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
