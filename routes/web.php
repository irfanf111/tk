<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\RegistrationForm;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register-student', RegistrationForm::class)->name('register.create');
