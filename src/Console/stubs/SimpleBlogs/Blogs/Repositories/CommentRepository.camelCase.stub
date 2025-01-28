<?php 

namespace App\Repositories\Blogs;

use App\Interfaces\Blogs\CommentRepositoryInterface;
use App\Models\Blogs\Comment;
use App\Models\Blogs\Post;
use Illuminate\Support\Str;

class CommentRepository implements CommentRepositoryInterface
{
    /** 
     * @var Comment
     */
    protected $comment;

    /** 
     * LoginRepository constructor.
     * 
     * @param Comment $comment 
     */

    function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function getAll($request)
    {
  
    }
 

    public function get($comment): ?Comment
    {
        return $comment;
    }

    public function getById($id): ?Comment
    {
        return $this->comment->find($id);
    }

    public function store($request, $post): Post
    {
        $comment = new $this->comment;
        $comment->comment = $request->comment;
        $comment->postId = $post->id;
        $comment->user()->associate($request->user());  
        $post->comments()->save($comment);
        return $post->fresh();
    }

    public function storeReply($request, $post): Post
    {
        $reply = new Comment();
        $reply->postId = $post->id;
        $reply->parentId = $request->parentId; 
        $reply->comment = $request->comment;
        $reply->user()->associate($request->user());
        $post->comments()->save($reply); 
        $post->comments = $post->comments()->where('id', $request->parentId)->get();
        return $post;
    }

    public function update($request, $post)
    {

    }

    public function destroy($comment): bool
    {
        return $comment->delete();
    }

}