<?php

use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [NewsController::class, 'index'])->name('news.index');
Route::get('/redirect/{encodedId}', [NewsController::class, 'redirect'])->name('news.redirect');
Route::get('/api/news/hour', [NewsController::class, 'getNewsByHour'])->name('api.news.hour');
