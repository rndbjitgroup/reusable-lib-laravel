<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\PermissionsAndRoles\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id, 
            'name' => $this->name,
            'email' => $this->email,
            'roles' => RoleResource::customCollection($this->roles, ['hidePermission' => true])
        ];
    }
}
