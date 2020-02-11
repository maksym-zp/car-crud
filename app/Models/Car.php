<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = ['name', 'brand_id', 'model_id', 'buying', 'color_id', 'milage', 'drivetrain'];

    protected $hidden = ['created_at', 'updated_at'];

    const DRIVETRAIN = ['2x4', '4x4'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function brand()
    {
        return $this->hasOne(Brand::class,'id','brand_id');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
