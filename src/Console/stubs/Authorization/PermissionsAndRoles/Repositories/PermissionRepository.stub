<?php 

namespace App\Repositories\PermissionsAndRoles;

use App\Models\PermissionsAndRoles\Permission;

class PermissionRepository 
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

    public function getAll($request)
    {
        return $this->permission
        ->when($request->search_text, function($q) use ($request) {
            return $q->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search_text . '%')
                ->orWhere('display_title', 'like', '%' . $request->search_text . '%');
            });
        })   
        ->when($request->start_date, function($q) use ($request) {
            return $q->where('created_at', '>=', $request->start_date);
        })
        ->when($request->end_date, function($q) use ($request) {
            return $q->where('created_at', '<=', $request->end_date);
        })
        ->get();
    }

    public function get($permission)
    {
        return $permission;
    }

    public function store($request)
    {
        return $this->permission->create($request->all());
    }

    public function update($request, $permission)
    {
        $permission->update($request->all());
        return $permission->fresh();
    }

    public function destroy($permission)
    {
        return $permission->delete();
    }
}