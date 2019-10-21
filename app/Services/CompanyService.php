<?php

namespace App\Services;

use App\Model\Company;
use App\Model\CompanyShadow;
use App\Model\CompanyType;
use App\Model\CompanyCategory;
use App\Model\CompanySubCategory;
use Illuminate\Http\Request;

class CompanyService implements iCompanyService
{
    public function store(Request $request)
    {
        // ingevoerde data ophalen en in array plaatsen
        $companyItem = new Company();
        $companyItem->name = $request->name;
        $companyItem->website = implode(",", array_filter($request->website));
        $companyItem->video = $request->video;
        $companyItem->description = $request->description;
        $companyItem->type_id = $request->companyType;
        $companyItem->subCategory_id = $request->subCategory;
        $companyItem->city_id = config('siteId');
        $companyItem->is_published = $request->published;
        $companyItem->is_highlighted = $request->highlight;
        $companyItem->logo = $request->imageUpload;

        $companyItem->address = $request->address;
        $companyItem->zip_code = $request->zip_code;
        $companyItem->city = $request->city;
        $companyItem->telephone = $request->telephone;
        $companyItem->email = $request->email;

        // Gegevens opslaan in database
        $companyItem->save();
    }

    public function storeComment(Request $request, $companyComment)
    {
        // Ingevoerde data in array plaatsen
        $companyComment->name = $request->name;
        $companyComment->title = $request->title;
        $companyComment->body = $request->body;
        $companyComment->rating = $request->rating;
        $companyComment->company_id = $request->id;
        $companyComment->save();
    }

    public function update(Request $request, $companyItem)
    {
        $companyItem->name = $request->name;
        $companyItem->website = implode(",", array_filter($request->website));
        $companyItem->video = $request->video;
        $companyItem->description = $request->description;
        $companyItem->type_id = $request->companyType;
        $companyItem->subCategory_id = $request->subCategory;
        $companyItem->city_id = config('siteId');
        $companyItem->is_published = $request->published;
        $companyItem->is_highlighted = $request->highlight;
        $companyItem->logo = $request->imageUpload;

        $companyItem->address = $request->address;
        $companyItem->zip_code = $request->zip_code;
        $companyItem->city = $request->city;
        $companyItem->telephone = $request->telephone;
        $companyItem->email = $request->email;

        $companyItem->slug = null;
        $companyItem->save();
        $companyItem->website = explode(',', $companyItem->website);
        $companyItem->load('subCategory');
    }

    public function getCompanyCity()
    {
        return Company::where('is_published', 1)
            //->whereIn('city_id', config('cityGroupCityIds'))
            ->orderBy('name')
            ->get();
    }

    public function getCompanyAll()
    {
        return Company::where('is_published', 1)
            ->orderBy('name')
            ->get();
    }

    public function getCompanyBySlug($slug)
    {
        return Company::where('is_published', 1)
            ->where('slug', $slug)
            ->first();
    }

    public function getCompanyById($id)
    {
        return Company::where('id', $id)
            ->first();
    }

    /**
     * get the type of a company
     *
     * @param  int $id - the id of the companytype
     *
     * @return CompanyType
     */
    public function getCompanyTypeById($id)
    {
        return CompanyType::where('id', $id)
            ->first();
    }

    public function getCompanyADMOverview()
    {
        return Company::whereIn('city_id', config('cityGroupCityIds'))
            ->get();
    }

    public function getCompanyMutationOverview()
    {
        return CompanyShadow::whereIn('city_id', config('cityGroupCityIds'))
            ->get();
    }

    /**
     * get all company types
     *
     * @return CompanyType
     */
    public function getCompanyTypes()
    {
        return CompanyType::all();
    }

    /**
     * get all company categories
     *
     * @return CompanyCategory
     */
    public function getCompanyCategory()
    {
        return CompanyCategory::all();
    }

    public function getCompanyCategoryById($id)
    {
        return CompanyCategory::where('id', $id)
            ->first();
    }

    public function getCompanySubCategoryById($id)
    {
        return CompanySubCategory::where('id', $id)
            ->first();
    }
}
