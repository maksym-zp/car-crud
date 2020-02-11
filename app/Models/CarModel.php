<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    const SERIES_3 = 1;
    const SERIES_5 = 2;
    const SERIES_7 = 3;
    const CCLASS = 4;
    const ECLASS = 5;
    const SCLASS = 6;
    const WRANGLER = 7;
    const CHEROKEE = 8;
    const GRANDCHEROKEE = 9;

    protected $fillable = ['name', 'brand_id'];

    protected $hidden = ['brand_id'];
    public $timestamps = false;

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}
