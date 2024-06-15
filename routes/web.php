<?php
use App\Http\Controllers\RSSFeedController;
use Illuminate\Support\Facades\Route;



Route::get('/', [RSSFeedController::class, 'index']);
