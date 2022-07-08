<?php 

namespace App\Repositories\Blogs;

use App\Models\Blogs\Post;
use Illuminate\Support\Str;

class PostRepository
{
    /** 
     * @var Post
     */
    protected $post;

    /** 
     * LoginRepository constructor.
     * 
     * @param Post $post 
     */

    function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function getAll($request)
    {
        return $this->post
        ->when($request->search_text, function($q) use ($request) {
            return $q->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search_text . '%')
                ->orWhere('slug', 'like', '%' . $request->search_text . '%');
            });
        }) 
        ->when($request->start_date, function($q) use ($request) {
            return $q->where('created_at', '>=', $request->start_date);
        })
        ->when($request->end_date, function($q) use ($request) {
            return $q->where('created_at', '<=', $request->end_date);
        })
        ->latest()
        ->paginate(config('constants.paginate'));
    } 

    public function get($post)
    {
        return $post;
    }

    public function store($request)
    {
        $post = $this->post->create($request->all());
        return $post->fresh();
    }

    public function update($request, $post)
    {
        $post->update($request->all());
        return $post->fresh();
    }

    public function destroy($post)
    {
        foreach ($post->comments as $comment) { 
            $comment->replies()->delete();
        }  
        $post->comments()->delete();
        return $post->delete();
    }

}