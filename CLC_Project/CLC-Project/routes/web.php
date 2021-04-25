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
    return 'Hello world!';
});
    
Route::get('/test', 'TestController@test2');

Route::get('/model', 'TestController@testingModel');

Route::get('/admin', 'AdminController@index');

Route::post('/users', 'TestController@getData');

Route::post('/accountRegistration', 'RegistrationController@userRegistration');

Route::post('/loginProcess', 'LoginController@findUser');

Route::get('/login', function(){
   return view('login'); 
});

Route::get('/register', function(){
   return view('users'); 
});

Route::get('/home', function()->name('home'){
    return view('home');    
});

Route::get('/profile', 'ProfileController@index');

Route::get('/adminPage', 'AdminController@index');

Route::get('/updateProfile', function(){
   return view('testProfileTable'); 
});

//Route displaying updated user list after a user is deleted by admin//

Route::get('/admin', 'AdminController@index')->name('admin.index');
Route::delete('/user/{id}', 'AdminController@deleteUser')
    ->name('admin.deleteUser');
