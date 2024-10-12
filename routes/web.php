<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('customer-area-login', function () {
    $contact = \App\Models\Contact::first();
    auth()->guard('contact')->login($contact);

    return redirect()->route('filament.contact.tenant', ['tenant' => $contact]);
})->name('customer-area-login');
