<?php

namespace App\Models\Blogs;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BaseModel;

class Comment extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'postId', 'userId', 'parentId', 'comment', 'commentableId', 'commentableType'
    ];


    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->latest();
    }

}
