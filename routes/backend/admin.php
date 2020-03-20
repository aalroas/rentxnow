<?php

use App\Http\Controllers\Backend\DashboardController;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

// property
Route::resource('property', 'PropertyController');
// Route::delete('property/image/{id}', 'PropertyController@deleteImage');

// property options
Route::resource('property_type', 'PropertyTypeController');
Route::resource('listing_type', 'ListingTypeController');
Route::resource('rooms_type', 'RoomsTypeController');
