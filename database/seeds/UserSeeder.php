<?php

use Illuminate\Database\Seeder;
use App\Model\CityUser;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('nl_NL');

        DB::table('users')->insert(
            [

                'name' => 'Vincent van Wijk',
                'username' => 'Vincent',
                'password' => bcrypt('VVW#345'),
                'created_at' => gmdate('Y-m-d H:i:s'),
                'email' => 'vincent@avant.nl',
                'bio' => $faker->paragraph,
                'img_src' => ''
            ]
        );
        DB::table('users')->insert(
            [

                'name' => 'Hennie van der Zouw',
                'username' => 'hennie',
                'password' => bcrypt('hennie'),
                'created_at' => gmdate('Y-m-d H:i:s'),
                'email' => 'hennie@avant.nl',
                'bio' => $faker->paragraph,
                'img_src' => ''
            ]
        );

        DB::table('users')->insert(
            [

                'name' => 'Arjan Rijkeboer',
                'username' => 'Arjan',
                'password' => bcrypt('Airsoft97'),
                'created_at' => gmdate('Y-m-d H:i:s'),
                'email' => 'arjan.rijkeboer@hotmail.com',
                'bio' => $faker->paragraph,
                'img_src' => ''
            ]
        );

        DB::table('users')->insert(
            [

                'name' => 'Bryant van den Berg ',
                'username' => 'Bryant',
                'password' => bcrypt('BB#890'),
                'created_at' => gmdate('Y-m-d H:i:s'),
                'email' => 'bryant@avant.nl',
                'bio' => $faker->paragraph,
                'img_src' => ''
            ]
        );
        // give all users acces to digisteden3.local
        $users = DB::table('users')->get();
        foreach ($users as $item) {
            DB::table('city_user')->insert([
                'city_id' => 7,
                'user_id' => $item->id
            ]);
        }

        // give vincent access to all sites
        for ($i = 1; $i <= 10; $i++) {
            //skip digisteden.local because that has been set inthe foreach loop above
            if ($i == 7) {
                continue;
            }
            $koppeltabel = new CityUser();
            $koppeltabel->city_id = $i;
            $koppeltabel->user_id = 1;
            $koppeltabel->save();
            $koppeltabel = new CityUser();
            $koppeltabel->city_id = $i;
            $koppeltabel->user_id = 2;
            $koppeltabel->save();
            $koppeltabel = new CityUser();
            $koppeltabel->city_id = $i;
            $koppeltabel->user_id = 3;
            $koppeltabel->save();
            $koppeltabel = new CityUser();
            $koppeltabel->city_id = $i;
            $koppeltabel->user_id = 4;
            $koppeltabel->save();
        }
    }
}
