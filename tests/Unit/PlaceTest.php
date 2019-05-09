<?php

namespace Tests\Unit;

use App\Meeting;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlaceTest extends TestCase
{
    use RefreshDatabase;

    public $data = [
        'place_name' => 'Pijalnia Wódki i Piwa',
        'place_address' => 'Rynek 13/14, 50-101 Wrocław, Polska',
        'place_lat' => 51.1108247,
        'place_lng' => 17.0318154,
        'place_private' => false
    ];

    public $dataChanged = [
        'place_name' => 'Test',
        'place_address' => 'Test 2',
        'place_lat' => 51.1108247,
        'place_lng' => 17.0318154,
        'place_private' => false
    ];

    public $dataBase = [
        'name' => 'Pijalnia Wódki i Piwa',
        'address' => 'Rynek 13/14, 50-101 Wrocław, Polska',
        'lat' => 51.1108247,
        'lng' => 17.0318154,
        'is_private' => false
    ];

    public $dataBaseChanged = [
        'name' => 'Test',
        'address' => 'Test 2',
        'lat' => 51.1108247,
        'lng' => 17.0318154,
        'is_private' => false
    ];

    public function testPlace() {
        $user = factory(User::class)->create();
        $meeting = factory(Meeting::class)->create([
            'organizer_id' => $user->id
        ]);

        $response = $this->actingAs($user)
            ->post('/meeting/update/0');

        $response->assertNotFound();

        $response = $this->actingAs($user)
            ->post('/meetings/update/' . $meeting->id, array_merge(
                $meeting->attributesToArray(),
                ['place_name' => $this->data['place_name']]
            ));

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('alert-success');
        $this->assertDatabaseHas('places', [
            'name' => $this->data['place_name']
        ]);

        $response = $this->actingAs($user)
            ->post('/meetings/update/' . $meeting->id, array_merge(
                $meeting->attributesToArray(),
                $this->data
            ));

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('alert-success');
        $this->assertDatabaseHas('places', $this->dataBase);

        $response = $this->actingAs($user)
            ->post('/meetings/update/' . $meeting->id, array_merge(
                $meeting->attributesToArray(),
                $this->dataChanged
            ));

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('alert-success');
        $this->assertDatabaseHas('places', $this->dataBaseChanged);
    }
}
