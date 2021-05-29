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

Route::get('jobPost', 'JobController@index');

Route::post('/users', 'TestController@getData');

Route::post('/accountRegistration', 'RegistrationController@userRegistration');

Route::post('/loginProcess', 'LoginController@findUser');

Route::post('/suspend', 'AdminController@suspendUser');

Route::post('/ban', 'AdminController@banUser');

Route::post('/delete', 'AdminController@deleteUser');

Route::post('/editPost', 'JobController@viewPost');

Route::post('/updatePost', 'JobController@updatePost');

Route::post('/deletePost', 'JobController@deletePost');

Route::get('/newPost', function(){
   return view('createPost'); 
});

Route::post('/createPost', 'JobController@createPost');

Route::post('/skills', 'ResumeController@updateSkills');

Route::post('/education', 'ResumeController@updateEducation');

Route::post('/workHistory', 'ResumeController@updateWorkHistory');

Route::get('/viewResume', 'ProfileController@viewResume');

Route::get('/login', function(){
   return view('login'); 
});

Route::get('/register', function(){
    return view('users'); 
});

    Route::get('/home', function(){
       return view('home'); 
    });

// Route::get('/home', function()->name('home'){
//     return view('home');    
// });

Route::get('/profile', 'ProfileController@index');

Route::get('/adminPage', 'AdminController@index');

Route::get('/adminJobs', 'AdminController@viewJobs');

Route::get('/updateProfile', function(){
   return view('testProfileTable'); 
});

Route::post('/updateProcess', 'ProfileController@updateProfile');
//Route displaying updated user list after a user is deleted by admin//

Route::get('/admin', 'AdminController@index')->name('admin.index');
Route::delete('/user/{id}', 'AdminController@deleteUser')
    ->name('admin.deleteUser');

Route::get('/updateResume', function(){
   return view('resume'); 
});

Route::get('/education', 'EducationController@index');

Route::get('/groups', 'GroupController@index');

Route::get('/newGroup', function(){
    return view('createGroup');
});

Route::Post('/createGroup', 'GroupController@createGroup');

Route::Post('/deleteGroup', 'GroupController@deleteGroup');

Route::get('/showGroups', 'GroupController@showGroups');

Route::POST('/editGroup', 'GroupController@editGroup');

Route::POST('/confirmEdit', 'GroupController@confirmEdit');

Route::POST('/viewGroup', 'GroupController@displayGroup');

Route::POST('/joinGroup', 'GroupController@joinGroup');

Route::POST('/removeUser', 'GroupController@removeUser');

Route::POST('/searchProcess', 'SearchController@searchMethod');

Route::POST('/submitApp', 'ApplicationController@jobApplication');

Route::POST('/showJob', 'JobController@viewJobPosting');

Route::resource('/usersrest', 'UserRestController');

Route::resource('/jobsrest', 'JobRestController');

Route::resource('/profilerest', 'ProfileRestController');

Route::get('/testing', function(){
   return view('error'); 
});
