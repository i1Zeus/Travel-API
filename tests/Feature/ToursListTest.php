<?php

namespace Tests\Feature;

use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ToursListTest extends TestCase
{
    use RefreshDatabase;

    public function test_tours_list_by_travel_slug_returns_correct_tours(): void
    {
        $travel = Travel::factory()->create();
        $tour = Tour::factory()->create(['travel_id' => $travel->id]);

        $response = $this->get("/api/v1/travels/{$travel->slug}/tours");

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['id' => $tour->id]);
    }

    public function test_tour_price_is_shown_correctly(): void
    {
        $travel = Travel::factory()->create();
        $tour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'price_in_cents' => 150.32,
        ]);

        $response = $this->get("/api/v1/travels/{$travel->slug}/tours");

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['price_in_cents' => '150.32']);
    }

    public function test_tours_list_returns_pagination(): void
    {
        $travel = Travel::factory()->create();
        Tour::factory(16)->create(['travel_id' => $travel->id]);

        $response = $this->get("/api/v1/travels/{$travel->slug}/tours");

        $response->assertStatus(200);
        $response->assertJsonCount(15, 'data');
        $response->assertJsonPath('meta.current_page', 1);
        $response->assertJsonPath('meta.last_page', 2);
    }

    public function test_tours_list_sorts_by_starting_date_correctly(): void
    {
        $travel = Travel::factory()->create();
        $laterTour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'starting_date' => now()->addDays(2),
            'ending_date' => now()->addDays(2),
        ]);
        $earlierTour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'starting_date' => now(),
            'ending_date' => now()->addDays(1),
        ]);

        $response = $this->get("/api/v1/travels/{$travel->slug}/tours");

        $response->assertStatus(200);
        $response->assertJsonPath('data.0.id', $earlierTour->id);
        $response->assertJsonPath('data.1.id', $laterTour->id);
    }

    public function test_tours_list_sorts_by_price_correctly(): void
    {
        $travel = Travel::factory()->create();
        $cheaperEarlierTour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'starting_date' => now(),
            'ending_date' => now()->addDays(1),
            'price_in_cents' => 100,
        ]);
        $cheaperLaterTour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'starting_date' => now()->addDays(2),
            'ending_date' => now()->addDays(2),
            'price_in_cents' => 100,
        ]);
        $expensiveTour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'price_in_cents' => 200,
        ]);

        $response = $this->get("/api/v1/travels/{$travel->slug}/tours?sortBy=price_in_cents&sortOrder=asc");

        $response->assertStatus(200);
        $response->assertJsonPath('data.0.id', $cheaperEarlierTour->id);
        $response->assertJsonPath('data.1.id', $cheaperLaterTour->id);
        $response->assertJsonPath('data.2.id', $expensiveTour->id);
    }

    public function test_tours_list_fillers_by_price_correctly(): void
    {
        $travel = Travel::factory()->create();
        $cheapTour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'price_in_cents' => 100,
        ]);
        $expensiveTour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'price_in_cents' => 200,
        ]);

        $endpoint = "/api/v1/travels/{$travel->slug}/tours?";

        $response = $this->get($endpoint . "priceFrom=100");
        $response->assertJsonCount(2, 'data');
        $response->assertJsonFragment(['id' => $cheapTour->id]);
        $response->assertJsonFragment(['id' => $expensiveTour->id]);

        $response = $this->get($endpoint . "priceFrom=150");
        $response->assertJsonCount(1, 'data');
        $response->assertJsonMissing(['id' => $cheapTour->id]);
        $response->assertJsonFragment(['id' => $expensiveTour->id]);

        $response = $this->get($endpoint . "priceFrom=250");
        $response->assertJsonCount(0, 'data');

        $response = $this->get($endpoint . "priceTo=200");
        $response->assertJsonCount(2, 'data');
        $response->assertJsonFragment(['id' => $cheapTour->id]);
        $response->assertJsonFragment(['id' => $expensiveTour->id]);

        $response = $this->get($endpoint . "priceTo=150");
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['id' => $cheapTour->id]);
        $response->assertJsonMissing(['id' => $expensiveTour->id]);

        $response = $this->get($endpoint . "priceTo=50");
        $response->assertJsonCount(0, 'data');

        $response = $this->get($endpoint . "priceFrom=100&priceTo=200");
        $response->assertJsonCount(2, 'data');
        $response->assertJsonFragment(['id' => $cheapTour->id]);
        $response->assertJsonFragment(['id' => $expensiveTour->id]);

        $response = $this->get($endpoint . "priceFrom=150&priceTo=200");
        $response->assertJsonCount(1, 'data');
        $response->assertJsonMissing(['id' => $cheapTour->id]);
        $response->assertJsonFragment(['id' => $expensiveTour->id]);

        $response = $this->get($endpoint . "?priceFrom=100&priceTo=150");
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['id' => $cheapTour->id]);
        $response->assertJsonMissing(['id' => $expensiveTour->id]);
    }

    public function test_tours_list_fillers_bg_starting_date_correctly(): void
    {
        $travel = Travel::factory()->create();
        $laterTour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'starting_date' => now()->addDays(2),
            'ending_date' => now()->addDays(3),
        ]);
        $earlierTour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'starting_date' => now(),
            'ending_date' => now()->addDays(1),
        ]);

        $endpoint = "/api/v1/travels/{$travel->slug}/tours?";

        $response = $this->get($endpoint . "dateFrom=" . now());
        $response->assertJsonCount(2, 'data');
        $response->assertJsonFragment(['id' => $laterTour->id]);
        $response->assertJsonFragment(['id' => $earlierTour->id]);

        $response = $this->get($endpoint . "dateFrom=" . now()->addDay());
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['id' => $laterTour->id]);
        $response->assertJsonMissing(['id' => $earlierTour->id]);

        $response = $this->get($endpoint . "dateFrom=" . now()->addDays(5));
        $response->assertJsonCount(0, 'data');

        $response = $this->get($endpoint . "dateTo=" . now()->addDays(5));
        $response->assertJsonCount(2, 'data');
        $response->assertJsonFragment(['id' => $laterTour->id]);
        $response->assertJsonFragment(['id' => $earlierTour->id]);

        $response = $this->get($endpoint . "dateTo=" . now()->addDay());
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['id' => $earlierTour->id]);
        $response->assertJsonMissing(['id' => $laterTour->id]);

        $response = $this->get($endpoint . "dateTo=" . now()->subDay());
        $response->assertJsonCount(0, 'data');

        $response = $this->get($endpoint . "dateFrom=" . now()->addDay() . "&dateTo=" . now()->addDays(5));
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['id' => $laterTour->id]);
        $response->assertJsonMissing(['id' => $earlierTour->id]);
    }

    public function test_tours_list_returns_validation_errors(): void
    {
        $travel = Travel::factory()->create();

        $endpoint = "/api/v1/travels/{$travel->slug}/tours?";

        $response = $this->getJson($endpoint . "priceFrom=abcde");
        $response->assertStatus(422);

        $response = $this->getJson($endpoint . "dateFrom=abcde");
        $response->assertStatus(422);

        $response = $this->getJson($endpoint . "sortBy=abcd" );
        $response->assertStatus(422);

        $response = $this->getJson($endpoint . "sortBy=price&sortOrder=abcd");
        $response->assertStatus(422);
    }
}
