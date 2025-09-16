<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'category_id','title','slug','price','duration_minutes',
        'description','cover_image','gallery','status'
    ];

    protected $casts = [
        'gallery' => 'array',
        'price' => 'integer',
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    protected static function booted() {
        static::saving(function ($model) {
            if (blank($model->slug)) $model->slug = Str::slug($model->title);
        });
    }

    public function getRouteKeyName(): string {
        return 'slug';
    }

    // app/Models/Package.php
    public static function generateSlug(string $title, int $categoryId): string
    {
        $base = \Illuminate\Support\Str::slug($title);
        $slug = $base; $i = 2;

        while (self::where('category_id',$categoryId)->where('slug',$slug)->exists()) {
            $slug = $base.'-'.$i++;
        }
        return $slug;
    }

}
