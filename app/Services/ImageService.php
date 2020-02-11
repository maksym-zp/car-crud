<?php

namespace App\Services;


use App\Models\Car;
use App\Traits\ImageTrait;

/**
 *
 * Class ImageService
 * @package App\Services
 */
class ImageService
{
    use ImageTrait;

    public function save($data)
    {
        /** @var Car $car */
        $car = auth()->user()->car;
        $dataImage = ['url' => $this->getPath($data, 'images/cars'), 'name' => 'car'];

        if ($car && $car->image) {
            $image = $car->image;
            $this->removeOldImage($image->url);
            $car->image()->update($dataImage);
            $image = $car->image()->first();
        } else if ($car) {
            $image = $car->image()->create($dataImage);
        } else {
            return response()->json([
                'error' => 'Write something about the car first!',
            ]);
        }

        return response()->json([
            'id' => $image->id,
            'name' => $image->name,
            'url' => $image->url,
        ]);
    }
}

