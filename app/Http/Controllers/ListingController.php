<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
// use Illuminate\Support\Facades\Session;

class ListingController extends Controller
{
    // Show all listings
    public function index()
    {
        return view('listings.index', [
            "search" => request("search") ?? null,
            "listings" => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
        ]);
    }

    // Show single listing
    public function show(Listing $listing)
    {
        return view("listings.show", [
            "listing" => $listing
        ]);
    }

    // Form to create listings
    public function create()
    {
        return view("listings.create");
    }

    public function store(Request $request)
    {
        $formField = $request->validate([
            'tags' => 'required',
            'title' => 'required',
            'website' => 'required',
            'location' => 'required',
            'description' => 'required',
            'email' => ['required', 'email'],
            'company' => ['required', Rule::unique('listings', 'company')],
        ]);

        if ($request->hasFile('logo')) {
            $formField['logo'] = $request->file('logo')->store('logos', 'public');
        }

        Listing::create($formField);

        // Session::flash('message', 'Listing created successfully');

        return redirect('/')->with('message', 'Listing created successfully');
    }
}
