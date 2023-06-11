<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index(Travel $travel)
    {
        $tours= $travel->tours()
            ->orderBY('starting_date')
            ->paginate();

        return TourResource::collection($tours);
    }

    //* get tours by travel slug
    public function getToursByTravelSlug($slug)
    {
        $travel = Travel::where('slug', $slug)->firstOrFail();
        $tours = $travel->tours()->paginate();

        return TourResource::collection($tours);
    }
}
