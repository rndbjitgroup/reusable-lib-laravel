<?php 

namespace App\Services\Products;

use App\Http\Resources\Products\ProductCategoryCollection;
use App\Http\Resources\Products\ProductCategoryResource; 
use App\Repositories\Products\ProductCategoryRepository; 
use App\Traits\Common\RespondsWithHttpStatus;
use Illuminate\Http\Response; 
use Illuminate\Support\Str; 

class ProductCategoryService 
{
    use RespondsWithHttpStatus;
    /**
     * @var $productCategoryRepository
     */
    protected $productCategoryRepository;

    /**
     * CategoryService constructor. 
     * 
     * @param ProductCategoryRepository $productCategoryRepository
     */

    public function __construct(ProductCategoryRepository $productCategoryRepository)
    {
        $this->productCategoryRepository = $productCategoryRepository;
    }

    public function getAll($request)
    {
        return $this->success('',  new ProductCategoryCollection($this->productCategoryRepository->getAll($request)));
    } 

    /**
     * Get category by id.
     *
     * @param $id
     * @return String
     */
    public function get($productCategory)
    {
        return $this->success('', new ProductCategoryResource($productCategory));
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
            'slug' => Str::slug($request->title), 
        ]);

        $productCategory = $this->productCategoryRepository->store($request);
        if($productCategory) {
            if ($request->hasFile('filename')) { 
                $this->productCategoryRepository->uploadFile($productCategory, $request->filename, $request->existing_filename ?? null);
            }
            return $this->success(__('messages.crud.stored'), new ProductCategoryResource($productCategory), Response::HTTP_CREATED);
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
    public function update($request, $productCategory)
    {
        $request->merge([
            'slug' => Str::slug($request->title ?? $productCategory->title), 
        ]);

        if($request->has('is_file_deleted') && $request->is_file_deleted) {
            $this->productCategoryRepository->destroyProductCategoryFile($request, $productCategory);
        }
        //dd($request->all());
        $productCategory = $this->productCategoryRepository->update($request, $productCategory);
        if($productCategory) {
            if ($request->hasFile('filename')) { 
                $this->productCategoryRepository->uploadFile($productCategory, $request->filename, $request->existing_filename ?? null);
            }
            return $this->success(__('messages.crud.updated'), new ProductCategoryResource($productCategory));
        }  
        return $this->failure(__('messages.crud.updateFailed'));
    }
 
    /**
     * Delete category by id.
     *
     * @param $id
     * @return String
     */
    public function destroy($productCategory)
    {
        $result = $this->productCategoryRepository->destroy($productCategory);
        if($result) {
            return $this->success(__('messages.crud.deleted'));
            //return $this->success(__('messages.crud.deleted'), [], Response::HTTP_NO_CONTENT);
        }
        return $this->failure(__('messages.crud.deleteFailed'));
    }

}