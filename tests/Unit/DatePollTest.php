<?php

namespace Tests\Unit;

use App\Invitation;
use App\Meeting;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatePollTest extends TestCase
{
    use RefreshDatabase;

    public $data = [
        'date' => '2020-01-01'
    ];

    public function testComment() {
        $user = factory(User::class)->create();
        $otherUser = factory(User::class)->create();
        $meeting = factory(Meeting::class)->create([
            'organizer_id' => $user->id
        ]);
        $this->be($user);
        factory(Invitation::class)->create([
            'user_id' => $user->id,
            'meeting_id' => $meeting->id,
            'state' => 'going'
        ]);

        $response = $this->actingAs($user)
            ->post('/datePolls/setAvailability/0');

        $response->assertNotFound();

        $response = $this->actingAs($user)
            ->post('/datePolls/setAvailability/' . $meeting->id);

        $response->assertSessionHasErrors();

        $response = $this->actingAs($otherUser)
            ->post('datePolls/setAvailability/' . $meeting->id, [
                'date' => $this->data['date'],
                'availability' => 'yes'
            ]);

        $response->assertForbidden();

        $response = $this->actingAs($user)
            ->post('datePolls/setAvailability/' . $meeting->id, [
                'date' => $this->data['date'],
                'availability' => 'yes'
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('alert-success');
        $this->assertDatabaseHas('date_polls', [
            'date' => $this->data['date'],
            'availability' => 'yes'
        ]);
    }
}
