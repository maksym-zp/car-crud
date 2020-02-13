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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($data)
    {
        try {
            if ($this->canSaveDrivetrain($data)) {
                if (auth()->user()->car) {
                    if(array_key_exists('drivetrain', $data) && $data['drivetrain'] == 0)
                        $data['drivetrain'] = null;

                    $car = auth()->user()->car()->update($data);
                    return response()->json(['updated' => $car]);
                } else {
                    $car = auth()->user()->car()->create($data);
                    return response()->json(['updated' => $car]);
                }
            };
            return response()->json(['exception' => 'There are no such options for this model.']);
        } catch (\Exception $exception) {
            return response()->json(['exception' => $exception->getMessage()]);
        }
    }

    /**
     * @param $data
     * @return bool
     */
    private function canSaveDrivetrain($data)
    {
        return (!array_key_exists('drivetrain', $data) || $data['drivetrain'] === 0
            ||
            (array_key_exists('model_id', $data) && $data['model_id'] === CarModel::GRANDCHEROKEE)
        ) ? true : false;
    }
}