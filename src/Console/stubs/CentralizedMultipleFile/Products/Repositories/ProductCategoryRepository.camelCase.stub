<?php 

namespace App\Repositories\Products;

use App\Enums\CmnEnum;
use App\Models\Common\File;
use App\Models\Products\ProductCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductCategoryRepository
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

    public function getAll($request)
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
        ->paginate(config('constants.paginate'));
    } 

    public function get($productCategory)
    {
        return $productCategory;
    }

    function getOriginalFileName($fileRow)
    {
        $fileNameWithOurExt = pathinfo($fileRow->getClientOriginalName(), PATHINFO_FILENAME);
        return '_' . Str::limit($fileNameWithOurExt, CmnEnum::FILE_ORIGINAL_NAME_CHAR_LIMIT, '');
    }

    public function uploadFile($productCategory, $fileRaw, $existingFileName)
    {
        if (isset($fileRaw)) { 
            $filePath = config('constants.path.product_categories');
            $uniqueName = date('YmdHis'). uniqid() . '_' . $productCategory->id . $this->getOriginalFileName($fileRaw) . '.' . $fileRaw->extension();
           
            if (!Storage::exists(config('constants.path.storage_public') . '/' .$filePath)) {
                Storage::makeDirectory(config('constants.path.storage_public') . '/' .$filePath);
            }
  
            $fileData = [ 
                'name' => $uniqueName,
                'displayName' => $fileRaw->getClientOriginalName(), 
                'path' =>  $filePath,
            ];

            $existFile = '';
            if(!empty($existingFileName)) {
                $existFile = File::where('fileable_type', CmnEnum::PRODUCT_CATEGORY_FILEABLE_TYPE)
                        ->where('name', '=', $existingFileName)
                        ->first();
            }
            
            if ($existFile) { 
                if(Storage::exists(config('constants.path.storage_public') . '/' . $filePath . $existingFileName)) {
                    Storage::delete(config('constants.path.storage_public') . '/' . $filePath . $existingFileName);
                }

                $fileRaw->storeAs($filePath, $uniqueName, config('constants.path.storage_public'));
                return $existFile->update($fileData);
            } else { 
                $fileRaw->storeAs($filePath, $uniqueName, config('constants.path.storage_public'));
                $productCategoryFile = $productCategory->files()->create($fileData);
                if($productCategoryFile) { 
                    return true;
                }
            }
        }
        return false;
    }

    public function store($request)
    {
        $productCategory = $this->productCategory->create($request->all());
        return $productCategory->fresh();
    }

    public function update($request, $productCategory)
    {
        $productCategory->update($request->all());
        return $productCategory->fresh();
    }

    public function destroy($productCategory)
    {
        $productCategory->files()->delete();
        return $productCategory->delete();
    }

    public function destroyProductCategoryFile($request, $productCategory)
    {
        if($request->has('existingFilename')) { 
            return $productCategory->files()->where('name', $request->existing_filename)->delete();
        }
        return $productCategory->files()->delete();
    }

}