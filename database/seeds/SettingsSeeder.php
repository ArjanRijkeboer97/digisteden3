<?php

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = ['dordrecht', 'papendrecht', 'alblasserdam', 'ambacht', 'zwijndrecht', 'sliedrecht', 'digisteden3', 'woudrichem', 'aalburg', 'werkendam'];
        for ($i = 0; $i < count($cities); $i++) {
            DB::table('settings')->insert([
                'city_id' => $i + 1,
                'favicon' => 'storage/media/Drechtsteden/favicons/' . $cities[$i] . '.ico',
                'logo' => 'storage/media/Drechtsteden/logos/' . $cities[$i] . '.jpg',
                'logoBig' => 'storage/media/Drechtsteden/logos-groot/big_' . $cities[$i] . '.jpg',
                'banner' => 'storage/media/Drechtsteden/banners/banner_' . $cities[$i] . '.png',
                'slogan' => 'Alles over ' . ucfirst($cities[$i]),
                'email' => 'redactie@' . $cities[$i] . '.net',
                'recaptcha_key' => '6LcuRacUAAAAAEpG1jNGw4ZQtQt562sPyHD_IWzC',
                'recaptcha_secret' => '6LcuRacUAAAAAJ7NlYR4nUMrug-twatPJvZ--Ubm',
                'leaflet_key' => 'pk.eyJ1IjoiYXZhbnQtd2ViZGllbnN0ZW4iLCJhIjoiY2p4NXRoNGE4MDU1aTQzcXR0enR2dW45YSJ9.0BBvhh_rJw7HRN7Fo9EQLg',
                'vacature_show_cities' => "Dordrecht,Papendrecht,Alblasserdam,Sliedrecht,Heinenoord,Drechtsteden,Ridderkerk,Hendrik-Ido-Ambacht,Moerdijk,Bleskensgraaf,Zuid-Holland,Barendrecht,Hardinxveld-Giessendam,Breda,'s-Gravendeel,Molenaarsgraaf",
                'footer_1' => 'Dit is footer kolom 1',
                'footer_2' => 'Dit is footer kolom 2',
                'footer_3' => 'Dit is footer kolom 3',
                'footer_4' => 'Dit is footer kolom 4',
                'contact_1' => '<p>Aangezien wij zeer regelmatig contactaanvragen krijgen of gebeld worden met vragen die wij niet kunnen beantwoorden, hieronder een korte uitleg:</p><p>' . ucfirst($cities[$i]) . '.net is een digitale stad, een informatieve dienst door een bewoner uit uw woonplaats ' . ucfirst($cities[$i]) . ' opgezet over uw woonplaats. Wij hebben geen banden met de gemeente, die u onder <a href="https://' . strtolower($cities[$i]) . '.nl" target="_blank">' . strtolower($cities[$i]) . '.nl</a> vindt. Ook zijn wij niet van de in de nieuwsberichten of activiteiten genoemde organisaties. Als de contactgegevens van een organisatie niet vermeld staan, kunnen wij u die ook niet geven.</p><p>Wilt u ons echter vragen stellen over deze website zelf of over de informatie die wij vermelden gebruik dan het contactformulier hiernaast.</p>',
                'news_text' => 'Test',
                    ]);

            DB::table('citygroup_settings')->insert([
                'citygroup_id' => 2,
                'favicon' => 'favicon',
                'logo' => 'klein logo',
                'logoBig' => 'groot logo',
                'banner' => 'banner bovenaan',
                'slogan' => 'site slogan',
                'email' => 'redactie@website.net',
                'recaptcha_key' => '6LcuRacUAAAAAEpG1jNGw4ZQtQt562sPyHD_IWzC',
                'recaptcha_secret' => '6LcuRacUAAAAAJ7NlYR4nUMrug-twatPJvZ--Ubm',
                'leaflet_key' => 'pk.eyJ1IjoiYXZhbnQtd2ViZGllbnN0ZW4iLCJhIjoiY2p4NXRoNGE4MDU1aTQzcXR0enR2dW45YSJ9.0BBvhh_rJw7HRN7Fo9EQLg',
                'footer_1' => 'Dit is footer kolom 1',
                'footer_2' => 'Dit is footer kolom 2',
                'footer_3' => 'Dit is footer kolom 3',
                'footer_4' => 'Dit is footer kolom 4',
                'contact_1' => 'Dit is de contact tekst',
                'news_text' => 'Test',
            ]);
        }
    }
}
