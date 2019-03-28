<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisterLoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test .
     *
     * @return void
     */
    public function test()
    {
        $data = [
            'name' => 'Test user',
            'email' => 'user@example.com',
            'password' => 'test123',
        ];


        $this->browse(function (Browser $browser) use ($data) {
            $browser->visit('/')
                ->assertSee('ZAREJESTRUJ SIĘ')
                ->clickLink('Zarejestruj się')
                ->screenshot('1.Register_form')
                ->type('name', $data['name'])
                ->type('email', $data['email'])
                ->type('password', $data['password'])
                ->type('password_confirmation', $data['password'])
                ->screenshot('2.Register_form_filled')
                ->press('Zarejestruj się')
                ->screenshot('3.Registred')
                ->assertSee('Witaj, Test user!')
                ->clickLink($data['name'])
                ->clickLink('Wyloguj')
                ->screenshot('4.Logout')
                ->clickLink('Logowanie')
                ->type('email', $data['email'])
                ->type('password', $data['password'])
                ->press('Logowanie')
                ->screenshot('5.Logged')
                ->assertSee('Witaj, Test user!')
            ;
        });
    }
}
