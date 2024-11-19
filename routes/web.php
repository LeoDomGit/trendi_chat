<?php

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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');
Route::get('/users/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('users.profile');
Route::post('/users/profile/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.profile.update');

Route::get('/categories',[App\Http\Controllers\CategoryController::class,'index'])->name('categories');
Route::get('/categories/create',[App\Http\Controllers\CategoryController::class,'create'])->name('categories.create');
Route::post('/categories/store',[App\Http\Controllers\CategoryController::class,'store'])->name('categories.store');
Route::get('/categories/edit/{id}',[App\Http\Controllers\CategoryController::class,'edit'])->name('categories.edit');
Route::post('/categories/update/{id}',[App\Http\Controllers\CategoryController::class,'update'])->name('categories.update');
Route::get('/categories/delete/{id}',[App\Http\Controllers\CategoryController::class,'delete'])->name('categories.delete');
Route::post('categories/status', [App\Http\Controllers\CategoryController::class, 'status'])->name('categories.status');

Route::get('appusers', [App\Http\Controllers\AppUserController::class, 'index'])->name('appusers');
Route::get('/appusers/edit/{id}',[App\Http\Controllers\AppUserController::class,'edit'])->name('appusers.edit');
Route::post('/appusers/update/{id}',[App\Http\Controllers\AppUserController::class,'update'])->name('appusers.update');
Route::get('/appusers/delete/{id}',[App\Http\Controllers\AppUserController::class,'delete'])->name('appusers.delete');
Route::post('appusers/status', [App\Http\Controllers\AppUserController::class, 'status'])->name('appusers.status');

Route::get('guestusers', [App\Http\Controllers\GuestUserController::class, 'index'])->name('guestusers');
Route::get('/guestusers/delete/{id}',[App\Http\Controllers\GuestUserController::class,'delete'])->name('guestusers.delete');

Route::get('/suggestions',[App\Http\Controllers\SuggestionController::class,'index'])->name('suggestions');
Route::get('/suggestions/create',[App\Http\Controllers\SuggestionController::class,'create'])->name('suggestions.create');
Route::post('/suggestions/store',[App\Http\Controllers\SuggestionController::class,'store'])->name('suggestions.store');
Route::get('/suggestions/edit/{id}',[App\Http\Controllers\SuggestionController::class,'edit'])->name('suggestions.edit');
Route::post('/suggestions/update/{id}',[App\Http\Controllers\SuggestionController::class,'update'])->name('suggestions.update');
Route::get('/suggestions/delete/{id}',[App\Http\Controllers\SuggestionController::class,'delete'])->name('suggestions.delete');
Route::post('suggestions/status', [App\Http\Controllers\SuggestionController::class, 'status'])->name('suggestions.status');

Route::get('/languages',[App\Http\Controllers\LanguageController::class,'index'])->name('languages');
Route::get('/languages/create',[App\Http\Controllers\LanguageController::class,'create'])->name('languages.create');
Route::post('/languages/store',[App\Http\Controllers\LanguageController::class,'store'])->name('languages.store');
Route::get('/languages/edit/{id}',[App\Http\Controllers\LanguageController::class,'edit'])->name('languages.edit');
Route::post('/languages/update/{id}',[App\Http\Controllers\LanguageController::class,'update'])->name('languages.update');
Route::get('/languages/delete/{id}',[App\Http\Controllers\LanguageController::class,'delete'])->name('languages.delete');
Route::post('/languages/status', [App\Http\Controllers\LanguageController::class, 'status'])->name('languages.status');
Route::get('/getlang', [App\Http\Controllers\LanguageController::class, 'getLangauage'])->name('language.header');
Route::get('/changelang', [App\Http\Controllers\LanguageController::class, 'change'])->name('language.change');
Route::post('/getcode/{slugid}', [App\Http\Controllers\LanguageController::class, 'getCode'])->name('language.code');

Route::get('/banners',[App\Http\Controllers\BannerController::class,'index'])->name('banners');
Route::get('/banners/create',[App\Http\Controllers\BannerController::class,'create'])->name('banners.create');
Route::post('/banners/store',[App\Http\Controllers\BannerController::class,'store'])->name('banners.store');
Route::get('/banners/edit/{id}',[App\Http\Controllers\BannerController::class,'edit'])->name('banners.edit');
Route::post('/banners/update/{id}',[App\Http\Controllers\BannerController::class,'update'])->name('banners.update');
Route::get('/banners/delete/{id}',[App\Http\Controllers\BannerController::class,'delete'])->name('banners.delete');
Route::post('banners/status', [App\Http\Controllers\BannerController::class, 'status'])->name('banners.status');

Route::get('/characters',[App\Http\Controllers\CharacterController::class,'index'])->name('characters');
Route::get('/characters/create',[App\Http\Controllers\CharacterController::class,'create'])->name('characters.create');
Route::post('/characters/store',[App\Http\Controllers\CharacterController::class,'store'])->name('characters.store');
Route::get('/characters/edit/{id}',[App\Http\Controllers\CharacterController::class,'edit'])->name('characters.edit');
Route::post('/characters/update/{id}',[App\Http\Controllers\CharacterController::class,'update'])->name('characters.update');
Route::get('/characters/delete/{id}',[App\Http\Controllers\CharacterController::class,'delete'])->name('characters.delete');
Route::post('characters/lock', [App\Http\Controllers\CharacterController::class, 'lock'])->name('characters.lock');

Route::get('/subscriptions',[App\Http\Controllers\SubscriptionController::class,'index'])->name('subscriptions');
Route::get('/subscriptions/create',[App\Http\Controllers\SubscriptionController::class,'create'])->name('subscriptions.create');
Route::post('/subscriptions/store',[App\Http\Controllers\SubscriptionController::class,'store'])->name('subscriptions.store');
Route::get('/subscriptions/edit/{id}',[App\Http\Controllers\SubscriptionController::class,'edit'])->name('subscriptions.edit');
Route::post('/subscriptions/update/{id}',[App\Http\Controllers\SubscriptionController::class,'update'])->name('subscriptions.update');
Route::get('/subscriptions/delete/{id}',[App\Http\Controllers\SubscriptionController::class,'delete'])->name('subscriptions.delete');
Route::post('subscriptions/status', [App\Http\Controllers\SubscriptionController::class, 'status'])->name('subscriptions.status');

Route::get('/settings/general', [App\Http\Controllers\SettingController::class, 'index'])->name('settings.general');
Route::get('/settings/limit', [App\Http\Controllers\SettingController::class, 'limit'])->name('settings.limit');
Route::post('/settings/update/general/{id}', [App\Http\Controllers\SettingController::class, 'generalUpdate'])->name('settings.update.general');
Route::post('/settings/update/limit/{id}', [App\Http\Controllers\SettingController::class, 'limitUpdate'])->name('settings.update.limit');

Route::get('/notification', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications');
Route::get('/notification/create', [App\Http\Controllers\NotificationController::class, 'create'])->name('notifications.create');
Route::post('/notification/send', [App\Http\Controllers\NotificationController::class, 'send'])->name('notifications.send');
Route::get('/notification/delete/{id}',[App\Http\Controllers\NotificationController::class,'delete'])->name('notifications.delete');

Route::get('/landingpage', [App\Http\Controllers\LandingPageController::class, 'index'])->name('landingpage');
Route::post('/landingpage/save', [App\Http\Controllers\LandingPageController::class, 'save'])->name('landingpage.save');