<?php 

namespace App\Services\Profile;

use App\Enums\CmnEnum;
use App\Http\Resources\Profile\ProfileResource; 
use App\Repositories\Profile\ProfileRepository; 
use App\Traits\Common\RespondsWithHttpStatus;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProfileService 
{
    use RespondsWithHttpStatus;
    /**
     * @var $profileRepository
     */
    protected $profileRepository;

    /**
     * ProfileService constructor. 
     * 
     * @param ProfileRepository $profileRepository
     */

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    protected function uploadImageWithResize($file, $paramFileName = null, $profile = null)
    {
        $rtrData['profilePhotoPath'] = null; 
        if($file) {  
            if($profile) { 
                Storage::delete(config('constants.path.storage_public') . '/' . config('constants.path.profile') . '/' . $profile->profilePhotoPath);
            } 

            if(!Storage::exists(config('constants.path.storage_public') . '/' . config('constants.path.profile'))) {
                Storage::makeDirectory(config('constants.path.storage_public') . '/' . config('constants.path.profile'));
            }

            $uniqueName = time() . '_' . $paramFileName .  '.' . $file->extension();
        
            $destinationPath = storage_path(config('constants.path.storage_app_public') . '/' . config('constants.path.profile'));
            $rtrData['profilePhotoPath'] = config('constants.path.profile') . '/' . $uniqueName;

            $img = Image::make($file->path());
            $img->resize(CmnEnum::THUMBNAIL_SQUARE_SIZE, CmnEnum::THUMBNAIL_SQUARE_SIZE, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $uniqueName); 
        }

        return $rtrData;
    }
     
    /**
     * Update post data
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function update($request)
    {

        $profile = Auth::user();
        $name = str_replace([' ','.'], ['_',''], $request->name ?? $profile->name);

        if ($request->has('photo')) {
            $data = $this->uploadImageWithResize($request->file('photo'), $name, $profile);
        
            $request->merge([ 
                'profilePhotoPath' => $data['profilePhotoPath'] ? $data['profilePhotoPath'] : null 
            ]); 
        }

        $result = $this->profileRepository->update($request, $profile);
        if($result) { 
            return $this->success(__('messages.crud.updated'), new ProfileResource($result));
        }  
        return $this->failure(__('messages.crud.updateFailed'));
    }
 
}