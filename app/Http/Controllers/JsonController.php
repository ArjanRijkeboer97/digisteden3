<?php

namespace App\Http\Controllers;

 use DB;
// use Auth;
// use App\Model\User;
// use App\Model\Page;
// use App\Model\Advertisement;
// use App\Model\AgendaItem;
// use App\Model\Column;
use App\Model\Company;
use App\Model\CompanyType;
use App\Model\CompanyShadow;
// use App\Model\NewsCategory;
// use App\Model\NewsItem;
// use App\Model\InterestingArticle;
// use App\Model\AdGroup;
// use App\Model\PinBoard;
// use App\Model\Newsletter;
// use App\Model\Subscriber;
// use App\Model\SubscriberGroup;
// use App\Model\Vacature;
// use App\Model\VacatureFeed;
// use App\Services\iNewsService;
// use App\Services\iUserService;
// use App\Services\iAgendaService;
use App\Services\iCompanyService;
// use App\Services\iVacatureService;
// use App\Services\iVacatureFeedService;
// use App\Services\iAdvertisementService;
use Illuminate\Http\Request;
use Lecturize\Tags\Models\Tag;
use Spatie\Permission\Models\Role;
use App\Model\CompanyCategory;
use App\Model\CompanySubCategory;
// use App\Services\iInterestingArticleService;

class JsonController extends Controller
{

    public function JsonCompany(Request $request, iCompanyService $companyService)
    {
        $columns = array(
            0 => 'name',
            1 => 'type_id',
            2 => 'options',
        );

        $limit = $request->input('length');
        $companies = $companyService->getCompanyADMOverview();
        $totalData = count($companies);
        $totalFiltered = $totalData;
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        // FILTERS============================================================
        $items = Company::where('city_id', config('siteId'))
            ->when(!empty($request->input('search.value')), function ($query) use ($request) {
                $search = $request->input('search.value');
                return $query->where('name', 'LIKE', "%{$search}%");
            })
            ->when(!empty($request->input('type')), function ($query) use ($request) {
                return $query->where('type_id', $request->input('type'));
            })
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $totalFiltered = Company::where('city_id', config('siteId'))
            ->when(!empty($request->input('search.value')), function ($query) use ($request) {
                $search = $request->input('search.value');
                return $query->where('name', 'LIKE', "%{$search}%");
            })
            ->when(!empty($request->input('type')), function ($query) use ($request) {
                return $query->where('type_id', $request->input('type'));
            })
            ->count();

        // BUILD JSON============================================================
        $data = array();
        if (!empty($items)) {
            foreach ($items as $item) {
                $slug = $item->slug;
                $id = $item->id;
                $published = $item->is_published ? 'text-success' : 'text-danger';

                $nestedData['name'] = "<a class='text-color' href='bedrijvengids/{$id}/edit'>" . $item->name . "</a>";
                $nestedData['type'] = "<a class='text-color' href='bedrijvengids/{$id}/edit'>" .  $item->type->name . "</a>";

                // if (Auth::user()->hasPermissionTo('everything')) {
                    $nestedData['options'] = "<div class='text-right'>
                    <a class='overview-icon' title='Wijzigen' data-toggle='tooltip' data-placement='top' href='bedrijvengids/{$id}/edit'><i class='fas fa-edit ml-1'></i></a>
                    <a class='overview-icon {$published}' title='Publiceren' data-toggle='tooltip' data-placement='top' href='/adm/bedrijvengids/published/{$id}'><i class='fas fa-circle mx-1 '></i></a>
                    <a class='overview-icon' title='Verwijderen' data-toggle='tooltip' data-placement='top' onclick='return Delete({$id},this)' data-token='" . csrf_token() . "'><i class='fas fa-trash-alt mr-1'></i></a></div>";
                // } else {
                    // if (Auth::user()->hasPermissionTo('edit company')) {
                        // $nestedData['options'] .= "<a class='overview-icon' title='Wijzigen' data-toggle='tooltip' data-placement='top' href='bedrijvengids/{$id}/edit'><i class='fas fa-edit ml-1'></i></a>";
                    // }

                    // if (Auth::user()->hasPermissionTo('publish company')) {
                        // $nestedData['options'] .= "<a class='overview-icon {$published}' title='Publiceren' data-toggle='tooltip' data-placement='top' href='/adm/bedrijvengids/published/{$id}'><i class='fas fa-circle mx-1 '></i></a>";
                    // }
// 
                    // if (Auth::user()->hasPermissionTo('delete company')) {
                        // $nestedData['options'] .= "<a class='overview-icon' title='Verwijderen' data-toggle='tooltip' data-placement='top' onclick='return Delete({$id},this)' data-token='" . csrf_token() . "'><i class='fas fa-trash-alt mr-1'></i></a>";
                    // }
                // }
                $nestedData['options'] .= "</div>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function JsonCompanyMutation(Request $request, iCompanyService $companyService)
    {
        $columns = array(
            0 => 'name',
            1 => 'created_at',
            2 => 'is_new',
            3 => 'options',
        );

        $mutations = $companyService->getCompanyMutationOverview();
        $totalData = count($mutations);
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        // FILTERS============================================================
        $mutations = CompanyShadow::where('city_id', config('siteId'))
            ->when(!empty($request->input('search.value')), function ($query) use ($request) {
                $search = $request->input('search.value');
                return $query->where('name', 'LIKE', "%{$search}%");
            })
            ->when(!empty($request->input('type')), function ($query) use ($request) {
                $type = $request->input('type') == 'Nieuw' ? 1 : 0;
                return $query->where('is_new', $type);
            })
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $totalFiltered = CompanyShadow::where('city_id', config('siteId'))
            ->when(!empty($request->input('search.value')), function ($query) use ($request) {
                $search = $request->input('search.value');
                return $query->where('name', 'LIKE', "%{$search}%");
            })
            ->when(!empty($request->input('type')), function ($query) use ($request) {
                return $query->where('is_new', $request->input('type'));
            })
            ->count();

        // BUILD JSON============================================================
        $data = array();
        if (!empty($mutations)) {
            foreach ($mutations as $mutation) {
                $id = $mutation->id;
                // $nestedData['name'] = $mutation->name;
                $nestedData['name'] = "<a href='/adm/bedrijfsmutaties/$mutation->id/edit' title='Open'>" . strip_tags($mutation->name) . "</a>";
                $nestedData['created_at'] = $mutation->created_at;
                $nestedData['is_new'] = $mutation->is_new == 1 ? 'Nieuw' : 'Aanpassing';
                $nestedData['options'] = "<div align='right'>
                                        &nbsp;<a href='/adm/bedrijfsmutaties/$mutation->id/edit' title='Open' ><i class='fas fa-list'></i></a>
                                        &nbsp;&nbsp;
                                        <a class='overview-icon' title='Verwijderen' data-toggle='tooltip' data-placement='top' onclick='return Delete({$id},this)' data-token='" . csrf_token() . "'><i class='fas fa-trash-alt mr-1'></i></a>&nbsp;";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function JsonCompanyCategory(Request $request, iCompanyService $companyService)
    {
        $columns = array(
            0 => 'name',
            1 => 'options',
        );

        $limit = $request->input('length');
        $companyCategories = CompanyCategory::all();
        $totalData = count($companyCategories);
        $totalFiltered = $totalData;
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        // FILTERS============================================================
        $items = CompanyCategory::when(!empty($request->input('search.value')), function ($query) use ($request) {
            $search = $request->input('search.value');
            return $query->where('name', 'LIKE', "%{$search}%");
        })
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $totalFiltered = CompanyCategory::when(!empty($request->input('search.value')), function ($query) use ($request) {
            $search = $request->input('search.value');
            return $query->where('name', 'LIKE', "%{$search}%");
        })->count();

        $totalFiltered = $items->count();

        // BUILD JSON============================================================
        $data = array();
        if (!empty($items)) {
            foreach ($items as $item) {
                $id = $item->id;

                $nestedData['name'] = "<a class='text-color' href='categorie/{$id}/edit'>" . $item->name . "</a>";

                $nestedData['options'] = "<div class='text-right'>
                    <a class='overview-icon' title='Wijzigen' data-toggle='tooltip' data-placement='top' href='categorie/{$id}/edit'><i class='fas fa-edit ml-1'></i></a>
                    <a class='overview-icon' title='Verwijderen' data-toggle='tooltip' data-placement='top' onclick='return Delete({$id},this)' data-token='" . csrf_token() . "'><i class='fas fa-trash-alt mr-1'></i></a></div>";
                $nestedData['options'] .= "</div>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function JsonCompanySubCategory(Request $request, iCompanyService $companyService)
    {
        $columns = array(
            0 => 'name',
            1 => 'category_id',
            2 => 'options',
        );

        $limit = $request->input('length');
        $companySubCategories = CompanySubCategory::all();
        $totalData = count($companySubCategories);
        $totalFiltered = $totalData;
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        // FILTERS============================================================
        $items = CompanySubCategory::when(!empty($request->input('search.value')), function ($query) use ($request) {
            $search = $request->input('search.value');
            return $query->where('name', 'LIKE', "%{$search}%");
        })->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $totalFiltered = CompanySubCategory::when(!empty($request->input('search.value')), function ($query) use ($request) {
            $search = $request->input('search.value');
            return $query->where('name', 'LIKE', "%{$search}%");
        })->count();

        $totalFiltered = $items->count();

        // BUILD JSON============================================================
        $data = array();
        if (!empty($items)) {
            foreach ($items as $item) {
                $id = $item->id;

                $nestedData['name'] = "<a class='text-color' href='subcategorie/{$id}/edit'>" . $item->name . "</a>";

                $nestedData['category_id'] = "<a class='text-color' href='subcategorie/{$id}/edit'>" . $item->category->name . "</a>";

                
                $nestedData['options'] = "<div class='text-right'>
                    <a class='overview-icon' title='Wijzigen' data-toggle='tooltip' data-placement='top' href='subcategorie/{$id}/edit'><i class='fas fa-edit ml-1'></i></a>
                    <a class='overview-icon' title='Verwijderen' data-toggle='tooltip' data-placement='top' onclick='return Delete({$id},this)' data-token='" . csrf_token() . "'><i class='fas fa-trash-alt mr-1'></i></a></div>";
                $nestedData['options'] .= "</div>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function JsonCompanyType(Request $request, iCompanyService $companyService)
    {
        $columns = array(
            0 => 'name',
            1 => 'options',
        );

        $limit = $request->input('length');
        $companyTypes = $companyService->getCompanyTypes();
        $totalData = count($companyTypes);
        $totalFiltered = $totalData;
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        // FILTERS============================================================
        $items = CompanyType::when(!empty($request->input('search.value')), function ($query) use ($request) {
            $search = $request->input('search.value');
            return $query->where('name', 'LIKE', "%{$search}%");
        })
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $totalFiltered = CompanyType::when(!empty($request->input('search.value')), function ($query) use ($request) {
            $search = $request->input('search.value');
            return $query->where('name', 'LIKE', "%{$search}%");
        })
            ->count();

        // BUILD JSON============================================================
        $data = array();
        if (!empty($items)) {
            foreach ($items as $item) {
                $id = $item->id;

                $nestedData['name'] = "<a class='text-color' href='bedrijfstypes/{$id}/edit'>" . $item->name . "</a>";

                $nestedData['options'] = "<div class='text-right'>
                    <a class='overview-icon' title='Wijzigen' data-toggle='tooltip' data-placement='top' href='bedrijfstypes/{$id}/edit'><i class='fas fa-edit ml-1'></i></a>
                    <a class='overview-icon' title='Verwijderen' data-toggle='tooltip' data-placement='top' onclick='return Delete({$id},this)' data-token='" . csrf_token() . "'><i class='fas fa-trash-alt mr-1'></i></a></div>";
                $nestedData['options'] .= "</div>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }
}