<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Contact;
use App\Models\Organization;
use App\Models\User;
use App\Models\Package;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $package = Package::find(1)->id;

        User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'package_id' => $package,
            'owner' => true,
        ]);

        User::factory(5)->create(['package_id' => $package]);

        // $organizations = Organization::factory(100)
        //     ->create(['account_id' => $account->id]);

        // Contact::factory(100)
        //     ->create(['account_id' => $account->id])
        //     ->each(function ($contact) use ($organizations) {
        //         $contact->update(['organization_id' => $organizations->random()->id]);
        //     });
    }
}
