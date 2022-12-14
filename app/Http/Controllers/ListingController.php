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

        $formField['user_id'] = auth()->id();

        Listing::create($formField);

        // Session::flash('message', 'Listing created successfully');

        return redirect('/')->with('message', 'Listing created successfully');
    }

    // Show edit form
    public function edit(Listing $listing)
    {
        return view('listings.edit', ['listing' => $listing]);
    }

    // Update listing Data
    public function update(Request $request, Listing $listing)
    {
        // Make sure logged in user is ownser
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $formField = $request->validate([
            'tags' => 'required',
            'title' => 'required',
            'website' => 'required',
            'location' => 'required',
            'description' => 'required',
            'email' => ['required', 'email'],
            'company' => ['required'],
        ]);

        if ($request->hasFile('logo')) {
            $formField['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formField);

        return back()->with('message', 'Listing updated successfully');
    }

    // Delete listing
    public function destroy(Listing $listing)
    {
        // Make sure logged in user is ownser
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted successfully');
    }

    // Manage Listings
    public function manage()
    {
        return view('listings.manage', [
            'listings' => auth()->user()->listings()->get()
        ]);
    }
}
