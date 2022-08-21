<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;

// All listings
Route::get('/', [ListingController::class, 'index']);

// Create listings form
Route::get("/listings/create", [ListingController::class, 'create']);

// Store listings
Route::post("/listings", [ListingController::class, 'store'])->name("create_job");

// Single listing
Route::get("/listings/{listing}", [ListingController::class, 'show']);
