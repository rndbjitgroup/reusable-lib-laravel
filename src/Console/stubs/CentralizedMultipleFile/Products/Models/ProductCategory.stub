<?php

namespace App\Models\Products;

use App\Models\BaseModel;
use App\Models\Common\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'slug'];

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
