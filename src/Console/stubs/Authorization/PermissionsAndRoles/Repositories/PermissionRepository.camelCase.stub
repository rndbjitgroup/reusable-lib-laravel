<?php 

namespace App\Repositories\PermissionsAndRoles;

use App\Interfaces\PermissionsAndRoles\PermissionRepositoryInterface;
use App\Models\PermissionsAndRoles\Permission;
use Illuminate\Database\Eloquent\Collection;

class PermissionRepository implements PermissionRepositoryInterface
{
    /** 
     * @var Permission
     */
    protected $permission;

    /** 
     * PermissionRepository constructor.
     * 
     * @param Permission $post 
     */

    function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function getAll($request): Collection
    {
        return $this->permission
        ->when($request->searchText, function($q) use ($request) {
            return $q->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->searchText . '%')
                ->orWhere('display_title', 'like', '%' . $request->searchText . '%');
            });
        })   
        ->when($request->startDate, function($q) use ($request) {
            return $q->where('created_at', '>=', $request->startDate);
        })
        ->when($request->endDate, function($q) use ($request) {
            return $q->where('created_at', '<=', $request->endDate);
        })
        ->get();
    }

    public function get($permission): ?Permission
    {
        return $permission;
    }

    public function store($request): Permission
    {
        return $this->permission->create($request->all());
    }

    public function update($request, $permission): ?Permission
    {
        $permission->update($request->all());
        return $permission->fresh();
    }

    public function destroy($permission): bool
    {
        return $permission->delete();
    }
}