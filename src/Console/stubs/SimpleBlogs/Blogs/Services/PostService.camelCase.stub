<?php 

namespace App\Services\Blogs;

use App\Enums\CmnEnum;
use App\Http\Resources\Blogs\PostCollection;
use App\Http\Resources\Blogs\PostResource;  
use App\Repositories\Blogs\PostRepository;
use App\Traits\Common\RespondsWithHttpStatus;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostService 
{
    use RespondsWithHttpStatus;
    /**
     * @var $postRepository
     */
    protected $postRepository;

    /**
     * PostService constructor. 
     * 
     * @param PostRepository $postRepository
     */

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getAll($request)
    {
        return $this->success('',  new PostCollection($this->postRepository->getAll($request)));
    } 

    /**
     * Get post by id.
     *
     * @param $id
     * @return String
     */
    public function get($post)
    {
        return $this->success('', new PostResource($post));
    }


    protected function uploadImage($file, $paramFileName = null)
    {
        $rtrData['imagePath'] = null;
        if($file) { 
            $imageName = $paramFileName . '.' . $file->extension();
            $file->storeAs(config('constants.path.posts.normals'), $imageName);  
            $rtrData['imagePath'] = $imageName;
        }
        return $rtrData;
    }

    protected function uploadImageWithResize($file, $paramFileName = null, $post = null)
    {
        $rtrData['imagePath'] = null;
        $rtrData['thumbnailPath'] = null;
        if($file) {  
            if($post) {
                Storage::delete(config('constants.path.storage_public') . '/' . $post->image_path);
                Storage::delete(config('constants.path.storage_public') . '/' . $post->thumbnail_path);
            }
            
            if(!Storage::exists(config('constants.path.storage_public') . '/' . config('constants.path.posts.normals'))) {
                Storage::makeDirectory(config('constants.path.storage_public') . '/' . config('constants.path.posts.normals'));
            }

            if(!Storage::exists(config('constants.path.storage_public') . '/' . config('constants.path.posts.thumbnails'))) {
                Storage::makeDirectory(config('constants.path.storage_public') . '/' . config('constants.path.posts.thumbnails'));
            }

            $uniqueName = time() . '_' . $paramFileName .  '.' . $file->extension();
        
            $destinationPath = storage_path(config('constants.path.storage_app_public') . '/' . config('constants.path.posts.thumbnails'));
            $rtrData['thumbnailPath'] = config('constants.path.posts.thumbnails') . '/' . $uniqueName;

            $img = Image::make($file->path());
            $img->resize(CmnEnum::THUMBNAIL_SQUARE_SIZE, CmnEnum::THUMBNAIL_SQUARE_SIZE, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $uniqueName);
    
            $destinationPath = storage_path(config('constants.path.storage_app_public') . '/' . config('constants.path.posts.normals'));
            $rtrData['imagePath'] = config('constants.path.posts.normals') . '/' . $uniqueName;
            $file->move($destinationPath, $rtrData['imagePath']);
        }

        return $rtrData;
    }

    /**
     * Validate post data.
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function store($request)
    {

        $slug = Str::slug($request->title);
        
        $data = $this->uploadImageWithResize($request->file('image'), $slug);
        
        $request->merge([
            'slug' => $slug,
            'imagePath' => $data['imagePath'] ?? null,
            'thumbnailPath' => $data['thumbnailPath'] ?? null 
        ]); 

        $result = $this->postRepository->store($request);
        if(!$result) {
            return $this->failure( __('messages.crud.storeFailed'));
        }
        return $this->success(__('messages.crud.stored'), new PostResource($result), Response::HTTP_CREATED);
    }

     
    /**
     * Update post data
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function update($request, $post)
    {
        $slug = Str::slug($request->title);
        
        $data = $this->uploadImageWithResize($request->file('image'), $slug, $post);
        
        $request->merge([
            'slug' => $slug,
            'imagePath' => $data['imagePath'] ?? null,
            'thumbnailPath' => $data['thumbnailPath'] ?? null 
        ]); 

        $result = $this->postRepository->update($request, $post);
        if($result) {
            return $this->success(__('messages.crud.updated'), new PostResource($result));
        }  
        return $this->failure(__('messages.crud.updateFailed'));
    }
 
    /**
     * Delete post by id.
     *
     * @param $id
     * @return String
     */
    public function destroy($post)
    {
        $result = $this->postRepository->destroy($post);
        if($result) {
            return $this->success(__('messages.crud.deleted'));
            //return $this->success(__('messages.crud.deleted'), [], Response::HTTP_NO_CONTENT);
        }
        return $this->failure(__('messages.crud.deleteFailed'));
    }

}