<?php 

namespace App\Services\Blogs;

use App\Http\Resources\Blogs\CategoryCollection;
use App\Http\Resources\Blogs\CategoryResource; 
use App\Repositories\Blogs\CategoryRepository; 
use App\Traits\Common\RespondsWithHttpStatus;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class CategoryService 
{
    use RespondsWithHttpStatus;
    /**
     * @var $categoryRepository
     */
    protected $categoryRepository;

    /**
     * CategoryService constructor. 
     * 
     * @param CategoryRepository $categoryRepository
     */

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAll($request)
    {
        return $this->success('',  new CategoryCollection($this->categoryRepository->getAll($request)));
    } 

    /**
     * Get category by id.
     *
     * @param $id
     * @return String
     */
    public function get($category)
    {
        return $this->success('', new CategoryResource($category));
    }

    /**
     * Validate category data.
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function store($request)
    {
        $request->merge([
            'slug' => Str::slug($request->title)
        ]);
        
        $result = $this->categoryRepository->store($request);
        if($result) {
            return $this->success(__('messages.crud.stored'), new CategoryResource($result), Response::HTTP_CREATED);
        }
        return $this->failure( __('messages.crud.storeFailed'));
    }

     
    /**
     * Update postCategory data
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function update($request, $category)
    {
        $request->merge([
            'slug' => Str::slug($request->title)
        ]);

        $result = $this->categoryRepository->update($request, $category);
        if($result) {
            return $this->success(__('messages.crud.updated'), new CategoryResource($result));
        }  
        return $this->failure(__('messages.crud.updateFailed'));
    }
 
    /**
     * Delete category by id.
     *
     * @param $id
     * @return String
     */
    public function destroy($category)
    {
        $result = $this->categoryRepository->destroy($category);
        if($result) {
            return $this->success(__('messages.crud.deleted'));
            //return $this->success(__('messages.crud.deleted'), [], Response::HTTP_NO_CONTENT);
        }
        return $this->failure(__('messages.crud.deleteFailed'));
    }

}