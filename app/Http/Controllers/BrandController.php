<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{

    function show(Brand $brand)
    {
        return $brand->carModels->toJson();
    }

}
