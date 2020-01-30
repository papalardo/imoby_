<?php

namespace App\Http\Controllers;

use App\Contact;
use Inertia\Inertia;
use App\Models\Tenant;
use App\Models\Locator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class LocatorsController extends Controller
{
    public function index()
    {
        return Inertia::render('Locators/Index', [
            'filters' => Request::all('search', 'trashed'),
            'locators' => Locator::filter(Request::only('search', 'trashed'))->paginate()
        ]);
    }

    public function create()
    {
        return Inertia::render('Locators/Create');
    }

    public function store()
    {
        Locator::create(
            Request::validate([
                'first_name' => ['required', 'max:50'],
                'last_name' => ['required', 'max:50'],
                'cpf' => ['required', 'max:50'],
                'rg' => ['nullable', 'max:50'],
                'rg_agency_emissor' => ['nullable', 'max:50'],
                'rg_agency_state' => ['nullable', 'max:150'],
            ])
        );

        return Redirect::route('locators')->with('success', 'Contact created.');
    }

    public function edit(Locator $locator)
    {
        return Inertia::render('Locators/Edit', [
            'locator' => $locator->toArray(),
        ]);
    }

    public function update(Locator $locator)
    {
        $locator->update(
            Request::validate([
                'first_name' => ['required', 'max:50'],
                'last_name' => ['required', 'max:50'],
                'cpf' => ['required', 'max:50'],
                'rg' => ['nullable', 'max:50'],
                'rg_agency_emissor' => ['nullable', 'max:50'],
                'rg_agency_state' => ['nullable', 'max:150'],
            ])
        );

        return Redirect::back()->with('success', 'Contact updated.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return Redirect::back()->with('success', 'Contact deleted.');
    }

    public function restore(Contact $contact)
    {
        $contact->restore();

        return Redirect::back()->with('success', 'Contact restored.');
    }
}
