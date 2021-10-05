<?php 

namespace App\Services\Profile;

use App\Enums\CmnEnum;
use App\Http\Resources\Profile\ProfileResource;
use App\Repositories\Profile\ChangePasswordRepository; 
use App\Traits\Common\RespondsWithHttpStatus;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ChangePasswordService 
{
    use RespondsWithHttpStatus;
    /**
     * @var $changePasswordRepository
     */
    protected $changePasswordRepository;

    /**
     * ChangePasswordService constructor. 
     * 
     * @param ChangePasswordRepository $changePasswordRepository
     */

    public function __construct(ChangePasswordRepository $changePasswordRepository)
    {
        $this->changePasswordRepository = $changePasswordRepository;
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
        $user = Auth::user();
        $request->merge([
            'password' => Hash::make($request->newPassword)
        ]);
        $result = $this->changePasswordRepository->update($request, $user);
        if($result) { 
            return $this->success(__('messages.crud.updated'));
        }  
        return $this->failure(__('messages.crud.updateFailed'));
    }
 
}