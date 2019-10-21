<?php

namespace App\Http\Controllers;

use App\Model\CompanyType;
use App\Services\iCompanyService;
use Illuminate\Http\Request;

class CompanyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(iCompanyService $companyService)
    { }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companyTypes.company_type_form')->with(['mode' => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $companyType = new CompanyType();

        $companyType->name = $request->name;
        $companyType->save();

        if ($request->submit == 'saveadd') {
            return redirect()->route('bedrijfstypes.create');
        } else {
            return redirect()->route('admCompanyType');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, iCompanyService $companyService)
    {
        $companyType = $companyService->getCompanyTypeById($id);


        return view('companyTypes.company_type_form')->with(['mode' => 'edit', 'companyItem' => $companyType]);
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
        $companyType = $companyService->getCompanyTypeById($id);

        $companyType->name = $request->name;
        $companyType->save();

        if ($request->submit == 'saveclose') {
            return redirect()->route('admCompanyType');
        } else {
            return view('companyTypes.company_type_form')->with(['mode' => 'edit', 'companyItem' => $companyType]);
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
        $companyType = $companyService->getCompanyTypeById($id);

        $companyType->delete();

        return redirect()->route('admCompanyType');
    }
}
