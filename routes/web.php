<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainEntryController;
use App\Http\Controllers\JobActivitiesController;
use App\Http\Controllers\ResourceComponentsController;
use App\Http\Controllers\CountriesDetailController;
use App\Http\Controllers\CountriesApproxController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\VertexAIController;
use App\Http\Controllers\DocumentController;
use App\Models\Menus;
use App\Http\Controllers\OpenAIController;
use App\Http\Controllers\GoogleSearchController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/demo', function () {

    return view('demo');
})->name('demo');

//Cron URL
// Route::get('/predictimages', [OpenAIController::class, 'predictimages']);
Route::get('/cron/expire-estimates', 'App\Http\Controllers\CronController@expireEsitmate');
Route::get('/predict', [VertexAIController::class, 'predict']);
Route::get('/predictprice', [VertexAIController::class, 'predictprice']);
Route::get('/predictcode', [VertexAIController::class, 'predictcode']);
Route::get('/predictimages1', [VertexAIController::class, 'predictimages1']);
Route::get('/predictimages', [VertexAIController::class, 'predictimages']);
Route::get('/upload', [DocumentController::class, 'showForm'])->name('upload.form');

Route::get('/search', [GoogleSearchController::class, 'search']);

Route::post('/user/login', 'App\Http\Controllers\Auth\LoginController@postLogin');
Route::post('/user/register', 'App\Http\Controllers\Auth\RegisterController@postRegistration');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::post('/uploadpdf', [DocumentController::class, 'uploadPDF'])->name('upload.pdf');

    Route::get('/dashboard', 'App\Http\Controllers\HomeController@dashboard')->name('dashboard');
    ///--- Country ---///
    Route::group(['prefix' => 'country'], function () {
        Route::resource('detail_estimate', CountriesDetailController::class);
        Route::resource('approx_estimate', CountriesApproxController::class);
    });
    Route::group(['prefix' => 'main_entry'], function () {
        Route::get('/add-menu', function () {
            return view('main_entry.add-menu');
        })->name('add-menu');
        Route::post('save-menu', 'App\Http\Controllers\MainEntryController@saveMenu')->name('save-menu');
        Route::get('remove/{id}', 'App\Http\Controllers\MainEntryController@removeMenu')->name('remove');
        Route::get('getsoilcondition/{soil_condition}', 'App\Http\Controllers\MainEntryController@getSoilCondition');
        // Route::resource('low_concrete', MainEntryController::class);
        // Route::resource('high_concrete', MainEntryController::class);
        // Route::resource('low_commercial', MainEntryController::class);
        // Route::resource('high_commercial', MainEntryController::class);
        $menus = Menus::all();
        foreach ($menus as $menu) {
            Route::resource($menu->url, MainEntryController::class);
        }
        // Route::resource('ware_house', MainEntryController::class);
        Route::get('/upload-image', 'App\Http\Controllers\MainEntryController@viewUploadImage')->name('main_entry.uploadImage');
        Route::post('/upload-image', 'App\Http\Controllers\MainEntryController@uploadImage')->name('main_entry.uploadImage.post');
        Route::get('/update-rock', 'App\Http\Controllers\MainEntryController@viewRock')->name('main_entry.viewRock');
        Route::post('/update-rock/{rock}', 'App\Http\Controllers\MainEntryController@updateRock')->name('main_entry.updateRock.post');
        Route::get('/update-soil-conditions', 'App\Http\Controllers\MainEntryController@viewSoilConditions')->name('main_entry.viewSoilConditions');
        Route::post('/update-soil-conditions/{id}', 'App\Http\Controllers\MainEntryController@updateSoilConditions')->name('main_entry.updateSoilConditions.post');
    });

    Route::group(['prefix' => 'cost-estimate'], function () {
        Route::get('/cost-form', 'App\Http\Controllers\CostEstimateFormController@index')->name('cost-estimate.form');
        Route::get('/cost-form/restore/{id}', 'App\Http\Controllers\CostEstimateFormController@restoreForm')->name('cost-estimate.restore_form');
        Route::get('/cost-form/list', 'App\Http\Controllers\CostEstimateFormController@formList')->name('approx_form_list');
        Route::get('/cost-form/getFormDetail', 'App\Http\Controllers\CostEstimateFormController@getFormDetail');
        Route::get('/cost-form/getResults', 'App\Http\Controllers\CostEstimateFormController@getResults');
        Route::get('/cost-form/printPDF', 'App\Http\Controllers\CostEstimateFormController@printPDF');
        Route::post('/cost-form/savePDF', 'App\Http\Controllers\CostEstimateFormController@savePDF');
        Route::post('/cost-form/saveForm', 'App\Http\Controllers\CostEstimateFormController@saveForm');
        Route::get('/cost-form/destroy/{id}', 'App\Http\Controllers\CostEstimateFormController@destroy')->name('cost-estimate.destroy');
        Route::get('/cost-form/getEstimateType', 'App\Http\Controllers\CostEstimateFormController@getEstimateType');
        Route::get('/cost-form/getCountry', 'App\Http\Controllers\CostEstimateFormController@getCountry');

        Route::post('/store-activities', 'App\Http\Controllers\DetailEstimateFormController@storeActivities');
        Route::get('/fetch-data', 'App\Http\Controllers\DetailEstimateFormController@fetchData');
        Route::get('/detail-form', 'App\Http\Controllers\DetailEstimateFormController@index')->name('detail-estimate.form');
        Route::get('/detail-form/getResults', 'App\Http\Controllers\DetailEstimateFormController@getResults');
        Route::get('/detail-form/getUnit', 'App\Http\Controllers\DetailEstimateFormController@getUnit');
        Route::get('/detail-form/getInfo/{type}', 'App\Http\Controllers\DetailEstimateFormController@getInfo');
        Route::get('/detail-form/printPDF', 'App\Http\Controllers\DetailEstimateFormController@printPDF');
        Route::post('/detail-form/savePDF', 'App\Http\Controllers\DetailEstimateFormController@savePDF');
        Route::get('/detail-lists', 'App\Http\Controllers\DetailEstimateFormController@lists');
        Route::post('/detail-form/saveForm', 'App\Http\Controllers\DetailEstimateFormController@saveForm');
        Route::get('/detail-form/list', 'App\Http\Controllers\DetailEstimateFormController@formList')->name('detail_form_list');
        Route::get('/detail-form/restore/{id}', 'App\Http\Controllers\DetailEstimateFormController@restoreForm')->name('detail-estimate.restore_form');
        Route::get('/detail-form/getFormDetail', 'App\Http\Controllers\DetailEstimateFormController@getFormDetail');
        Route::get('/detail-form/destroy/{id}', 'App\Http\Controllers\DetailEstimateFormController@destroy')->name('detail-estimate.destroy');

        Route::get('/detail-form-component/{component}/{country}', 'App\Http\Controllers\DetailEstimateFormController@detailsGet');
        Route::get('/detail-form/getCountry', 'App\Http\Controllers\DetailEstimateFormController@getCountry');
        Route::get('/detail-form/getcomponents', 'App\Http\Controllers\DetailEstimateFormController@getComponents');
        Route::get('/detail-form/activity', 'App\Http\Controllers\DetailEstimateFormController@activity');
    });

    Route::get('settings', 'App\Http\Controllers\SettingsController@settings')->name('settings');
    Route::post('settings', 'App\Http\Controllers\SettingsController@settingUpdate')->name('settings.update');


    Route::get('job_activities/getcomponents/{country}', 'App\Http\Controllers\JobActivitiesController@getComponents')->name('get-component');
    Route::get('job_activities/delete/{id}', 'App\Http\Controllers\JobActivitiesController@destroy')->name('job-activity.destroy');
    Route::post('job_activities/updateorder', 'App\Http\Controllers\JobActivitiesController@updateOrder')->name('job-activity.updateorder');
    Route::post('job_activities/updateordernext/{page}', 'App\Http\Controllers\JobActivitiesController@updateOrderNext')->name('job_activities.updateordernext');
    Route::post('job_activities/updateorderprv/{page}', 'App\Http\Controllers\JobActivitiesController@updateOrderPrv')->name('job_activities.updateorderprv');
    Route::post('job_activities/store', 'App\Http\Controllers\JobActivitiesController@store')->name('job_activities.store');
    Route::get('job_activities/global', 'App\Http\Controllers\JobActivitiesController@global')->name('job_activities.global');
    Route::post('job_activities/updateglobal', 'App\Http\Controllers\JobActivitiesController@globalUpdate')->name('job_activities.updateglobal');

    Route::get('resource_components/global', 'App\Http\Controllers\ResourceComponentsController@global')->name('resource_components.global');
    Route::post('resource_components/updateglobal', 'App\Http\Controllers\ResourceComponentsController@globalUpdate')->name('resource_components.updateglobal');

    Route::resource('job_activities', JobActivitiesController::class);
    Route::resource('resource_components', ResourceComponentsController::class);
    Route::get('/resource_components/country/{id}', 'App\Http\Controllers\ResourceComponentsController@getCountryRecordes')->name('resource_components.country');
    Route::get('/country_details/{id}', 'App\Http\Controllers\CountriesDetailController@countryDetails');
    Route::resource('categories', CategoriesController::class);
    Route::post('categories/updateorder', 'App\Http\Controllers\CategoriesController@updateOrder')->name('categories.updateorder');
    Route::get('categories/updateordernext/{page}', 'App\Http\Controllers\CategoriesController@updateOrderNext')->name('categories.updateordernext');
    Route::get('categories/updateorderprv/{page}', 'App\Http\Controllers\CategoriesController@updateOrderPrv')->name('categories.updateorderprv');

    Route::get('/categories/delete/{id}', 'App\Http\Controllers\CategoriesController@destroy')->name('categories.destroy');
    Route::get('/resource_components/{id}/copy', 'App\Http\Controllers\ResourceComponentsController@getCopyComponent')->name('resource_components.copy');
    Route::post('/resource_components/copydata', 'App\Http\Controllers\ResourceComponentsController@saveCopyComponentData')->name('resource_components.copydata');
    Route::post('/resource_components/update_component_ids', 'App\Http\Controllers\ResourceComponentsController@updateComponentIds')->name('resource_components.updateComponentIds');
    Route::get('/resource_components/delete/{id}', 'App\Http\Controllers\ResourceComponentsController@destroy')->name('resource_components.destroy');
    Route::get('/job_activities/{id}/copy', 'App\Http\Controllers\JobActivitiesController@getCopyActivities')->name('job_activities.copy');
    Route::post('/job_activities/copydata', 'App\Http\Controllers\JobActivitiesController@saveCopyActivitiesData')->name('job_activities.copydata');
    Route::post('/job_activities/update_activity_codes', 'App\Http\Controllers\JobActivitiesController@updateActivityCode')->name('job_activities.updateActivityCode');
    Route::post('/job_activities', 'App\Http\Controllers\JobActivitiesController@index')->name('job_activities.activity_search');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
