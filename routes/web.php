<?php
use App\Http\Controllers\RSSFeedController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/rss-feed', [RSSFeedController::class, 'index']);
