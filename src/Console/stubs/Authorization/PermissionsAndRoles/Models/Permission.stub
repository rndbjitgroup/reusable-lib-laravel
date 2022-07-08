<?php

namespace App\Models\PermissionsAndRoles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Permission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'display_title'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role');
    }

}
