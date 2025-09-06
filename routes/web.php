<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'static_pages.home')->name('root');

Route::prefix('/static_pages')->group(function () {
    Route::view('/home', 'static_pages.home')->name('home');
    Route::view('/help', 'static_pages.help')->name('help');
    Route::view('/about', 'static_pages.about')->name('about');
    Route::view('/contact', 'static_pages.contact')->name('contact');
});
