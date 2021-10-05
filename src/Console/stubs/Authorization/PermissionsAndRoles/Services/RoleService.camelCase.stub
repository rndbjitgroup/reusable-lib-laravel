<?php 

namespace App\Services\PermissionsAndRoles;

use App\Http\Resources\PermissionsAndRoles\RoleCollection;
use App\Http\Resources\PermissionsAndRoles\RoleResource;
use App\Repositories\PermissionsAndRoles\RoleRepository;
use App\Traits\Common\RespondsWithHttpStatus;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class RoleService 
{
    use RespondsWithHttpStatus;
    /**
     * @var $roleRepository
     */
    protected $roleRepository;

    /**
     * roleService constructor. 
     * 
     * @param RoleRepository $roleRepository
     */

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getAll($request)
    {
        return $this->success('',  new RoleCollection($this->roleRepository->getAll($request)));
    } 

    /**
     * Get role by id.
     *
     * @param $id
     * @return String
     */
    public function get($role)
    {
        return $this->success('', new RoleResource($role));
    }

    /**
     * Validate role data.
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
        $result = $this->roleRepository->store($request);
        if($result) {
            return $this->success(__('messages.crud.stored'), new RoleResource($result), Response::HTTP_CREATED);
        }
        return $this->failure( __('messages.crud.storeFailed'));
    }

    /**
     * Update role data
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function update($request, $role)
    {
        $request->merge([
            'title' => Str::slug($request->displayTitle)
        ]);
        $result = $this->roleRepository->update($request, $role);
        if($result) {
            return $this->success(__('messages.crud.updated'), new RoleResource($result));
        }  
        return $this->failure(__('messages.crud.updateFailed'));
    }
 
    /**
     * Delete role by id.
     *
     * @param $id
     * @return String
     */
    public function destroy($role)
    {
        $result = $this->roleRepository->destroy($role);
        if($result) {
            return $this->success(__('messages.crud.deleted'));
            //return $this->success(__('messages.crud.deleted'), [], Response::HTTP_NO_CONTENT);
        }
        return $this->failure(__('messages.crud.deleteFailed'));
    }

}