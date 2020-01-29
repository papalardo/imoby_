<?php

namespace App\Http\Controllers;

use App\Contact;
use Inertia\Inertia;
use App\Models\Tenant;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class TenantsController extends Controller
{
    public function index()
    {
        return Inertia::render('Tenants/Index', [
            'filters' => Request::all('search', 'trashed'),
            'tenants' => Tenant::filter(Request::only('search', 'trashed'))->paginate()
        ]);
    }

    public function create()
    {
        return Inertia::render('Tenants/Create');
    }

    public function store()
    {
        Tenant::create(
            Request::validate([
                'first_name' => ['required', 'max:50'],
                'last_name' => ['required', 'max:50'],
                'cpf' => ['required', 'max:50'],
                // 'cpf' => ['nullable', Rule::exists('organizations', 'id')->where(function ($query) {
                //     $query->where('account_id', Auth::user()->account_id);
                // })],
                'rg' => ['nullable', 'max:50'],
                'rg_agency_emissor' => ['nullable', 'max:50'],
                'rg_agency_state' => ['nullable', 'max:150'],
            ])
        );

        return Redirect::route('tenants')->with('success', 'Contact created.');
    }

    public function edit(Tenant $tenant)
    {
        return Inertia::render('Tenants/Edit', [
            'tenant' => $tenant->toArray(),
        ]);
    }

    public function update(Request $request, Tenant $tenant)
    {
        $tenant->update(
            Request::validate([
                'first_name' => ['required', 'max:50'],
                'last_name' => ['required', 'max:50'],
                'cpf' => ['required', 'max:50'],
                'rg' => ['required', 'max:50'],
                'rg_agency_emissor' => ['required', 'max:50'],
                'rg_agency_state' => ['required', 'max:150'],
            ])
        );

        return Redirect::back()->with('success', 'Contact updated.');
    }

    public function destroy(Tenant $tenant)
    {
        $tenant->delete();

        return Redirect::back()->with('success', 'Inquilino deletado.');
    }

    public function restore(Tenant $tenant)
    {
        $tenant->restore();

        return Redirect::back()->with('success', 'Inquilino restaurado.');
    }
}
