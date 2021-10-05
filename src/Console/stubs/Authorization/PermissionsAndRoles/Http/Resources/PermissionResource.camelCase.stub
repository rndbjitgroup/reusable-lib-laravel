<?php

namespace App\Http\Resources\PermissionsAndRoles;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
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
            'title' => $this->title,
            'displayTitle' => $this->display_title,
        ];
    }
}
