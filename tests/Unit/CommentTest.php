<?php

namespace Tests\Unit;

use App\Invitation;
use App\Meeting;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public $data = [
        'comment_content' => 'Test comment!'
    ];

    public function testComment() {
        $user = factory(User::class)->create();
        $otherUser = factory(User::class)->create();
        $meeting = factory(Meeting::class)->create([
            'organizer_id' => $user->id
        ]);
        factory(Invitation::class)->create([
            'user_id' => $user->id,
            'meeting_id' => $meeting->id,
            'state' => 'going'
        ]);

        $response = $this->actingAs($user)
            ->post('/comments/create/0');

        $response->assertNotFound();

        $response = $this->actingAs($user)
            ->post('/comments/create/' . $meeting->id);

        $response->assertSessionHasErrors();

        $response = $this->actingAs($otherUser)
            ->post('comments/create/' . $meeting->id, [
                'comment_content' => $this->data['comment_content']
            ]);

        $response->assertForbidden();

        $response = $this->actingAs($user)
            ->post('comments/create/' . $meeting->id, [
                'comment_content' => $this->data['comment_content']
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('alert-success');
        $this->assertDatabaseHas('comments', [
            'content' => $this->data['comment_content']
        ]);
    }
}
