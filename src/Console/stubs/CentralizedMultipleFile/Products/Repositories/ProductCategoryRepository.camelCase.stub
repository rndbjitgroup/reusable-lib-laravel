<?php 

namespace App\Repositories\Products;

use App\Enums\CmnEnum;
use App\Interfaces\Products\ProductCategoryRepositoryInterface;
use App\Models\Common\File;
use App\Models\Products\ProductCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductCategoryRepository implements ProductCategoryRepositoryInterface
{
    /** 
     * @var ProductCategory
     */
    protected $productCategory;

    /** 
     * ProductCategoryRepository constructor.
     * 
     * @param ProductCategory $productCategory 
     */

    function __construct(ProductCategory $productCategory)
    {
        $this->productCategory = $productCategory;
    }

    public function getAll($request): Collection
    {
        return $this->productCategory
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
        ->get();
    } 

    public function get($productCategory): ?ProductCategory
    {
        return $productCategory;
    }

    private function getOriginalFileName($fileRow): String
    {
        $fileNameWithOurExt = pathinfo($fileRow->getClientOriginalName(), PATHINFO_FILENAME);
        return '_' . Str::limit($fileNameWithOurExt, CmnEnum::FILE_ORIGINAL_NAME_CHAR_LIMIT, '');
    }

    public function uploadFile($productCategory, $fileRaw): bool
    {
         if (isset($fileRaw)) { 
            $filePath = config('constants.path.product_categories');
            $uniqueName = date('YmdHis'). uniqid() . '_' . $productCategory->id . $this->getOriginalFileName($fileRaw) . '.' . $fileRaw->extension();
           
            if (!Storage::exists($filePath)) {
                Storage::makeDirectory($filePath);
            }
  
            $fileData = [ 
                'name' => $uniqueName,
                'displayName' => $fileRaw->getClientOriginalName(), 
                'path' =>  $filePath,
            ];

            $fileRaw->storeAs($filePath, $uniqueName, config('constants.filesystem_disk'));
            $productCategoryFile = $productCategory->files()->create($fileData);
            if($productCategoryFile) { 
                return true;
            }
        }
        return false;
    }

    public function store($request): ProductCategory
    {
        $productCategory = $this->productCategory->create($request->all());
        return $productCategory->fresh();
    }

    public function update($request, $productCategory): ?ProductCategory
    {
        $productCategory->update($request->all());
        return $productCategory->fresh();
    }

    public function destroy($productCategory): bool
    {
        if($productCategory->files) {
            foreach($productCategory->files as $productCategoryFile) {
                Storage::delete($productCategoryFile->path . '/' . $productCategoryFile->name); 
            }
        }
        $productCategory->files()->delete();
        return $productCategory->delete();
    }

    public function destroyProductCategoryFile($request, $productCategory): bool
    {
        $filePath = config('constants.path.product_categories');
        if($request->has('existingFilename')) { 
            if(Storage::exists($filePath . '/' . $request->existingFilename)) {
                Storage::delete($filePath . '/' . $request->existingFilename);
            }
            return $productCategory->files()->where('name', $request->existingFilename)->delete();
        }
        return $productCategory->files()->delete();
    }

}