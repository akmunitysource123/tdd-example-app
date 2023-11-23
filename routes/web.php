<?php

use App\Http\Controllers\WebPostController;
use Illuminate\Support\Facades\Route;

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

# Blog Post Testing
Route::post('/createBlog', [WebPostController::class, 'createBlog']);
Route::get('/getBlogById/{id}', [WebPostController::class, 'getBlogById']);
Route::put('/updateBlog/{id}', [WebPostController::class, 'updateBlog']);
Route::delete('/deleteBlog/{id}', [WebPostController::class, 'deleteBlog']);