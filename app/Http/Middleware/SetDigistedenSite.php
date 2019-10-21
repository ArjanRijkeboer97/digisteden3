<?php

namespace App\Http\Middleware;

use Closure;
use Request;
use App\Model\City;
use App\Model\Module;
use App\Model\Setting;
use App\Model\CityGroup;
use App\Model\CityGroupDomain;
use App\Model\SettingsCityGroup;
use App\Enum\SiteType;
use App\Helpers\ColorHelper;

class SetDigistedenSite
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $domain = $request->server->get('SERVER_NAME');
        $cityGroup = '';
        $siteName = '';
        $siteId = '';
        $siteColor = '';
        $siteType = '';

        try {
            $cityDomain = \App\Model\CityDomain::where('domain', '=', $domain)->first();
        } catch (\Illuminate\Database\QueryException $ex) {
            dd($domain . 'kan niet gevonden worden in de tabel City_domain');
        }

        if ($cityDomain) {
            $siteName = $cityDomain->city->name;
            $siteUrl = $cityDomain->city->domain;
            $siteId = $cityDomain->city->id;
            $siteColor = $cityDomain->city->color;
            $siteColorAlpha = $cityDomain->city->color . '88';
            $siteType = SiteType::CITY;
            $cityGroup = $cityDomain->city->group_id;
            $cityGroupCityIds = [$siteId];
            $siteSettings = Setting::where('city_id', $siteId)->first();
        } elseif ($cityGroupDomain = CityGroupDomain::where('domain', $domain)->first()) {

            $cityGroup = CityGroup::where('id', $cityGroupDomain->group_id)->first();
            $cityGroupCityIds = City::where('group_id', $cityGroupDomain->group_id)->get()->pluck('id');
            $siteUrl = $cityGroupDomain->domain;
            $siteName = $cityGroupDomain->cityGroup->name;
            $siteColor = $cityGroupDomain->cityGroup->color;
            $siteColorAlpha = $cityGroupDomain->cityGroup->color . '88';

            $siteType = SiteType::CITY_GROUP;
            $siteSettings = SettingsCityGroup::where('citygroup_id', $cityGroup->id)->first();
        }

        if (!isset($siteSettings) && !Request::is('install')) {
            dd('Er kan geen site-configuratie worden gevonden');
        } elseif (isset($siteSettings)) {
            $cities = \App\Model\City::where('group_id', $cityGroup)
                ->where('id', '!=', $siteId)
                ->get();

            $siteIcon = $siteSettings->favicon;
            $siteLogo = $siteSettings->logo;
            $siteLogoBig = $siteSettings->logoBig;
            $siteBanner = $siteSettings->banner;
            $siteSlogan = $siteSettings->slogan;
            $siteEmail = $siteSettings->email;
            $siteFooter = $siteFooter = [$siteSettings->footer_1, $siteSettings->footer_2, $siteSettings->footer_3];
            $siteNewsTextFooter = $siteSettings->news_text;

            // $colorHelper = ColorHelper::fromHex($siteColor);
            // $siteColorText = $colorHelper->returnBWContrast() == 1 ? '#ffffff' : '#000000';
            // $siteColorLight = $colorHelper->returnLighterHex(0.7);
            // $siteColorLightText = ColorHelper::fromHex($siteColorLight)->returnBWContrast() == 1 ? '#ffffff' : '#000000';

            $months = ['01' => 'januari', '02' => 'februari', '03' => 'maart', '04' => 'april', '05' => 'mei', '06' => 'juni', '07' => 'juli', '08' => 'augustus', '09' => 'september', '10' => 'oktober', '11' => 'november', '12' => 'december'];
            $days = ['MO' => 'Maandag', 'TU' => 'Dinsdag', 'WE' => 'Woensdag', 'TH' => 'Donderdag', 'FR' => 'Vrijdag', 'SA' => 'Zaterdag', 'SU' => 'Zondag'];
            $alfabet = ["0/9", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];

            $activeModules = Module::where('is_active', 1)->pluck('name')->toArray();
            // dd($activeModules);

            $vacatureCities = explode(',', $siteSettings->vacature_show_cities);
            sort($vacatureCities);

            config([
                'domain' => $domain,
                'siteName' => $siteName,
                'siteId' => $siteId,
                'cityGroupCityIds' => $cityGroupCityIds,
                'cityGroup' => $cityGroup,
                'siteUrl' => $siteUrl,
                'siteSlogan' => $siteSlogan,
                'siteEmail' => $siteEmail,
                'siteColor' => $siteColor,
                'siteColorAlpha' => $siteColorAlpha,
                'siteSettings' => $siteSettings,
                'siteIcon' => $siteIcon,
                'siteLogo' => $siteLogo,
                'siteLogoBig' => $siteLogoBig,
                'siteBanner' => $siteBanner,
                'siteFooter' => $siteFooter,
                // 'siteColorText' => $siteColorText,
                // 'siteColorLight' => $siteColorLight,
                'siteNewsTextFooter' => $siteNewsTextFooter,
                // 'siteColorLightText' => $siteColorLightText,
                'siteType' => $siteType,
                // 'newsCategories' => \App\Model\NewsCategory::all(),
                // 'agendaCategories' => \App\Model\AgendaCategory::all(),
                'companyTypes' => \App\Model\CompanyType::all(),
                'cities' => $cities,
                'months' => $months,
                'days' => $days,
                "alfabet" => $alfabet,
                'storagePath' => \Request::root() . '/storage/media/',
                'noImage' => 'https://via.placeholder.com/500x200?text=Geen+Afbeelding',
                'reCaptcha_key' => $siteSettings->recaptcha_key,
                'leaflet_key' => $siteSettings->leaflet_key,
                'activeModules' => $activeModules,
                'vacatureShowCities' => $vacatureCities

            ]);
        }
        return $next($request);
    }
}
