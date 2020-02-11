<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    const BMW = 1;
    const MERCEDES = 2;
    const JEEP = 3;

    protected $fillable = ['name'];

    public $timestamps = false;

    public function carModels()
    {
        return $this->hasMany(CarModel::class );
    }

    public function model()
    {
        return $this->hasOne(CarModel::class, 'model_id','id' );
    }

    public function car()
    {
    return $this->belongsTo(Car::class, 'id');
    }
}
