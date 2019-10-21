<?php

use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groupId = DB::table('citygroups')->insertGetId([
            'name' => 'Drechtsteden.net',
            'color' => '#0056A2',
            'created_at' => gmdate('Y-m-d H:i:s')
        ]);

        DB::table('citygroup_domains')->insert([
            'group_id' => $groupId,
            'domain' => 'drechtsteden.net',
            'created_at' => gmdate('Y-m-d H:i:s')
        ]);

        $cities = [
            ['Dordrecht', 'dordrecht.net', '#932120'],
            ['Papendrecht', 'papendrecht.net', '#157B6F'],
            ['Alblasserdam', 'alblasserdam.net', '#16498d'],
            ['Ambacht', 'ambacht.net', '#400535'],
            ['Zwijndrecht', 'zwijndrecht.net', '#780816'],
            ['Sliedrecht', 'sliedrecht.net', '#1a7a16'],
            ['Dordrecht', 'digisteden3.local', '#932120'],
        ];


        $this->insertCities($cities, $groupId);


        $groupId = DB::table('citygroups')->insertGetId([
            'name' => 'Altena.net',
            'color' => '#78a2ca',
            'created_at' => gmdate('Y-m-d H:i:s')
        ]);

        DB::table('citygroup_domains')->insert([
            'group_id' => $groupId,
            'domain' => 'altena.net',
            'created_at' => gmdate('Y-m-d H:i:s')
        ]);

        $cities = [
            ['Woudrichem', 'woudrichem.net', '#2a4850'],
            ['Aalburg', 'aalburg.net', '#336292'],
            ['Werkendam', 'werkendam.net', '#af2509'],
        ];

        $this->insertCities($cities, $groupId);
    }


    private function insertCities($cities, $groupId)
    {
        foreach ($cities as $city) {
            $cityId = DB::table('cities')->insertGetId([
                'group_id' => $groupId,
                'name' => $city[0],
                'domain' => $city[1],
                'color' => $city[2],
                'created_at' => gmdate('Y-m-d H:i:s')
            ]);

            DB::table('city_domains')->insert([
                'city_id' => $cityId,
                'domain' => $city[1],
                'created_at' => gmdate('Y-m-d H:i:s')
            ]);
        }
    }
}
