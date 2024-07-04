<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/profile', function () {
    return view('profile');
});


// demo group middleware
Route::get('group_middleware', function () {
    return 'inside group middleware';
})->middleware('ok-user');


// demo Gate 
Route::get('/gateCheck', function () {
    return 'inside laravel gate';
})->middleware('can:isAdmin');


/*
Inside gate file

@if(Gate::allows('isAdmin'))

<a href="/admin-panel"> Admin Panel </a>

@endif


@can('isAdmin')

<a href="/admin-panel"> Admin Panel </a>

@endCan


@if(Gate::denies('isAdmin'))

<a href="/guest-page"> Guest Page </a>

@endif


@cannot('isAdmin')

<a href="/guest-page"> Guest Page </a>

@endcan
*/