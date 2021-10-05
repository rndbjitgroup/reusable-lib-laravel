<?php

namespace App\Http\Resources\PermissionsAndRoles;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    private static $data;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $rtrData = [
            'id' => $this->id, 
            'title' => $this->title,
            'displayTitle' => $this->display_title,
            //'permissions' => PermissionResource::collection($this->permissions)
        ];
        if (!isset(self::$data['hidePermission'])) {
            $rtrData['permissions'] = PermissionResource::collection($this->permissions);
        }
        return $rtrData;
    }
 
    public static function customCollection($resource, $data): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    { 
        self::$data = $data; 
        return parent::collection($resource);
    }
}
