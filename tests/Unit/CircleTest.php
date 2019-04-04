<?php

namespace Tests\Unit;

use App\Circle;
use App\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CircleTest extends TestCase
{
    public $data = [
        'name' => 'Test circle',
    ];

    public function testNewCircle()
    {
        global $user;
        $user = factory(User::class)->create();
        $response = $this
            ->actingAs($user)
            ->post('circles/create', [
                'name' => ''
            ]);

        $response->assertRedirect($_SERVER['APP_URL']);
        $response->assertSessionHasErrors(['name']);

        $response = $this
            ->actingAs($user)
            ->post('circles/create', [
                'name' => $this->data['name'],
                'is_private' => false
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('circles', ['name' => $this->data['name']]);
    }

    public function testShowCircle()
    {
        global $user;
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
    }

    public function testDeleteCircle()
    {
        global $user;
        $circle = DB::table('circles')->first();

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
