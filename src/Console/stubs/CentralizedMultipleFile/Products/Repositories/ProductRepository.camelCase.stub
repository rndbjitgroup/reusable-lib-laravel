<?php 

namespace App\Repositories\Products;

use App\Enums\CmnEnum;
use App\Interfaces\Products\ProductRepositoryInterface;
use App\Models\Common\File;
use App\Models\Products\Product;
use App\Models\Products\Tag;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class ProductRepository implements ProductRepositoryInterface
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

    public function getAll($request): LengthAwarePaginator
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

    public function get($product): ?Product
    {
        return $product;
    }

    private function getOriginalFileName($fileRow): String
    {
        $fileNameWithOurExt = pathinfo($fileRow->getClientOriginalName(), PATHINFO_FILENAME);
        return '_' . Str::limit($fileNameWithOurExt, CmnEnum::FILE_ORIGINAL_NAME_CHAR_LIMIT, '');
    }

    public function uploadFile($product, $fileRaw): bool
    {
        if (isset($fileRaw)) { 
            $filePath = config('constants.path.products.normals');
            $thumpPath = config('constants.path.products.thumbnails');
            $uniqueName = date('YmdHis'). uniqid() . '_' . $product->id . $this->getOriginalFileName($fileRaw) . '.' . $fileRaw->extension();
             
            if(!Storage::exists($filePath)) {
                Storage::makeDirectory($filePath);
            }

            if(!Storage::exists($thumpPath)) {
                Storage::makeDirectory($thumpPath);
            }
  
            $fileData = [ 
                'name' => $uniqueName,
                'displayName' => $fileRaw->getClientOriginalName(), 
                'path' => $filePath,
                'thumbPath' => $thumpPath,
            ];  

            $fileRaw->storeAs($filePath, $uniqueName, config('constants.filesystem_disk'));

            $resizeImage = Image::read($fileRaw->path());
            $resizeImage->resize(CmnEnum::THUMBNAIL_SQUARE_SIZE, CmnEnum::THUMBNAIL_SQUARE_SIZE, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path(config('constants.path.storage_app_local') . '/' . $thumpPath . '/' . $uniqueName));

            $productFile = $product->files()->create($fileData);
            if($productFile) { 
                return true;
            }
        }
        return false;
    }

    private function storeOrUpdateTags($request, $product): void
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

    public function store($request): Product
    {
        $product = $this->product->create($request->all());
        $this->storeOrUpdateTags($request, $product);
        return $product->fresh();
    }

    public function update($request, $product): ?Product
    {
        $product->update($request->all()); 
        $this->storeOrUpdateTags($request, $product);
        return $product->fresh(); 
    }

    public function destroy($product): bool
    {
        $this->deleteProductFiles($product);
        //$product->files()->delete();
        $product->tags()->sync([]);
        return $product->delete();
    }

    public function deleteProductFiles($product): bool
    {
        if($product->files) {
            foreach($product->files as $productFile) {
                Storage::delete($productFile->path . '/' . $productFile->name);
                Storage::delete($productFile->thumbPath . '/' . $productFile->name);
            }
            $product->files()->delete();
        }
        return true;
    }

}