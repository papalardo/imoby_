<?php

use App\User;
use App\Account;
use App\Contact;
use App\Organization;
use App\Models\PropertyOwner;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $account = Account::create(['name' => 'Acme Corporation']);

        factory(User::class)->create([
            'account_id' => $account->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'owner' => true,
        ]);

        $property = PropertyOwner::create([
            'first_name' => 'Adriana',
            'last_name' => 'Soares Sousa Ferreira',
            'cpf' => '60684690187',
            'rg' => '',
            'rg_agency_emissor' => '',
            'rg_agency_state' => '',
        ]);

        $property->properties()->create([ 'address' => 'Rua Piauí, Lote 15, AP 102', 'ceb_code' => '' ]);
        $property->properties()->create([ 'address' => 'Rua Piauí, Lote 15, AP 103', 'ceb_code' => '' ]);
        $property->properties()->create([ 'address' => 'Rua Piauí, Lote 15, AP 104', 'ceb_code' => '' ]);
        $property->properties()->create([ 'address' => 'Rua Piauí, Lote 15, AP 202', 'ceb_code' => '' ]);
        $property->properties()->create([ 'address' => 'Rua Piauí, Lote 15, AP 203', 'ceb_code' => '' ]);
        $property->properties()->create([ 'address' => 'Rua Piauí, Lote 15, AP 204', 'ceb_code' => '' ]);
        $property->properties()->create([ 'address' => 'Rua Piauí, Lote 15, AP 205', 'ceb_code' => '' ]);
        $property->properties()->create([ 'address' => 'Rua Piauí, Lote 15, AP 206', 'ceb_code' => '' ]);
        
        Tenant::create([
            'first_name' => 'Marcio',
            'last_name' => 'de arruda',
            'cpf' => '',
            'rg' => '',
            'rg_agency_emissor' => '',
            'rg_agency_state' => '',
        ]);

        // factory(User::class, 5)->create(['account_id' => $account->id]);

        // $organizations = factory(Organization::class, 100)
        //     ->create(['account_id' => $account->id]);

        // factory(Contact::class, 100)
        //     ->create(['account_id' => $account->id])
        //     ->each(function ($contact) use ($organizations) {
        //         $contact->update(['organization_id' => $organizations->random()->id]);
        //     });
    }
}
