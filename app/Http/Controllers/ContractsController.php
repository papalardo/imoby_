<?php

namespace App\Http\Controllers;

use App\Contact;
use Inertia\Inertia;
use App\Models\Tenant;
use App\Models\Locator;
use App\Models\Contract;
use App\Models\Property;
use App\Models\PropertyOwner;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class ContractsController extends Controller
{
    public function index()
    {
        return Inertia::render('Contracts/Index', [
            'filters' => Request::all('search', 'trashed'),
            'contracts' => Contract::with(['tenant', 'propertyOwner'])->paginate()
                    ->transform(function ($contract) {
                        return [
                            'id' => $contract->id,
                            'tenant' => $contract->tenant->first_name,
                            'propertyOwner' => $contract->propertyOwner->first_name,
                            'property' => $contract->property->address,
                        ];
                    })
        ]);
    }

    public function create()
    {
        return Inertia::render('Contracts/Create', [
            'propertyOwners' => PropertyOwner::orderBy('first_name')->get()->map->only('id', 'first_name'),
            'properties' => Property::orderBy('address')->get()->map->only('id', 'address'),
            'tenants' => Tenant::orderBy('first_name')->get()->map->only('id', 'first_name'),
        ]);
    }

    public function store()
    {
        Contract::create(
            Request::validate([
                'property_id' => ['nullable', Rule::exists('properties', 'id')],
                'property_owner_id' => ['nullable', Rule::exists('property_owners', 'id')],
                'tenant_id' => ['nullable', Rule::exists('tenants', 'id')],
                'date_begin' => ['nullable', 'max:10'],
                'date_end' => ['nullable', 'max:10'],
                'price' => ['numeric'],
            ])
        );

        return Redirect::route('contracts')->with('success', 'Contrato criado com sucesso.');
    }

    public function edit(Contact $contact)
    {
        return Inertia::render('Contracts/Edit', [
            'contact' => [
                'id' => $contact->id,
                'first_name' => $contact->first_name,
                'last_name' => $contact->last_name,
                'organization_id' => $contact->organization_id,
                'email' => $contact->email,
                'phone' => $contact->phone,
                'address' => $contact->address,
                'city' => $contact->city,
                'region' => $contact->region,
                'country' => $contact->country,
                'postal_code' => $contact->postal_code,
                'deleted_at' => $contact->deleted_at,
            ],
            'organizations' => Auth::user()->account->organizations()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
        ]);
    }

    public function update(Contact $contact)
    {
        $contact->update(
            Request::validate([
                'first_name' => ['required', 'max:50'],
                'last_name' => ['required', 'max:50'],
                'organization_id' => ['nullable', Rule::exists('organizations', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'email' => ['nullable', 'max:50', 'email'],
                'phone' => ['nullable', 'max:50'],
                'address' => ['nullable', 'max:150'],
                'city' => ['nullable', 'max:50'],
                'region' => ['nullable', 'max:50'],
                'country' => ['nullable', 'max:2'],
                'postal_code' => ['nullable', 'max:25'],
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
