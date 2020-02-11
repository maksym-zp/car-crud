<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarRequest;
use App\Http\Requests\ImageRequest;
use App\Repositories\CarRepository;
use App\Services\ImageService;
use App\Traits\ImageTrait;

class CarController extends Controller
{

    use ImageTrait;

    public $car;
    public $imageService;

    /**
     * UserRepository constructor.
     * @param CarRepository $car
     */
    function __construct(CarRepository $car)
    {
        $this->car = $car;
        $this->imageService = new ImageService();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return $this->car->index();
    }

    /**
     * @param CarRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    function update(CarRequest $request)
    {
        return $this->car->update($request->all());
    }

    /**
     * @param ImageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveImage(ImageRequest $request)
    {
        return $this->imageService->save($request);

    }

}
