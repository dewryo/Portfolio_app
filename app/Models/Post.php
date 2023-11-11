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

    public function post_tags()
    {
        return $this->hasMany(PostTag::class); 
    }

    public function savedPosts()
    {
        return $this->belongsToMany(User::class, 'post_user');
    }

    public function tags()
    {
    return $this->belongsToMany(Tag::class, 'post_tags')->withPivot('type');
    }

        // 学年のタグを取得するメソッド
        public function gradeTags()
        {
            // 中間テーブルの 'type' カラムを使ってフィルタリング
            return $this->tags()->wherePivot('type', 'grade');
        }

            // 教科のタグを取得するメソッド
    public function subjectTags()
    {
        // 中間テーブルの 'type' カラムを使ってフィルタリング
        return $this->tags()->wherePivot('type', 'subject');
    }

    public function likes()
    {
    return $this->hasMany(Like::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
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

        // アクセサを追加してフルURLを取得する
        public function getImageUrlAttribute()
        {
            if ($this->image) {
                return Storage::url($this->image);
            }
    
            return null; // またはデフォルト画像のURL
        }
}
