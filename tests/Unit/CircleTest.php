<?php

namespace Tests\Unit;

use App\Circle;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CircleTest extends TestCase
{
    use RefreshDatabase;

    public $data = [
        'name' => 'Test circle',
    ];

    public function testCircle()
    {
        /**
         * Creating circle
         */
        $user = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->post('circles/create', [
                'name_circle' => ''
            ]);

        $response->assertRedirect($_SERVER['APP_URL']);
        $response->assertSessionHasErrors(['name_circle']);

        $response = $this
            ->actingAs($user)
            ->post('circles/create', [
                'name_circle' => $this->data['name'],
                'is_private' => false
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('circles', ['name' => $this->data['name']]);



        /**
         * Showing circle
         */
        $circle = DB::table('circles')->first();

        $this->assertTrue($circle->name == $this->data['name']);
        $this->assertTrue($circle->is_private == false);

        $response = $this
            ->actingAs($user)
            ->get('circles/show/' . $circle->id);

        $response->assertSee($this->data['name']);

        $otherUser = factory(User::class)->create();

        $response = $this
            ->actingAs($otherUser)
            ->get('circles/show/' . $circle->id);

        $response->assertForbidden();



        /**
         * Deleting circle
         */
        $otherUser = factory(User::class)->create();

        $response = $this
            ->actingAs($otherUser)
            ->post('circles/delete/' . $circle->id);

        $response->assertForbidden();

        $response = $this
            ->actingAs($user)
            ->post('circles/delete/' . $circle->id);

        $response->assertSessionHas('alert-success');
        $this->assertDatabaseMissing('circles', ['name' => $this->data['name']]);
    }
}
