<?php

namespace Tests\Unit;

use App\Circle;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MeetingTest extends TestCase
{
    use RefreshDatabase;

    public $data = [
        'name' => 'Test meeting',
        'description' => 'Test description',
        'starts_at' => '2020-05-12 18:00',
        'ends_at' => '2020-05-13 18:00'
    ];

    public function testMeeting()
    {
        /**
         * Creating meeting
         */
        $user = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->post('meetings/create', [
                'name' => ''
            ]);

        $response->assertSessionHasErrors();
        $response->assertSessionHasErrors(['name_meeting']);

        $response = $this
            ->actingAs($user)
            ->post('meetings/create', [
                'name_meeting' => $this->data['name'],
                'description' => $this->data['description'],
                'starts_at' => $this->data['starts_at'],
                'ends_at' => '2019-05-12 12:00',
                'is_private' => true
            ]);

        $response->assertSessionHasErrors(['ends_at']);

        $response = $this
            ->actingAs($user)
            ->post('meetings/create', [
                'name_meeting' => $this->data['name'],
                'description' => $this->data['description'],
                'starts_at' => $this->data['starts_at'],
                'ends_at' => $this->data['ends_at'],
                'is_private' => true
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('meetings', [
                'name' => $this->data['name'],
                'description' => $this->data['description'],
                'starts_at' => $this->data['starts_at'],
                'ends_at' => $this->data['ends_at'],
                'is_canceled' => false,
                'organizer_id' => $user->id
        ]);

        $meeting = DB::table('meetings')->first();

        $this->assertDatabaseHas('invitations', [
            'state' => 'going',
            'user_id' => $user->id,
            'meeting_id' => $meeting->id
        ]);


        /**
         * Showing meeting
         */
        $this->assertTrue($meeting->name == $this->data['name']);
        $this->assertTrue($meeting->is_private == true);

        $response = $this
            ->actingAs($user)
            ->get('meetings/show/' . $meeting->id);

        $response->assertSee($this->data['name']);
        $response->assertSee($this->data['description']);

        $otherUser = factory(User::class)->create();

        $response = $this
            ->actingAs($otherUser)
            ->get('meetings/show/' . $meeting->id);

        $response->assertForbidden();


        /**
         * Canceling meeting
         */
        $otherUser = factory(User::class)->create();

        $response = $this
            ->actingAs($otherUser)
            ->get('meetings/cancel/' . $meeting->id);

        $response->assertForbidden();

        $response = $this
            ->actingAs($user)
            ->get('meetings/cancel/' . $meeting->id);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('meetings', [
            'name' => $this->data['name'],
            'is_canceled' => true
        ]);

        $meeting = DB::table('meetings')->first();

        $response = $this
            ->actingAs($user)
            ->get('meetings/show/' . $meeting->id);

        $response->assertSee('Meeting is canceled');

    }
}
