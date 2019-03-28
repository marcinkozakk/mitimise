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
            'Jan', 'Stanisław', 'Andrzej', 'Józef', 'Tadeusz', 'Jerzy', 'Zbigniew', 'Krzysztof', 'Henryk', 'Ryszard', 'Kazimierz', 'Marek', 'Marian', 'Piotr', 'Janusz', 'Władysław', 'Adam', 'Wiesław', 'Zdzisław', 'Edward', 'Mieczysław', 'Roman', 'Mirosław', 'Grzegorz', 'Czesław', 'Dariusz', 'Wojciech', 'Jacek', 'Eugeniusz', 'Tomasz', 'Stefan', 'Zygmunt', 'Leszek',
            'Maria', 'Krystyna', 'Anna', 'Barbara', 'Teresa', 'Elżbieta', 'Janina', 'Zofia', 'Jadwiga', 'Danuta', 'Halina', 'Irena', 'Ewa', 'Małgorzata', 'Helena', 'Grażyna', 'Bożena', 'Stanisława', 'Jolanta', 'Marianna', 'Urszula', 'Wanda', 'Alicja', 'Dorota', 'Agnieszka', 'Beata', 'Katarzyna', 'Joanna', 'Wiesława', 'Renata', 'Iwona', 'Genowefa'
        ];

        $lastName = [
            'Nowak', 'Kowalczyk', 'Woźniak', 'Krawczyk', 'Zając', 'Król', 'Wieczorek', 'Wróbel', 'Duda', 'Pawlak', 'Walczak', 'Adamczyk'
        ];

        $name = $firstNames[random_int(0,count($firstNames)-1)] . ' ' . $lastName[random_int(0,count($lastName)-1)];

        DB::table('users')->insert([
            'name' => $name,
            'email' => strtolower(str_replace(' ', '@', $name) . '.pl'),
            'password' => bcrypt('test123')
        ]);
    }
}
