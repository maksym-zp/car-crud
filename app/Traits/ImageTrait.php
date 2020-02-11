<?php


namespace App\Traits;

use App\Http\Requests\ImageRequest;
use Illuminate\Support\Facades\Storage;

trait ImageTrait
{
    public function getPath(ImageRequest $request, $partPath)
    {
        return $this->saveFile($partPath, $request);
    }

    public function saveFile($partPath, $request)
    {
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $name = time() . '-' . $file->getClientOriginalName();

            return Storage::disk('public')->putFileAs(
                $partPath, $request->file('image'), $name
            );
        }
    }

    public function removeOldImage($url)
    {
        if (Storage::disk('public')->exists($url)) {
            Storage::disk('public')->delete($url);
        }
    }
}