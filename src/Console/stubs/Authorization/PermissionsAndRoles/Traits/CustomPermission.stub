<?php 

namespace App\Traits\PermissionsAndRoles;

use App\Enums\CmnEnum;
use App\Models\PermissionsAndRoles\Role;
use Illuminate\Support\Facades\Auth;

trait CustomPermission 
{
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function getUserPermissions()
    {
        return [
            'user-store',
            'user-update',
            'user-delete'
        ]; 
    }

    public function isAdministrator()
    {
        $user = Auth::user(); 
        if(in_array(CmnEnum::ROLE_ADMIN, optional($user->roles->pluck('title', 'title'))->toArray())) {
            return true;
        }
        return false;
    }
}