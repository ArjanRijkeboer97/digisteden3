<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\CompanyCategory;
use App\Model\CompanySubCategory;
use App\Services\iCompanyService;

class CompanySubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('adm.companySubCategory.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cat = new CompanySubCategory();
        $cat->category_id = $request->category;
        $cat->name = $request->name;
        $cat->save();
        $request->session()->flash('alert-success', 'Subcategorie is succesvol aangemaakt!');

        if ($request->submit == 'saveadd') {
            return view('adm.companySubCategory.create')->with(['mode' => 'create']);
        } else {
            return view('adm.companySubCategory.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = CompanyCategory::wherenull('deleted_at')->get();

        return view('adm.companySubCategory.create')
            ->with(['mode' => 'create', 'categories' => $categories]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, iCompanyService $companyService)
    {
        $cat = $companyService->getCompanySubCategoryById($id);
        $categories = CompanyCategory::wherenull('deleted_at')->get();

        return view('adm.companySubCategory.create')
            ->with(['mode' => 'edit', 'cat' => $cat, 'categories' => $categories]);
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
        $categories = CompanyCategory::wherenull('deleted_at')->get();
        $cat = $companyService->getCompanySubCategoryById($id);
        $cat->category_id = $request->category;
        $cat->name = $request->name;
        $cat->save();

        $request->session()->flash('alert-success', 'Subcategorie is succesvol gewijzigd!');
        if ($request->submit == 'saveclose') {
            return redirect()->route('companySubCategory');
        } else {
            return view('adm.companySubCategory.create')->with(['mode' => 'edit', 'cat' => $cat, 'categories' => $categories]);
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
        $cat = $companyService->getCompanySubCategoryById($id);
        $cat->delete();

        return redirect()->route('companySubCategory');
    }
}
