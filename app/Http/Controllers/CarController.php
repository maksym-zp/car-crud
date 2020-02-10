<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarRequest;
use App\Models\Brand;

class CarController extends Controller
{

    public function index()
    {
        $auth = auth()->user();
        $car = $auth->car ? $auth->car->toJson() : collect([]);
        $brands = Brand::all()->toJson();
        $models = ($auth->car &&$auth->car->brand)  ? $auth->car->brand->carModels : collect([]);
        return view('home', compact('auth', 'car', 'brands', 'models'));
    }

    function update(CarRequest $request)
    {
        try {
            if (auth()->user()->car) {
                $car = auth()->user()->car()->update($request->all());
                return response()->json(['updated' => $car]);
            } else {
                $car = auth()->user()->car()->create($request->all());
                return response()->json(['updated' => $car]);
            }
        } catch (\Exception $exception) {
            return response()->json(['exception' => $exception->getMessage()]);
        }
    }


}
