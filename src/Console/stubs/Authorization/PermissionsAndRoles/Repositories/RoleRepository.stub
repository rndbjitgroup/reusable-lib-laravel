<?php 

namespace App\Repositories\PermissionsAndRoles;

use App\Models\PermissionsAndRoles\Role;

class RoleRepository 
{
    /** 
     * @var Role
     */
    protected $role;

    /** 
     * RoleRepository constructor.
     * 
     * @param Role $post 
     */

    function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function getAll($request)
    {
        return $this->role
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

    public function get($role)
    {
        return $role;
    }

    public function store($request)
    {
        $role = $this->role->create($request->all());
        $role->permissions()->attach($request->permissions);
        return $role->fresh();
    }

    public function update($request, $role)
    {
        $role->update($request->all());
        $role->permissions()->sync($request->permissions);
        return $role->fresh();
    }

    public function destroy($role)
    {
        return $role->delete();
    }
}