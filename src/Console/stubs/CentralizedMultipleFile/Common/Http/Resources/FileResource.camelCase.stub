<?php

namespace App\Http\Resources\Common;

use App\Enums\CmnEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // $path = ''; 
        // if(!empty($this->path)) {
        //     $path = getCustomEnv('AWS_S3_BASE_URL') . '/' . $this->path;
        //     if((strpos($this->path, "https://") !== false) || (strpos($this->path, "http://") !== false)) $path = $this->path;            
        // }

        return [
            'baseUrl' => url('/') . '/' . CmnEnum::FILE_PATH_PREFIX,
            'path' => $this->path,
            'name' => $this->name ?? '',
            'displayName' => $this->display_name ?? '',            
            'thumbPath' => $this->thumb_path ?? ''
        ];
    }
}
