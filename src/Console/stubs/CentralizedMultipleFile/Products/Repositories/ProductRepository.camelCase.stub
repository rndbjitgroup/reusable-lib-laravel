<?php 

namespace App\Repositories\Products;

use App\Enums\CmnEnum;
use App\Models\Common\File;
use App\Models\Products\Product;
use App\Models\Products\Tag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProductRepository
{
    /** 
     * @var Product
     */
    protected $product;

    /** 
     * LoginRepository constructor.
     * 
     * @param Product $product 
     */

    function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getAll($request)
    {
        return $this->product
        ->when($request->searchText, function($q) use ($request) {
            return $q->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->searchText . '%')
                ->orWhere('slug', 'like', '%' . $request->searchText . '%');
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

    public function get($product)
    {
        return $product;
    }

    function getOriginalFileName($fileRow)
    {
        $fileNameWithOurExt = pathinfo($fileRow->getClientOriginalName(), PATHINFO_FILENAME);
        return '_' . Str::limit($fileNameWithOurExt, CmnEnum::FILE_ORIGINAL_NAME_CHAR_LIMIT, '');
    }

    public function uploadFile($product, $fileRaw, $existingFileName)
    {
        if (isset($fileRaw)) { 
            $filePath = config('constants.path.products.normals');
            $thumpPath = config('constants.path.products.thumbnails');
            $uniqueName = date('YmdHis'). uniqid() . '_' . $product->id . $this->getOriginalFileName($fileRaw) . '.' . $fileRaw->extension();
             
            // if($product->files) {
            //     foreach($product->files as $productFile) {
            //         Storage::delete(config('constants.path.storage_public') . '/' . $filePath . '/' . $productFile->name);
            //         Storage::delete(config('constants.path.storage_public') . '/' . $thumpPath . '/' . $productFile->name);
            //     }
            //     $product->files()->delete();
            // }
            
            if(!Storage::exists(config('constants.path.storage_public') . '/' . $filePath)) {
                Storage::makeDirectory(config('constants.path.storage_public') . '/' . $filePath);
            }

            if(!Storage::exists(config('constants.path.storage_public') . '/' . $thumpPath)) {
                Storage::makeDirectory(config('constants.path.storage_public') . '/' . $thumpPath);
            }
  
            $fileData = [ 
                'name' => $uniqueName,
                'displayName' => $fileRaw->getClientOriginalName(), 
                'path' => $filePath,
                'thumbPath' => $thumpPath,
            ]; 

            // $existFile = '';
            // if(!empty($existingFileName)) {
            //     $existFile = File::where('fileable_type', CmnEnum::PRODUCT_FILEABLE_TYPE)
            //             ->where('name', '=', $existingFileName)
            //             ->first();
            // }
            
            // if ($existFile) { 
            //     // if(Storage::exists(CmnEnum::FILE_STORAGE_DISK . $filePath . $existingFileName)) {
            //     //     Storage::delete(CmnEnum::FILE_STORAGE_DISK . $filePath . $existingFileName);
            //     // }

            //     $fileRaw->storeAs($filePath, $uniqueName, CmnEnum::FILE_STORAGE_DISK);

            //     $resizeImage = Image::make($fileRaw->path());
            //     $resizeImage->resize(CmnEnum::THUMBNAIL_SQUARE_SIZE, CmnEnum::THUMBNAIL_SQUARE_SIZE, function ($constraint) {
            //         $constraint->aspectRatio();
            //     })->save(storage_path(config('constants.path.storage_app_public') . '/' . $thumpPath . '/' . $uniqueName));

            //     return $existFile->update($fileData);
            // } else { 

                $fileRaw->storeAs($filePath, $uniqueName, CmnEnum::FILE_STORAGE_DISK);

                $resizeImage = Image::make($fileRaw->path());
                $resizeImage->resize(CmnEnum::THUMBNAIL_SQUARE_SIZE, CmnEnum::THUMBNAIL_SQUARE_SIZE, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path(config('constants.path.storage_app_public') . '/' . $thumpPath . '/' . $uniqueName));

                $productFile = $product->files()->create($fileData);
                if($productFile) { 
                    return true;
                }
            //}
        }
        return false;
    }

    private function storeOrUpdateTags($request, $product)
    {
        $tagIds = [];
        if (!empty($request->tags)) {
            foreach ($request->tags as $tagName) {
                if(!$tagName) {
                    continue;
                }

                $tag = Tag::firstOrCreate([
                    'title'=> $tagName, 'slug' => Str::slug($tagName)
                ]);
                
                if($tag) {
                    $tagIds[] = $tag->id;
                }
            }
            $product->tags()->syncWithoutDetaching($tagIds);
        }
    }
    public function store($request)
    {
        $product = $this->product->create($request->all());
        $this->storeOrUpdateTags($request, $product);
        return $product->fresh();
    }

    public function update($request, $product)
    {
        $product->update($request->all()); 
        $this->storeOrUpdateTags($request, $product);
        return $product->fresh(); 
    }

    public function destroy($product)
    {
        $product->files()->delete();
        $product->tags()->sync([]);
        return $product->delete();
    }

    public function deleteProductFiles($product)
    {
        $filePath = config('constants.path.products.normals');
        $thumpPath = config('constants.path.products.thumbnails');
        if($product->files) {
            foreach($product->files as $productFile) {
                Storage::delete(config('constants.path.storage_public') . '/' . $filePath . '/' . $productFile->name);
                Storage::delete(config('constants.path.storage_public') . '/' . $thumpPath . '/' . $productFile->name);
            }
            $product->files()->delete();
        }
    }

}