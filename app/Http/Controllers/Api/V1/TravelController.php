<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TravelResource;
use App\Http\Resources\TourResource;
use App\Models\Travel;
use Illuminate\Http\Request;

class TravelController extends Controller
{
    public function index()
    {
        $travels = Travel::where('is_public', true)->paginate();

        return TravelResource::collection($travels);
    }


    //* get tours by travel slug
    public function getToursByTravelSlug($slug)
    {
        $travel = Travel::where('slug', $slug)->firstOrFail();
        $tours = $travel->tours()->paginate();

        return TourResource::collection($tours);
    }
}
