<?php

namespace App\Models\Products;

use App\Enums\CmnEnum;
use App\Models\BaseModel;
use App\Models\Common\File;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Product extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'productCategoryId', 'title', 'slug', 'identifierUrl', 'description', 'size', 'color', 'oldPrice', 'price', 
        'coupon', 'publishedAt', 'visitor', 'device'
    ]; 

    protected static function booted()
    { 
        static::creating(function ($model) { 
            $model->user_id = Auth::id() ?? CmnEnum::ONE;
            $model->visitor = request()->ip();
            $model->device = substr(exec('getmac'), 150, 20);
            $model->created_by = Auth::id() ?? CmnEnum::ONE;
        });
        static::updating(function ($model) {
            $model->visitor = request()->ip();
            $model->device = substr(exec('getmac'), 150, 20);
            $model->updated_by = Auth::id() ?? CmnEnum::ONE;
        });
        static::deleting(function ($model) {
            $model->visitor = request()->ip();
            $model->device = substr(exec('getmac'), 150, 20);
            $model->deleted_by = Auth::id() ?? CmnEnum::ONE;
        });
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tag', 'product_id', 'tag_id');
    }

}
