<?php

namespace App\Http\Controllers;

use Mail;
use \Input as Input;
use App\Model\Company;
use App\Model\CompanyShadow;
use App\Model\CompanyCategory;
use App\Model\MutationTemplate;
use App\Mail\SendCompanyMutation;
use App\Services\iCompanyService;
use Illuminate\Http\Request;


class CompanyShadowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //als request->company_id  gelijk is aan 0, is er geen huidig bedrijf, en is het een nieuwe aanvraag
        if ($request->company_id != 0) {
            $company_shadow = CompanyShadow::where('company_id', $request->company_id)->get();
            if (!$company_shadow->isEmpty()) {
                $company = Company::where('id', $request->company_id)->get();
                return redirect('/bedrijvengids/' . $company[0]->slug)->with('error', 'Er is al een wijzigingsverzoek voor uw bedrijf ingediend.');
            }
        }

        //alle ingevoerde gegevens in variable companyItem plaatsen
        $companyItem = new CompanyShadow();
        $companyItem->company_id = $request->company_id;
        $companyItem->is_new = $request->is_new;
        $companyItem->name = $request->name;
        $companyItem->address = $request->address;
        $companyItem->zip_code = $request->zip_code;
        $companyItem->city = $request->city;
        $companyItem->telephone = $request->telephone;
        $companyItem->email = $request->email;
        $companyItem->video = $request->video;
        //controle of request->website een array is
        if (is_array($request->website)) {
            if (count($request->website) > 1) {
                $companyItem->website = implode(",", array_filter($request->website));
            } else {
                $companyItem->website = $request->website[0];
            }
        } else {
            $companyItem->website = $request->website;
        }
        $companyItem->description = $request->description;
        //lat en lng tijdelijke waarden.
        $companyItem->lat = "51.42757800";
        $companyItem->lng = "4.72260300";
        $companyItem->type_id = $request->type_id;
        $companyItem->subCategory_id = $request->subCategory_id;
        $companyItem->city_id = config('siteId');
        $companyItem->is_published = $request->is_published;
        $companyItem->is_highlighted = $request->is_highlighted;
        $companyItem->logo = $request->logo;
        // if (Input::hasFile('logo')) {
        //     $request->validate([
        //         'logo' => 'image|mimes:png,gif,jpeg,jpg,bmp'
        //     ]);
        //     $file     = Input::file('logo');
        //     $fileExt   = $file->getClientOriginalExtension();
        //     $fileRename = time() . '_' . uniqid() . '.' . $fileExt;
        //     $uploadDir    = public_path('storage/media/drechtsteden/bedrijfslogos');
        //     $file->move($uploadDir, $fileRename);
        //     $companyItem->logo = $fileRename;
        // }
        $companyItem->created_at = date("Y-m-d H:i:s");
        //companyItem opslaan
        $companyItem->save();

        //redirects
        //als request->is_new gelijk is aan 1 is het een nieuwe aanvraag, anders niet.
        if ($request->is_new == 1) {
            return redirect('/bedrijvengids')->with('new', 'Aanmeldformulier succesvol ingevoerd, Bij goedkeuring wordt de bevestigingsmail gestuurd naar: ' . $companyItem->email);
        } elseif ($request->is_new == 0) {
            $company = Company::where('id', $request->company_id)->get();
            return redirect('/bedrijvengids/' . $company[0]->slug)->with('success', 'Wijzigingsaanvraag succesvol ingevoerd, Bij goedkeuring wordt de bevestigingsmail gestuurd naar: ' . $company[0]->email);
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
    public function edit($id)
    {
        $company_shadow = CompanyShadow::where('id', $id)->first();
        $company_id = $company_shadow->company_id;

        //als company_id geljik is aan 0 is er geen huidig bedrijf en is het een nieuwe invoer/aanvraag
        if ($company_id == 0) {
            // emailtemplate ophalen
            $message = MutationTemplate::where('type_id', 1)->first();
            $category_shadow = CompanyCategory::where('id', $company_shadow->subCategory->category_id)->first();
            $company_shadow->subCategory->category_name = $category_shadow->name;

            return view('mutation_form')->with(['mode' => 'Nieuw', 'company_shadow' => $company_shadow, 'message' => $message]);
        } else {
            // emailtemplate ophalen
            $message = MutationTemplate::where('type_id', 2)->first();
            $category_shadow = CompanyCategory::where('id', $company_shadow->subCategory->category_id)->first();
            $company_shadow->subCategory->category_name = $category_shadow->name;

            $company = Company::where('id', $company_id)->first();
            $category = CompanyCategory::where('id', $company->subCategory->category_id)->first();
            $company->subCategory->category_name = $category->name;
            return view('mutation_form')->with(['mode' => 'Aanpassing', 'company_shadow' => $company_shadow, 'company' => $company, 'message' => $message]);
        }
    }

    /**
     *
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        //
    }

    public function confirmChanges($id, iCompanyService $companyService, Request $request)
    {
        //highlighted en published invoervelden ophalen
        $highlighted = $request->highlighted;
        $published = $request->published;

        // controleren of er al een bestaand bedrijf aanwezig is, zo niet maak dan een nieuwe vermelding aan
        $company_shadow = CompanyShadow::where('id', $id)->first();
        if ($company_shadow->company_id == 0) {
            $company = new Company();
            $company_old = '0';
        } else {
            $company = $companyService->getCompanyById($company_shadow->company_id);
            $company_old = $company->toArray();
        }

        $company->name = $company_shadow->name;

        //controle of company_shadow een array is
        if (is_array($company_shadow->website)) {
            if (count($company_shadow->website) > 1) {
                $company->website = implode(",", array_filter($company_shadow->website));
            } else {
                $company->website = $company_shadow->website[0];
            }
        } else {
            $company->website = $company_shadow->website;
        }
        $company->video = $company_shadow->video;
        $company->description = $company_shadow->description;
        $company->type_id = $company_shadow->type_id;
        $company->subCategory_id = $company_shadow->subCategory_id;
        $company->city_id = config('siteId');
        $company->is_published = $published;
        $company->is_highlighted = $highlighted;
        $company->logo = $company_shadow->logo;
        $company->address = $company_shadow->address;
        $company->zip_code = $company_shadow->zip_code;
        $company->city = $company_shadow->city;
        $company->telephone = $company_shadow->telephone;
        $company->email = $company_shadow->email;
        $company->slug = null;

        $company->save();

        $category = CompanyCategory::where('id', $company_shadow->subCategory->category_id)->first();
        $company_shadow->subCategory->category_name = $category->name;

        //emailtemplate gegevens ophalen vanuit bevestigingsformulier
        $receiver = $request->receiver;
        $subject = $request->subject;
        $message_top = $request->message_top;
        $message_bottom = $request->message_bottom;
        $slug = $company->slug;
        $siteurl = config('siteUrl');

        //bevestigingsmail versturen
        Mail::to($receiver)
            ->queue(new SendCompanyMutation($company_shadow, $company_old, $message_top, $message_bottom, $subject, $slug, $siteurl));

        //mutatieaanvraag verwijderen
        $company_shadow->delete();

        return redirect()->route('admCompanyMutation');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company_shadow = CompanyShadow::where('id', $id);
        $company_shadow->delete();
        // return redirect()->route('admCompanyMutation')->with('deleted', 'Wijzigingsaanvraag verwijderd.');
    }
}
