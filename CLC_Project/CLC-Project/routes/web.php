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

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function(){
    return 'Hello world THIS IS A NEW TEST!';
});
    
Route::get('/test', 'TestController@test2');

Route::post('/users', 'TestController@getData');

Route::get('/login', function(){
   return view('users'); 
});