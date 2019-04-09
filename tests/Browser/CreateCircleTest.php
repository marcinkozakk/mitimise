<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateCircleTest extends DuskTestCase
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
            'name' => 'Test circle',
        ];


        $this->browse(function (Browser $browser) use ($data) {
            $browser->loginAs(factory(User::class)->create())
                ->visit('/home')
                ->pressAndWaitFor('Stwórz krąg znajomych', 2)
                ->screenshot('6.New_circle_form')
                ->type('name', $data['name'])
                ->screenshot('7.New_circle_form_filled')
                ->press('create-circle')
                ->assertSee($data['name'])
                ->screenshot('8.Created_circle')
                ->click('a[data-target="#delete-circle"]')
                ->press('Usuń')
                ->assertSee('Krąg został usunięty')
                ->screenshot('9.Circle_deleted')
            ;
        });
    }
}
