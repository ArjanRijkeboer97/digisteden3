<?php

namespace App\Http\Controllers;

use DB;
use App\Model\User;
use App\Model\CompanyType;
use App\Model\NewsCategory;
use \App\Model\Vacature;
// use App\Services\iNewsService;
// use App\Services\iPageService;
// use App\Services\iColumnService;
// use App\Services\iAgendaService;
use App\Services\iCompanyService;
// use App\Services\iVacatureService;
// use App\Services\iPinboardService;
// use App\Helpers\ChartHelper;
// use App\Services\iInterestingArticleService;

class AdmController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Get item for dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function getDashboard(iNewsService $newsService)
    {
        $mostRead = $newsService->getMostReadNews(10);
        $charts = ChartHelper::getCharts();
        $openCompanies = DB::table('company_shadow')->where('deleted_at', null)->count();
        return view('dashboard')->with(['charts' => $charts, 'mostRead' => $mostRead, 'openCompanies' => $openCompanies]);
    }

    /**
     * get news overview page
     *
     * @return \Illuminate\Http\Response
     */
    public function getNewsOverview()
    {
        $users = User::all();

        $newsTags = DB::table('taggables')
            ->join('tags', 'tags.id', 'taggables.tag_id')
            ->where('taggable_type', 'App\\Model\\NewsItem')
            ->select('tag')
            ->get();

        $newsTagsJs = json_encode($newsTags->pluck('tag')->toArray());

        return view('adm.news.news')->with(['users' => $users, 'tags' => $newsTags, 'newsTagsJs' => $newsTagsJs]);
    }

    /**
     * get news overview page
     *
     * @return \Illuminate\Http\Response
     */
    public function getInterestingOverview(iInterestingArticleService $interestingArticleService)
    {
        $users = User::all();

        $items = $interestingArticleService->getAllInterestingArticles();
        $newsTags = DB::table('taggables')
            ->join('tags', 'tags.id', 'taggables.tag_id')
            ->where('taggable_type', 'App\\Model\\InterestingArticle')
            ->select('tag')
            ->get();

        $newsTagsJs = json_encode($newsTags->pluck('tag')->toArray());

        return view('adm.interesting.interesting')->with(['items' => $items, 'users' => $users, 'tags' => $newsTags, 'newsTagsJs' => $newsTagsJs]);
    }

    public function getPinboardOverview(iPinboardService $pinboardService)
    {
        return view('adm.pinboard.pinboard');
    }

    /**
     * get agenda overview page
     *
     * @return \Illuminate\Http\Response
     */
    public function getAgendaOverview(iAgendaService $agendaService)
    {
        $users = User::all();

        $tags = DB::table('taggables')
            ->join('tags', 'tags.id', 'taggables.tag_id')
            ->where('taggable_type', 'App\\Model\\AgendaItem')
            ->select('tag')
            ->get();

        return view('adm.agenda.agenda')->with(['users' => $users, 'tags' => $tags]);
    }

    /**
     * get company overview page
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function getCompanyOverview(iCompanyService $companyService)
    {
        $companyItems = $companyService->getCompanyADMOverview();
        $types = CompanyType::all();

        // return view('adm.company.company')->with(['companyItems' => $companyItems, 'types' => $types]);
        return view('company')->with(['companyItems' => $companyItems, 'types' => $types]);
    }

    /**
     * get comapny overview page
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function getCompanyTypeOverview(iCompanyService $companyService)
    {
        $types = CompanyType::all();

        return view('companyTypes.companyType')->with(['companyItems' => $types, 'types' => $types]);
    }

    /**
     * get news category overviewpage
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function getNewsCategoryOverview(iNewsService $newsService)
    {
        $cats = NewsCategory::all();

        return view('adm.newsCategory.newscategory')->with(['cats' => $cats]);
    }

    /**
     * get column overview page
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function getColumnOverview(iColumnService $columnService)
    {
        $columnItems = $columnService->getColumnADMOverview();
        $users = User::all()->sortBY('name');


        return view('adm.column.column')->with(['columnItems' => $columnItems, 'users' => $users]);
    }

    /**
     * get page overview page
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function getPageOverview(iPageService $pageService)
    {
        $pageItems = $pageService->getPageADMOverview();

        return view('adm.page.page')->with('pageItems', $pageItems);
    }

    /**
     * get page overview page
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function getVacatureOverview(iVacatureService $vacatureService)
    {
        // $vacatures = $vacatureService->getVacatureADMOverview();

        $places = Vacature::select('city')->distinct()->orderBy('city')->get()->pluck('city');

        return view('adm.vacatures.vacature')->with(['places' => $places]);
    }


    /**
     * get mutation overview page
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function mutationOverview(iCompanyService $companyService)
    {
        $mutations = $companyService->getCompanyMutationOverview();
        // dd($mutations);
        // return view('adm.company.overviewMutation')->with(['mutations' => $mutations]);
        return view('overviewMutation')->with(['mutations' => $mutations]);
    }

    // //used in the filemanager, shows what pages a certain image is used on
    // public static function getPagesWhereImgIsUsed()
    // {
    //     $img_src = $_GET['img_src'];
    //     $newsitems = NewsItem::whereHas('cityItems', function ($query) {
    //         $query->where('city_id', '=', config('siteId'));
    //     })
    //         ->where('image_src', 'like', '%' . $img_src . '%')
    //         ->orWhere('text', 'like', '%' . $img_src . '%')
    //         ->pluck('title')
    //         ->toArray();

    //     $newsAlbumItems = DB::table('newsitems')
    //         ->where('src', 'like', '%' . $img_src . '%')
    //         ->join('news_images', 'newsitems.id', '=', 'news_images.newsitem_id')
    //         ->pluck('title')
    //         ->toArray();

    //     $agendaitems = AgendaItem::whereHas('cityItems', function ($query) {
    //         $query->where('city_id', '=', config('siteId'));
    //     })
    //         ->where('image_src', 'like', '%' . $img_src . '%')
    //         ->orWhere('text', 'like', '%' . $img_src . '%')
    //         ->pluck('title')
    //         ->toArray();

    //     $agendaAlbumItems = DB::table('agenda_items')
    //         ->where('src', 'like', '%' . $img_src . '%')
    //         ->join('agenda_images', 'agenda_items.id', '=', 'agenda_images.agenda_item_id')
    //         ->pluck('title')
    //         ->toArray();

    //     $arrays = [$newsitems, $newsAlbumItems, $agendaitems, $agendaAlbumItems];
    //     $merged = [];

    //     foreach ($arrays as $array) {
    //         foreach ($array as $value) {
    //             $merged[] = $value;
    //         }
    //     }

    //     $merged = array_unique($merged);
    //     $html = '';

    //     foreach ($merged as $item) {
    //         $html .= "<p> {$item}</p>";
    //     }
    //     return $html;
    // }

    // public function moveImageToFolder()
    // {
    //     $directories = AdmController::getDirectories(public_path() . '/photos');

    //     $from = $_GET['from'];
    //     $to = $_GET['to'];

    //     $from = str_replace('http://', '', $from);
    //     $from = str_replace('https://', '', $from);
    //     $from = str_replace($_SERVER['HTTP_HOST'], '', $from);
    //     $from = public_path() . $from;

    //     $to = str_replace('http://', '', $to);
    //     $to = str_replace('https://', '', $to);
    //     $to = str_replace($_SERVER['HTTP_HOST'], '', $to);
    //     $to = public_path() . $to;

    //     // rename(public_path() . '/photos/shares/6R7xK4.jpg', public_path() . '/photos/shares/testerdetest/6R7xK4.jpg');

    //     rename($from, $to);

    //     // return 'verplaatsen geslaagd!';
    // }

    // public static function getDirectories($directory)
    // {
    //     $result = [];

    //     $folders = glob($directory . '/*', GLOB_ONLYDIR);

    //     foreach ($folders as $dir) {
    //         $name = explode('/', $dir);
    //         $name = end($name);

    //         $result[] = [
    //             'name' => $name,
    //             'path' => $dir,
    //             'subfolders' => AdmController::getDirectories($dir)
    //         ];
    //     }

    //     return $result;
    // }


    // );
}