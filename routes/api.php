<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['api', 'cors']], function () {
    Route::get('budget/list/{email?}', 'BudgetController@show')->name('budget.list');
    Route::post('budget/create', 'BudgetController@create')->name('budget.create');
    Route::put('budget/edit/{id}', 'BudgetController@edit')->name('budget.edit');
    Route::post('budget/publish/{id}', 'BudgetController@publish')->name('budget.publish');
    Route::post('budget/discard/{id}', 'BudgetController@discard')->name('budget.discard');
    Route::get('budget/suggest/{id}', 'BudgetController@suggest')->name('budget.suggest');

    Route::get('category/list', 'CategoryController@show')->name('category.list');
    Route::get('category/find/{id}', 'CategoryController@find')->name('category.find');
});

Route::fallback(
    function () {
        return response()->json(['message' => 'Not Found'], 404);
    }
);
