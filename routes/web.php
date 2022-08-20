<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;

// All listings
Route::get('/', [ListingController::class, 'index']);

// Single listing
Route::get("/listings/{listing}", [ListingController::class, 'show']);


// Notes
/*
Route::get("/hello", function () {
    return response("<h1>Hello Guys</h1>", 200)
        ->header("Content-Type", "text/plain");
});

Route::get("/posts/{id}", function ($id) {
    return response("Posts " . $id);
})
    ->where("id", "[0-9]+")
    ->name("getPosts");


Route::get("/search", function (Request $request) {
    return $request->name . " " . $request->city;
});
*/