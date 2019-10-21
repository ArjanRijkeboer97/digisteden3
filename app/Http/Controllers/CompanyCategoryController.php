<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\CompanyCategory;
use App\Services\iCompanyService;

class CompanyCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('adm.companyCategory.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cat = new CompanyCategory();
        $cat->name = $request->name;
        $cat->save();
        $request->session()->flash('alert-success', 'Categorie is succesvol aangemaakt!');

        if ($request->submit == 'saveadd') {
            return view('adm.companyCategory.create')->with(['mode' => 'create']);
        } else {
            return view('adm.companyCategory.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adm.companyCategory.create')
            ->with(['mode' => 'create']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, iCompanyService $companyService)
    {
        $cat = $companyService->getCompanyCategoryById($id);
        return view('adm.companyCategory.create')
            ->with(['mode' => 'edit', 'cat' => $cat]);
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
        $cat = $companyService->getCompanyCategoryById($id);
        $cat->name = $request->name;
        $cat->save();

        $request->session()->flash('alert-success', 'Categorie is succesvol gewijzigd!');
        if ($request->submit == 'saveclose') {
            return redirect()->route('admCompanyCategory');
        } else {
            return view('adm.companyCategory.create')->with(['mode' => 'edit', 'cat' => $cat]);
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
        $cat = $companyService->getCompanyCategoryById($id);
        $cat->delete();

        return redirect()->route('admCompanyCategory');
    }
}
