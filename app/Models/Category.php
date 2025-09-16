<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','slug'];

    public function packages() {
        return $this->hasMany(Package::class);
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
