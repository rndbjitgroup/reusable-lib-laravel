<?php 

namespace App\Services\PermissionsAndRoles;

use App\Http\Resources\PermissionsAndRoles\PermissionCollection;
use App\Http\Resources\PermissionsAndRoles\PermissionResource;
use App\Repositories\PermissionsAndRoles\PermissionRepository;
use App\Traits\Common\RespondsWithHttpStatus;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class PermissionService 
{
    use RespondsWithHttpStatus;
    /**
     * @var $permissionRepository
     */
    protected $permissionRepository;

    /**
     * permissionService constructor. 
     * 
     * @param PermissionRepository $permissionRepository
     */

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function getAll($request)
    {
        return $this->success('',  new PermissionCollection($this->permissionRepository->getAll($request)));
    } 

    /**
     * Get permission by id.
     *
     * @param $id
     * @return String
     */
    public function get($permission)
    {
        return $this->success('', new PermissionResource($permission));
    }

    /**
     * Validate permission data.
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function store($request)
    {
        $request->merge([
            'title' => Str::slug($request->displayTitle)
        ]);
        $result = $this->permissionRepository->store($request);
        if($result) {
            return $this->success(__('messages.crud.stored'), new PermissionResource($result), Response::HTTP_CREATED);
        }
        return $this->failure( __('messages.crud.storeFailed'));
    }

     
    /**
     * Update permission data
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function update($request, $permission)
    {
        $request->merge([
            'title' => Str::slug($request->displayTitle)
        ]);
        $result = $this->permissionRepository->update($request, $permission);
        if($result) {
            return $this->success(__('messages.crud.updated'), new PermissionResource($result));
        }  
        return $this->failure(__('messages.crud.updateFailed'));
    }
 
    /**
     * Delete permission by id.
     *
     * @param $id
     * @return String
     */
    public function destroy($permission)
    {
        $result = $this->permissionRepository->destroy($permission);
        if($result) {
            return $this->success(__('messages.crud.deleted')); 
        }
        return $this->failure(__('messages.crud.deleteFailed'));
    }

}