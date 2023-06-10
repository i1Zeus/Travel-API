<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    //* get Tour By Slug
    public function getTourBySlug($slug)
    {
        $tour = Tour::where('slug', $slug)->firstOrFail();

        return new TourResource($tour);
    }
}
