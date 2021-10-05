<?php

namespace App\Http\Resources\Profile;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'contact_no' => $this->contact_no, 
            'base_path' => config('app.url') . '/' . config('constants.path.storage'),
            'profile_photo_path' => $this->profile_photo_path,    
            'created_at' => $this->created_at, 
            'updated_at' => $this->updated_at, 
        ];
    }
}
