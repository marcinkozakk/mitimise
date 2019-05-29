<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A user test example.
     *
     * @return void
     */
    public function testUser()
    {
        /**
         * @var User $user
         */
        $user = factory(User::class)->create();
        $otherUser = factory(User::class)->create();

        //empty request
        $request = $this
            ->actingAs($user)
            ->post('subscriptions');

        $request->assertSessionHasErrors();

        //no endpoint
        $request = $this
            ->actingAs($user)
            ->post('subscriptions', [
                'endpoint' => '',
                'key' => '',
                'token' => ''
            ]);

        $request->assertSessionHasErrors();

        //valid request
        $request = $this
            ->actingAs($user)
            ->post('subscriptions', [
                'endpoint' => 'a',
                'key' => 'a',
                'token' => 'a'
            ]);

        $request->assertSessionHasNoErrors();
        $request->assertStatus(204);
        $this->assertDatabaseHas('push_subscriptions',[
            'user_id' => $user->id,
            'endpoint' => 'a'
        ]);

        //empty delete request
        $request = $this
            ->actingAs($user)
            ->post('subscriptions/delete');

        $request->assertSessionHasErrors();

        //endpoint does not exist
        $this
            ->actingAs($user)
            ->post('subscriptions/delete', [
                'endpoint' => 'b'
            ]);

        $this->assertDatabaseHas('push_subscriptions',[
            'user_id' => $user->id,
            'endpoint' => 'a'
        ]);

        //acting as other user
        $this
            ->actingAs($otherUser)
            ->post('subscriptions/delete', [
                'endpoint' => 'a'
            ]);

        $this->assertDatabaseHas('push_subscriptions',[
            'user_id' => $user->id,
            'endpoint' => 'a'
        ]);

        //valid delete request
        $request = $this
            ->actingAs($user)
            ->post('subscriptions/delete', [
                'endpoint' => 'a'
            ]);

        $request->assertSessionHasNoErrors();
        $request->assertStatus(204);

        $this->assertDatabaseMissing('push_subscriptions',[
            'user_id' => $user->id,
            'endpoint' => 'a'
        ]);

    }
}
