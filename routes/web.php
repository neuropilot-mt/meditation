<?php

use Illuminate\Support\Facades\Route;

Route::get('/{locale?}', function (?string $locale = null) {
    if ($locale !== null && in_array($locale, ['en', 'ru'], true)) {
        app()->setLocale($locale);
        session(['locale' => $locale]);
    } elseif (session('locale') !== null) {
        app()->setLocale(session('locale'));
    }

    return view('welcome');
})->where('locale', 'en|ru')->name('welcome');
