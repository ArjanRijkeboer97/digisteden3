<?php

namespace App\Http\Controllers;

use App\Model\City;
use App\Model\Company;
use App\Model\CompanyType;
use App\Model\CompanyComment;
use App\Model\CompanyCategory;
use App\Model\CompanySubCategory;
use App\Services\iCompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(iCompanyService $companyService)
    {
        
        if (!in_array('Bedrijvengids', config('activeModules'))) {
           return abort(404);
        }
        // Ophalen gegevens


        $companies = $companyService->getCompanyCity();
        // dd($companies);

        foreach ($companies as $key => $company) {
            if (!empty($company->website)) {
                $company->website = explode(",", $company->website);
            } else {
                $companies[$key]->website = [];
            }
        }

        $cities = City::where("group_id", config("siteGroup"))->get();
        $types = CompanyType::wherenull('deleted_at')->get();
        $categories = Companycategory::wherenull('deleted_at')->get();
        $subcategories = CompanySubCategory::wherenull('deleted_at')->get();
        $sitename = config('siteName');
        $sitedomain = config('domain');

        $openGraph = [
            'title' => 'Bedrijvengids',
            'description' => 'Op deze pagina vindt u alle bedrijven binnen ' . config('siteName') . '.',
            'image' => config('siteLogo'),
            'type' => 'website'
        ];

        // View doorsturen met alle data
        return view('company_overview')
            ->with(['companies' => $companies, 'cities' => $cities, 'types' => $types, 'categories' => $categories, 'subcategories' => $subcategories, 'sitename' => $sitename, 'sitedomain' => $sitedomain, 'openGraph' => $openGraph]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Ophalen gegevens
        $types = CompanyType::wherenull('deleted_at')->get();
        $categories = Companycategory::wherenull('deleted_at')->get();
        $subcategories = CompanySubCategory::wherenull('deleted_at')->get();
        // View doorsturen met alle data
        return view('company_form')->with(['mode' => 'create', 'types' => $types, 'categories' => $categories, 'subcategories' => $subcategories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, iCompanyService $companyService)
    {
        $companyService->store($request);
        $request->session()->flash('alert-success', 'Bedrijf is succesvol aangemaakt!');

        // Redirect naar juiste pagina
        if ($request->submit == 'saveadd') {
            return redirect()->route('bedrijvengids.create');
        } else {
            return redirect()->route('admCompany');
        }
    }

    public function storeComment(Request $request, $id, iCompanyService $companyService)
    {
        $companyComment = new CompanyComment();
        $companyService->storeComment($request, $companyComment);

        // company en bijbehorende comments ophalen
        $company = Company::where('id', $id)->firstOrFail();
        $company->website = explode(',', $company->website);
        $comments = CompanyComment::where('company_id', $id)->get();

        // redirect naar bedrijfspagina
        return redirect('/bedrijvengids/' . $company->slug)->with(['company' => $company, 'comments' => $comments]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug, iCompanyService $companyService)
    {
        // Alle bedrijfsgegevens en gekoppelde gegevens ophalen
        $companyItem = $companyService->getCompanyBySlug($slug);
        if (!empty($companyItem->website)) {
            $companyItem->website = explode(",", $companyItem->website);
        } else {
            $companyItem->website = [];
        }

        $comments = CompanyComment::where('company_id', $companyItem->id)->orderBy('created_at', 'DESC')->get();
        $types = CompanyType::wherenull('deleted_at')->get();
        $categories = CompanyCategory::wherenull('deleted_at')->get();
        $subcategories = CompanySubCategory::wherenull('deleted_at')->get();

        $descriptiontags = $companyItem->is_highlighted ? substr($companyItem->description, 0, 300) : '';
        $description = strip_tags($descriptiontags);
        $openGraph = [
            'title' => $companyItem->name,
            'description' => $description,
            'image' => $companyItem->logo ?? config('siteLogo'),
            'type' => 'website'
        ];

        // De view met alle opgehaalde data openen
        return view('company_item')->with(['company' => $companyItem, 'comments' => $comments, 'types' => $types, 'categories' => $categories, 'subcategories' => $subcategories, 'openGraph' => $openGraph]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, iCompanyService $companyService)
    {
        $companyItem = $companyService->getCompanyById($id);

        $tags = $companyItem->listTags();

        $tags = implode(',', $tags->toArray());

        $categories = CompanyCategory::wherenull('deleted_at')->get();
        $subcategories = CompanySubCategory::wherenull('deleted_at')->get();

        $companyItem->website = explode(',', $companyItem->website);

        return view('company_form')->with(['mode' => 'edit', 'companyItem' => $companyItem, 'tags' => $tags, 'categories' => $categories, 'subcategories' => $subcategories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, iCompanyService $companyService)
    {
        $companyItem = $companyService->getCompanyById($id);
        $companyService->update($request, $companyItem);

        $request->session()->flash('alert-success', 'Bedrijf is succesvol gewijzigd!');

        $categories = Companycategory::wherenull('deleted_at')->get();
        $subcategories = CompanySubCategory::wherenull('deleted_at')->get();

        if ($request->submit == 'saveclose') {
            return redirect()->route('admCompany');
        } else {
            return view('company_form')->with(['mode' => 'edit', 'companyItem' => $companyItem, 'tags' => $request->tags, 'categories' => $categories, 'subcategories' => $subcategories]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, iCompanyService $companyService)
    {
        $companyItem = $companyService->getCompanyById($id);

        $companyItem->delete();

        return redirect()->route('admCompany');
    }

    public function setPublished($id, iCompanyService $companyService)
    {
        $companyItem = $companyService->getCompanyById($id);
        $companyItem->is_published = !$companyItem->is_published;
        $companyItem->save();

        return redirect()->route('admCompany');
    }

    public function getCompanyOverview(iCompanyService $companyService)
    {
        $companyItems = $companyService->getCompanyADMOverview();
        $types = CompanyType::all();

        // return view('adm.company.company')->with(['companyItems' => $companyItems, 'types' => $types]);
        return view('company')->with(['companyItems' => $companyItems, 'types' => $types]);
    }
}
