<?php 

namespace App\Repositories\PermissionsAndRoles;

use App\Interfaces\PermissionsAndRoles\RoleRepositoryInterface;
use App\Models\PermissionsAndRoles\Role;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository implements RoleRepositoryInterface
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

    public function getAll($request): Collection
    {
        return $this->role
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

    public function get($role): ?Role
    {
        return $role;
    }

    public function store($request): Role
    {
        $role = $this->role->create($request->all());
        $role->permissions()->attach($request->permissions);
        return $role->fresh();
    }

    public function update($request, $role): ?Role
    {
        $role->update($request->all());
        $role->permissions()->sync($request->permissions);
        return $role->fresh();
    }

    public function destroy($role): bool
    {
        return $role->delete();
    }
}