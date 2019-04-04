<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $firstNames = [
            'Jan', 'Andrzej', 'Tadeusz', 'Jerzy', 'Zbigniew', 'Krzysztof', 'Henryk', 'Ryszard', 'Kazimierz', 'Marek', 'Marian', 'Piotr', 'Janusz', 'Adam', 'Edward', 'Roman', 'Grzegorz', 'Dariusz', 'Wojciech', 'Jacek', 'Eugeniusz', 'Tomasz', 'Stefan', 'Zygmunt', 'Leszek', 'Bartosz', 'Grzegorz', 'Czarek', 'Damian', 'Filip', 'Norbert', 'Olek', 'Cezary', 'Cyryl',
            'Maria', 'Krystyna', 'Anna', 'Barbara', 'Teresa', 'Janina', 'Zofia', 'Jadwiga', 'Danuta', 'Halina', 'Irena', 'Ewa', 'Helena', 'Jolanta', 'Marianna', 'Urszula', 'Wanda', 'Alicja', 'Dorota', 'Agnieszka', 'Beata', 'Katarzyna', 'Joanna', 'Renata', 'Iwona', 'Genowefa'
        ];

        $lastName = [
            'Nowak', 'Kowalczyk', 'Krawczyk', 'Wieczorek', 'Duda', 'Pawlak', 'Walczak', 'Adamczyk'
        ];

        $name = $firstNames[random_int(0,count($firstNames)-1)] . ' ' . $lastName[random_int(0,count($lastName)-1)];

        DB::table('users')->insert([
            'name' => $name,
            'email' => strtolower(str_replace(' ', '@', $name) . '.pl'),
            'password' => bcrypt('test123')
        ]);
    }
}
