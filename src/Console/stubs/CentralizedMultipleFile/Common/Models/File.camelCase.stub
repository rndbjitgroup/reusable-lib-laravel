<?php

namespace App\Models\Common;

use App\Enums\CmnEnum;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class File extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'displayName',
        'path',
        'thumbPath',
        // 'fileableType',
        // 'fileableId',
        // 'createdBy',
        // 'updatedBy',
        // 'deletedBy'
    ];

    public function fileable()
    {
        return $this->morphTo();
    }

    protected static function booted()
    { 
        static::creating(function ($model) { 
            $model->created_by = Auth::id() ?? CmnEnum::ONE;
            $model->updated_by = Auth::id() ?? CmnEnum::ONE;
        });
        static::updating(function ($model) {
            $model->updated_by = Auth::id() ?? CmnEnum::ONE;
        });
        static::deleting(function ($model) {
            $model->deleted_by = Auth::id() ?? CmnEnum::ONE;
        });
    }

}
