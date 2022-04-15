<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GetController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\JobpostController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout']);
Route::post('update-profile', [UserController::class, 'updateprofile']);
Route::post('forget-password', [UserController::class, 'forget_password']);
Route::post('change-password', [UserController::class, 'changepassword']);
Route::post('get-user-details', [UserController::class, 'GetUserDetils']);
Route::post('reset-password', [UserController::class, 'resetpassword']);
Route::post('verify-otp', [UserController::class, 'verifyOtp']);
Route::post('my-eduction', [UserController::class, 'myeduction']);
Route::post('id-proof-upload', [UserController::class, 'idProofUpload']);
Route::post('social-login', [UserController::class, 'sociallogin']);
Route::post('select-preference', [UserController::class, 'selectpreference']);
Route::post('add-experience', [UserController::class, 'addExperience']);
Route::post('list-preference', [GetController::class, 'ListPreference']);
Route::post('list-skills', [GetController::class, 'ListSkills']);
Route::post('list-eduction', [GetController::class, 'ListEduction']);
Route::post('list-subscription', [GetController::class, 'ListSubscription']);
Route::post('register-employee', [EmployeeController::class, 'register']);
Route::post('login-employee', [EmployeeController::class, 'login']);
Route::post('logout-employee', [EmployeeController::class, 'logout']);
Route::post('update-profile-employee', [EmployeeController::class, 'updateprofile']);
Route::post('forget-password-employee', [EmployeeController::class, 'forget_password']);
Route::post('change-password-employee', [EmployeeController::class, 'changepassword']);
Route::post('get-user-details-employee', [EmployeeController::class, 'GetUserDetils']);
Route::post('reset-password-employee', [EmployeeController::class, 'resetpassword']);
Route::post('verify-otp-employee', [EmployeeController::class, 'verifyOtp']);
Route::post('social-login-employee', [EmployeeController::class, 'sociallogin']);
Route::post('add-update-card', [EmployeeController::class, 'AddUpdateCrad']);
Route::post('delete-card', [EmployeeController::class, 'DeleteCard']);
Route::post('list-company', [EmployeeController::class, 'ListCompany']);
Route::post('get-company-byid', [EmployeeController::class, 'GetCompanyByid']);
Route::post('add-job-post', [JobpostController::class, 'AddPost']);
Route::post('list-post', [JobpostController::class, 'ListPost']);
Route::post('user-list-post', [JobpostController::class, 'UserListPost']);
Route::post('delete-post', [JobpostController::class, 'DeletePost']);
Route::post('update-job-post', [JobpostController::class, 'EditPost']);
Route::post('send-request', [JobpostController::class, 'sendRequest']);
Route::post('request-list', [JobpostController::class, 'requestList']);
Route::post('accept-reject-post-request', [JobpostController::class, 'AcceptRejectPostRequest']);
Route::post('complate-post', [JobpostController::class, 'CompaltePost']);
Route::post('accept-finish-postlist', [JobpostController::class, 'AcceptFinishPostlist']);
Route::post('list-post-for-apply', [JobpostController::class, 'listPostForApply']);
Route::post('search-and-filter-post', [JobpostController::class, 'SearchAndFilterPost']);
Route::post('search-and-filter-post-employee', [JobpostController::class, 'SearchAndFilterPostemployee']);
Route::post('add-rating', [JobpostController::class, 'AddRating']);
Route::post('job-details', [JobpostController::class, 'JobDetails']);
Route::post('add-delete-favorite', [JobpostController::class, 'AddDeleteFavorite']);
Route::post('get-favorite-list', [JobpostController::class, 'getFavoritelist']);
