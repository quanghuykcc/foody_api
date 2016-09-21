<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where all API routes are defined.
|
*/



Route::resource('restaurants', 'RestaurantAPIController');



Route::resource('comments', 'CommentAPIController');

Route::resource('categories', 'CategoryAPIController');

Route::controller('authenticate', 'AuthenticateAPIController');





Route::resource('favoriteRestaurants', 'FavoriteRestaurantAPIController');



Route::resource('foods', 'FoodAPIController');