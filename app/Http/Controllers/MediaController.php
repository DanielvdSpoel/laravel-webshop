<?php

namespace App\Http\Controllers;

use FilamentCurator\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function __invoke(Request $request, Media $media)
    {
        return response()->file(storage_path('app/public/' . $media->filename));
    }
}
