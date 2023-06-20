<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourRequest;
use App\Http\Resources\TourResource;
use App\Models\Travel;

class TourController extends Controller
{
    /**
     * @group Admin Controls
     *
     * Create a new tours for a Travel by Travel ID.
     */
    public function store(Travel $travel, TourRequest $request): TourResource
    {
        $tour = $travel->tours()->create($request->validated());

        return new TourResource($tour);
    }
}
