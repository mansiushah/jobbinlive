<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\IntrestsController;
use App\Http\Controllers\Admin\PreferenceController;
use App\Http\Controllers\Admin\SkillsController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\SubscribctionController;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//admin route
Route::get('admin/login',[AdminAuthController::class,'getLogin'])->name('adminLogin');
Route::post('admin/login', [AdminAuthController::class,'postLogin'])->name('adminLoginPost');
Route::get('admin/logout', [AdminAuthController::class,'logout'])->name('adminLogout');

Route::group(['prefix' => 'admin','middleware' => 'adminauth'], function () {
   // Admin Dashboard
   Route::get('dashboard',[AdminController::class,'dashboard'])->name('dashboard'); 
   Route::match(['GET', 'POST'],'/',[UsersController::class,'profile'])->name('admin.profile');
   Route::get('changepassword',[UsersController::class,'ChangePassword'])->name('admin.editchangepassword');
   Route::get('user',[UsersController::class,'UserList'])->name('admin.user');
   Route::get('/userviews/{id}',[UsersController::class,'Userview'])->name('admin.userviews');
   Route::resource('intrest', IntrestsController::class);
   Route::resource('skills', SkillsController::class);
   Route::resource('preference', PreferenceController::class);
   Route::resource('education', EducationController::class);
   Route::resource('subscription', EducationController::class);

});
