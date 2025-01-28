<?php

namespace App\Http\Resources\Common;

use App\Enums\CmnEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
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
