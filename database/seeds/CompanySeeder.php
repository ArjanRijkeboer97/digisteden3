<?php

use Illuminate\Database\Seeder;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use App\Model\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('nl_NL');

        $types = ['Bedrijf', 'Organisatie', 'Vereniging'];
        $categories = ['Bouw & industrie', 'Detailhandel', 'Dienstverlening', 'Gezondheid & verzorging', 'Huis & tuin', 'Hobby & vrije tijd', 'Onderwijs', 'Vervoer'];

        foreach ($types as $t) {
            DB::table('company_type')->insert([
                'name' => $t
            ]);
        }

        foreach ($categories as $c) {
            DB::table('company_categories')->insert([
                'name' => $c
            ]);
        }

        //$rand = rand(1500, 2000);
        $rand = rand(250, 300);
        $addresses = [
            ['address' => 'Marijkestraat 25', 'city' => 'Strijen'],
            ['address' => 's-Gravendeelstraat 22', 'city' => 'Rotterdam'],
            ['address' => 'Nieuwland parc 11', 'city' => 'Alblasserdam'],
            ['address' => 'Amelandseplein 65', 'city' => 'Rotterdam'],
            ['address' => 'De horst 6', 'city' => 'Sliedrecht'],
            ['address' => 'London 18', 'city' => 'Barendrecht'],
        ];

        for ($i = 1; $i <= $rand; $i++) {
            $name = $faker->company;
            $random = rand(0, 5);
            DB::table('companies')->insert([
                'name' => $name,
                'address' => $addresses[$random]['address'],
                'zip_code' => '1234 AD',
                'city' => $addresses[$random]['city'],
                'telephone' => rand(111111111, 999999999),
                'email' => $faker->email,
                'video' => 'https://www.youtube.com/embed/c0rPJxfXQs8',
                'slug' => $faker->slug,
                'website' => 'https://www.google.nl',
                'description' => "<p>" . $faker->paragraph . "</p>",
                'lat' => $faker->longitude(51, 53),
                'lng' => $faker->longitude(4, 6),
                'type_id' => rand(1, 3),
                'subCategory_id' => rand(1, 58),
                //'city_id' => rand(1, 10),
                'city_id' => 7,
                'clicks' => rand(1, 1000),
                'is_published' => 1,
                'is_highlighted' => (int) rand(0, 10) < 2,
                'logo' => 'https://picsum.photos/450/180/?random&time=' . rand(),
            ]);
        }

        DB::table('company_comments')->insert([
            'id' => 1,
            'name' => 'Admin',
            'title' => 'Dit is een test',
            'body' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Debitis dolores repudiandae porro omnis doloremque odit. Labore, non. Blanditiis aliquid saepe error sit laudantium maxime nisi veniam voluptatum ab, consectetur obcaecati!',
            'rating' => rand(1, 5),
            'company_id' => rand(1, 1000),
        ]);

        $mutation_templates = [
            ['type_id' => 1, 'subject' => 'Titel voor nieuwe vermelding', 'message_top' => 'Dit is de bovenste tekst voor nieuwe vermeldingen', 'message_bottom' => 'Dit is de onderste tekst voor nieuwe vermeldingen'],
            ['type_id' => 2, 'subject' => 'titel voor doorvoeren aanpassing', 'message_top' => 'Dit is de bovenste tekst voor aanpassingen doorvoeren', 'message_bottom' => 'Dit is de onderste tekst voor aanpassingen doorvoeren']
        ];
        foreach ($mutation_templates as $mutation_template) {
            DB::table('mutation_mail_templates')->insert([
                'type_id' => $mutation_template['type_id'],
                'subject' => $mutation_template['subject'],
                'message_top' => $mutation_template['message_top'],
                'message_bottom' => $mutation_template['message_bottom']
            ]);
        }

        foreach (Company::all() as $c) {
            $c->slug = SlugService::createSlug(Company::class, 'slug', $c->name);
            $c->save();
        }

        $subcategory1 = ['Bestrating', 'Beveiliging', 'Bouwbedrijven', 'Metaalbewerking'];
        foreach ($subcategory1 as $groep1) {
            DB::table('company_subcategories')->insert([
                'category_id' => '1',
                'name' => $groep1
            ]);
        }

        $subcategory2 = ['Bakkerij', 'Boekhandel', 'Drogist', 'Juwelier', 'Kledingwinkel', 'Kringloopwinkel', 'Stomerij'];
        foreach ($subcategory2 as $groep2) {
            DB::table('company_subcategories')->insert([
                'category_id' => '2',
                'name' => $groep2
            ]);
        }

        $subcategory3 = ['Accountants', 'Administratiekantoor', 'Banken', 'Detachering & uitzendbureau', 'Kinderopvang & peuteropvang', 'Ontwikkelingshulp', 'Ouderenhulp', 'Reclamebureau', 'Verzekering'];
        foreach ($subcategory3 as $groep3) {
            DB::table('company_subcategories')->insert([
                'category_id' => '3',
                'name' => $groep3
            ]);
        }

        $subcategory4 = ['Apotheek', 'Fysiotherapie', 'Gezichtsverzorging', 'Huisarts', 'Mondzorg', 'Thuiszorg', 'Voetzorg', 'Ziekenhuis', 'Zorginstelling'];
        foreach ($subcategory4 as $groep4) {
            DB::table('company_subcategories')->insert([
                'category_id' => '4',
                'name' => $groep4
            ]);
        }

        $subcategory5 = ['Beglazing', 'Behanger', 'Elektrotechniek', 'Hovenier', 'Inrichting', 'Tuincentra', 'Verbouwen'];
        foreach ($subcategory5 as $groep5) {
            DB::table('company_subcategories')->insert([
                'category_id' => '5',
                'name' => $groep5
            ]);
        }

        $subcategory6 = ['Balsporten', 'Creatief', 'Dieren', 'Eetgelegenheden', 'Evenementen', 'Hotels', 'Musea', 'Natuur & Milieu', 'Reizen', 'Religie', 'Watersport'];
        foreach ($subcategory6 as $groep6) {
            DB::table('company_subcategories')->insert([
                'category_id' => '6',
                'name' => $groep6
            ]);
        }

        $subcategory7 = ['Basisscholen', 'MBO onderwijs', 'Middelbare scholen'];
        foreach ($subcategory7 as $groep7) {
            DB::table('company_subcategories')->insert([
                'category_id' => '7',
                'name' => $groep7
            ]);
        }

        $subcategory8 = ['Autodealers', 'Automaterialen', 'Autoverhuur', 'Garage', 'Openbaar vervoer', 'Rijscholen', 'Taxibedrijven', 'Tweewielers'];
        foreach ($subcategory8 as $groep8) {
            DB::table('company_subcategories')->insert([
                'category_id' => '8',
                'name' => $groep8
            ]);
        }
    }
}
