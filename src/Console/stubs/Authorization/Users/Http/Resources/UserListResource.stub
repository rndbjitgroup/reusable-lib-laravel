<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\PermissionsAndRoles\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id, 
            'name' => $this->name,
            'email' => $this->email, 
        ];
    }
}
