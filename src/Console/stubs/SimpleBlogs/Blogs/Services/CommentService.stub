<?php 

namespace App\Services\Blogs;

use App\Http\Resources\Blogs\CommentCollection;
use App\Http\Resources\Blogs\CommentResource;
use App\Http\Resources\Blogs\PostResource;
use App\Repositories\Blogs\CommentRepository; 
use App\Traits\Common\RespondsWithHttpStatus;
use Illuminate\Http\Response;

class CommentService 
{
    use RespondsWithHttpStatus;
    /**
     * @var $commentRepository
     */
    protected $commentRepository;

    /**
     * CommentService constructor. 
     * 
     * @param CommentRepository $commentRepository
     */

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function getAll($request)
    {
        return $this->success('',  new CommentCollection($this->commentRepository->getAll($request)));
    }

    public function list($request)
    {
        return $this->success('', ['data' => $this->commentRepository->list($request)]);
    }

    /**
     * Get comment by id.
     *
     * @param $id
     * @return String
     */
    public function get($comment)
    {
        return $this->success('', new CommentResource($comment));
    }

    /**
     * Validate comment data.
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function store($request, $post)
    {
        $result = $this->commentRepository->store($request, $post);
        if($result) {
            return $this->success(__('messages.crud.stored'), new PostResource($result), Response::HTTP_CREATED);
        }
        return $this->failure( __('messages.crud.storeFailed'));
    }

    public function storeReply($request, $post)
    {
        $result = $this->commentRepository->storeReply($request, $post);
        if($result) {
            return $this->success(__('messages.crud.stored'), new PostResource($result), Response::HTTP_CREATED);
        }
        return $this->failure( __('messages.crud.storeFailed'));
    }

     
    /**
     * Update comment data
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function update($request, $comment)
    {
        $result = $this->commentRepository->update($request, $comment);
        if($result) {
            return $this->success(__('messages.crud.updated'), new CommentResource($result));
        }  
        return $this->failure(__('messages.crud.updateFailed'));
    }
 
    /**
     * Delete comment by id.
     *
     * @param $id
     * @return String
     */
    public function destroy($comment)
    {
        $result = $this->commentRepository->destroy($comment);
        if($result) {
            return $this->success(__('messages.crud.deleted'));
            //return $this->success(__('messages.crud.deleted'), [], Response::HTTP_NO_CONTENT);
        }
        return $this->failure(__('messages.crud.deleteFailed'));
    }

}