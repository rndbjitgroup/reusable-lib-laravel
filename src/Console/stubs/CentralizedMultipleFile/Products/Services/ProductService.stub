<?php 

namespace App\Services\Products;

use App\Http\Resources\Products\ProductCollection;
use App\Http\Resources\Products\ProductResource;
use App\Repositories\Products\ProductRepository;
use App\Traits\Common\RespondsWithHttpStatus;
use Illuminate\Http\Response; 
use Illuminate\Support\Str; 

class ProductService 
{
    use RespondsWithHttpStatus;
    /**
     * @var $productRepository
     */
    protected $productRepository;

    /**
     * ProductService constructor. 
     * 
     * @param ProductRepository $productRepository
     */

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAll($request)
    {
        return $this->success('',  new ProductCollection($this->productRepository->getAll($request)));
    } 

    /**
     * Get product by id.
     *
     * @param $id
     * @return String
     */
    public function get($product)
    {
        return $this->success('', new ProductResource($product));
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
        //dd($request->all());

        $request->merge([
            'slug' => Str::slug($request->title), 
        ]); 

        $product = $this->productRepository->store($request);
        if($product) {
            if ($request->hasFile('filenames')) { 
                foreach($request->filenames as $filename) {
                    $this->productRepository->uploadFile($product, $filename, $request->existing_filename ?? null);
                }
            }
            return $this->success(__('messages.crud.stored'), new ProductResource($product), Response::HTTP_CREATED);
        }
        return $this->failure( __('messages.crud.storeFailed'));
    }

     
    /**
     * Update post data
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function update($request, $product)
    {
        $request->merge([
            'slug' => Str::slug($request->title ?? $product->title), 
        ]); 

        $product = $this->productRepository->update($request, $product);
        if ($product) {
            if ($request->hasFile('filenames')) { 
                $this->productRepository->deleteProductFiles($product);
                foreach ($request->filenames as $filename) {
                    $this->productRepository->uploadFile($product, $filename, $request->existing_filename ?? null);
                }
            }
            return $this->success(__('messages.crud.updated'), new ProductResource($product));
        }  
        return $this->failure(__('messages.crud.updateFailed'));
    }
 
    /**
     * Delete post by id.
     *
     * @param $id
     * @return String
     */
    public function destroy($product)
    {
        $result = $this->productRepository->destroy($product);
        if($result) {
            return $this->success(__('messages.crud.deleted'));
            //return $this->success(__('messages.crud.deleted'), [], Response::HTTP_NO_CONTENT);
        }
        return $this->failure(__('messages.crud.deleteFailed'));
    }

}