<?php

namespace App\Http\Controllers;

use App\Contact;
use Inertia\Inertia;
use App\Models\Tenant;
use App\Models\Property;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class PropertiesController extends Controller
{
    public function index()
    {
        return Inertia::render('Properties/Index', [
            'filters' => Request::all('search', 'trashed'),
            'properties' => Property::filter(Request::only('search', 'trashed'))->paginate()
        ]);
    }

    public function create()
    {
        return Inertia::render('Properties/Create');
    }

    public function store()
    {
        Property::create(
            Request::validate([
                'address' => ['required', 'max:50'],
                'ceb_code' => ['required', 'max:50'],
            ])
        );

        return Redirect::route('properties')->with('success', 'Contact created.');
    }

    public function edit(Property $property)
    {
        return Inertia::render('Properties/Edit', [
            'property' => $property->toArray(),
        ]);
    }

    public function update(Request $request, Property $property)
    {
        $property->update(
            Request::validate([
                'address' => ['required', 'max:50'],
                'ceb_code' => ['required', 'max:50'],
            ])
        );

        return Redirect::back()->with('success', 'Contact updated.');
    }

    public function destroy(Property $property)
    {
        $property->delete();

        return Redirect::back()->with('success', 'Contact deleted.');
    }

    public function restore(Property $property)
    {
        $property->restore();

        return Redirect::back()->with('success', 'Contact restored.');
    }
}
