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
        ->when($request->searchText, function($q) use ($request) {
            return $q->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->searchText . '%')
                ->orWhere('slug', 'like', '%' . $request->searchText . '%');
            });
        }) 
        ->when($request->startDate, function($q) use ($request) {
            return $q->where('created_at', '>=', $request->startDate);
        })
        ->when($request->endDate, function($q) use ($request) {
            return $q->where('created_at', '<=', $request->endDate);
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