<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\MenuItemImageController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::apiResources([
    'categories' => CategoryController::class,
    'menus' => MenuController::class,
    'menu_items' => MenuItemController::class,
    'menu_item_images' => MenuItemImageController::class,
]);

Route::group(['middleware' => ['api']], function(){
    Route::get('/categories/sort/{field}/{order}', 'App\Http\Controllers\CategoryController@sort');
    Route::get('/menus/sort/{field}/{order}', 'App\Http\Controllers\MenuController@sort');
    Route::get('/menu_items/sort/{field}/{order}', 'App\Http\Controllers\MenuItemController@sort');
});