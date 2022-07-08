<?php

namespace App\Models\Blogs;

use App\Enums\CmnEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth; 

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['category_id', 'slug', 'title', 'body', 'image_path', 'thumbnail_path', 'published_at'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        //static::addGlobalScope(new CurrentAccountScope);

        static::creating(function ($model) { 
            $model->user_id = Auth::id() ?? CmnEnum::ONE;
            $model->created_by = Auth::id() ?? CmnEnum::ONE;
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id() ?? CmnEnum::ONE;
        });

        static::deleting(function ($model) {
            $model->delete_by = Auth::id() ?? CmnEnum::ONE;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id')->latest();
    }
    
}
