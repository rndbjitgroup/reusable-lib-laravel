<?php

namespace App\Models\PermissionsAndRoles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BaseModel;

class Permission extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'displayTitle'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role');
    }

}
