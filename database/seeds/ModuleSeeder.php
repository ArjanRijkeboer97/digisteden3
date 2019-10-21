<?php

use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = ['Nieuws', 'Agenda', 'Columns', 'Paginas', 'Prikbord', 'Bedrijvengids', 'Gebruikers', 'Vacatures', 'Advertenties', 'Forum', 'Nieuwsbrieven', 'Tags'];

        for ($i = 0; $i < count($modules); $i++) {
            DB::table('modules')->insert([
                'name' => $modules[$i],
                'is_active' => 1
            ]);
        }
    }
}
