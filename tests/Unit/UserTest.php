<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A user test example.
     *
     * @return void
     */
    public function testUser()
    {
        $data = [
            'name' => 'Test user',
            'email' => 'user@example.com',
            'password' => 'test123',
            'photoPath1' => 'photoPath1',
            'photoPath2' => 'photoPath2'
        ];

        //create user
        $user = new User([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
        $user->save();
        $this->assertCredentials([
            'email' => $data['email'],
            'password' => 'test123',
        ]);

        //default photo
        $this->assertTrue($user->photo == '/images/user-default.svg');

        //new photo
        $user->setPhoto($data['photoPath1']);
        $this->assertTrue($user->photo == '/storage/' . $data['photoPath1']);

        //update photo
        $user->setPhoto($data['photoPath2']);
        $this->assertTrue($user->photo == '/storage/' . $data['photoPath2']);

        //delete user
        $user->delete();
        $this->assertDatabaseMissing('users', $user->attributesToArray());
    }
}
