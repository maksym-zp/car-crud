<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Models\Car;
use App\Models\CarModel;
use App\Models\Color;

class CarRepository
{

    protected $car;

    /**
     * MaterialsRepository constructor.
     * @param Car $car
     */
    public function __construct(Car $car)
    {
        $this->car = $car;
    }

    public function index()
    {
        $auth = auth()->user();
        $car = $auth->car;
        return view('home',
            [
                'auth'                  => $auth,
                'car'                   => $auth->car ? $auth->car->toJson() : collect([]),
                'brands'                => Brand::all()->toJson(),
                'models'                => ($car && $car->brand) ? $car->brand->carModels : collect([]),
                'colors'                => Color::all()->toJson(),
                'driveTrainVariables'   => json_encode(Car::DRIVETRAIN),
                'canHasDriveTrain'      => CarModel::GRANDCHEROKEE,
                'image'                 => ($car && $car->image) ? $car->image : collect([]),

            ]);
    }

    public function update( $data)
    {
        try {
            if (auth()->user()->car) {
                $car = auth()->user()->car()->update($data);
                return response()->json(['updated' => $car]);
            } else {
                $car = auth()->user()->car()->create($data);
                return response()->json(['updated' => $car]);
            }
        } catch (\Exception $exception) {
            return response()->json(['exception' => $exception->getMessage()]);
        }
    }

}