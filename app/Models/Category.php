<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name','slug'];

    public function packages()
    {
        return $this->hasMany(\App\Models\Package::class)
                    ->where('status', 'active')
                    ->orderBy('price', 'asc'); // selalu urut ASC
    }

    // auto slug
    protected static function booted() {
        static::saving(function ($model) {
            if (blank($model->slug)) $model->slug = Str::slug($model->name);
        });
    }

    public function getRouteKeyName(): string {
        return 'slug';
    }
    
}
