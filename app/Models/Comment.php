<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = [
        'user_id', 
        'body',
        'post_id'
    ];
    /**
     * このコメントを所有するユーザーへのリレーション
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * このコメントが属する投稿へのリレーション
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * このコメントの親コメントへのリレーション
     */
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * このコメントに対する返信コメントへのリレーション
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
