<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', 'CompanyController@index')->name('Home');

Route::get('/', function () {
    return view('home');
});

Route::get('/bedrijvengids', 'CompanyController@index');

Route::resource('bedrijvengids', 'CompanyController', [
    'only' => ['show', 'index'],
    'names' => ['index' => 'bedrijvengidsindex', 'show' => 'bedrijvengidsshow']
]);

Route::resource('adm/bedrijfsmutaties', 'CompanyShadowController', ['only' => ['store']]);

Route::resource('adm/bedrijfsmutaties', 'CompanyShadowController', ['except' => ['show', 'index', 'store']]);

Route::post('/bedrijvengids/plaatsreactie/{id}', 'CompanyController@storeComment');

//Route::resource('adm/bedrijfsmutaties', 'CompanyShadowController', ['only' => ['store']]);

Route::post('adm/bedrijfsmutaties/{id}/confirmChanges', 'CompanyShadowController@confirmChanges')
    ->name('confirmChanges');

Route::resource('adm/bedrijvengids', 'CompanyController', ['except' => ['show', 'index']]);
    
Route::resource('adm/bedrijfsmutaties', 'CompanyShadowController', ['except' => ['show', 'index', 'store']]);

Route::get('adm/bedrijvengids', 'AdmController@getCompanyOverview')
    ->name('admCompany');

Route::resource('adm/bedrijfstypes', 'CompanyTypeController', ['except' => ['show', 'index']]);

Route::get('adm/bedrijfstypes', 'AdmController@getCompanyTypeOverview')
    ->name('admCompanyType');

Route::get('adm/bedrijvengids/aanpassingen', 'AdmController@mutationOverview')
    ->name('admCompanyMutation');

Route::resource('adm/bedrijvengids/categorie', 'CompanyCategoryController');

Route::get('adm/bedrijvengids/categorie', 'CompanyCategoryController@index')
    ->name('admCompanyCategory');

Route::resource('adm/bedrijvengids/subcategorie', 'CompanySubCategoryController');

Route::get('adm/bedrijvengids/subcategorie', 'CompanySubCategoryController@index')
    ->name('admCompanySubCategory');

Route::get('adm/bedrijvengids/published/{id}', 'CompanyController@setPublished');

//JSON Server-side-processing
Route::post('/adm/companyJson', 'JsonController@JsonCompany');
Route::post('/adm/companyMutationJson', 'JsonController@JsonCompanyMutation');
Route::post('/adm/companyTypeJson', 'JsonController@JsonCompanyType');
Route::post('/adm/companyCategoryJson', 'JsonController@JsonCompanyCategory');
Route::post('/adm/companySubCategoryJson', 'JsonController@JsonCompanySubCategory');