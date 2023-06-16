<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'travel_id',
        'name',
        'starting_date',
        'ending_date',
        'price_in_cents',
    ];

    public function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100
        );
    }

    /*
    * Tinker:
    Tour::create([
    'travel_id' => '995edfad-3368-4790-8603-9629cc8c24f1',
    'name' => 'New Tour plus',
    'starting_date' => '2023-06-01',
    'ending_date' => '2023-06-05',
    'price_in_cents' => 500,
    ]);
    */
}
