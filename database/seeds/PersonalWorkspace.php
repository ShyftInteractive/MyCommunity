<?php

namespace Database\Seeders;

use App\Enums\MemberRoles;
use Illuminate\Support\Arr;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use App\Domain\Facades\MemberRepository;
use App\Domain\Facades\CustomerRepository;
use App\Domain\Facades\WorkspaceRepository;

class PersonalWorkspace extends Seeder
{
    const MEMBERS_PER_WORKSPACE = 10;
    const PERSONAL_NAME = 'Joe Cianflone';
    const PERSONAL_EMAIL = 'joe@cianflone.co';
    const PERSONAL_PASSWORD = 'password123';
    const PERSONAL_SLUG = 'joecianflone';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = new Faker();
        $faker->addProvider(new \Faker\Provider\en_US\Person($faker));
        $faker->addProvider(new \Faker\Provider\en_US\Address($faker));
        $faker->addProvider(new \Faker\Provider\en_US\PhoneNumber($faker));
        $faker->addProvider(new \Faker\Provider\en_US\Company($faker));
        $faker->addProvider(new \Faker\Provider\Lorem($faker));
        $faker->addProvider(new \Faker\Provider\Internet($faker));

        $customer = CustomerRepository::create([
            'name' => 'Personal Test Company',
            'line1' => $faker->streetAddress,
            'city' => $faker->city,
            'state' => $faker->stateAbbr,
            'postal_code' => $faker->postcode,
            'country' => $faker->country,
            'agreed_to_terms' => true,
            'agreed_to_privacy' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Artisan::call('db:migrate '.$customer->id);

        $workspace = WorkspaceRepository::create([
            'customer_id' => $customer->id,
            'name' => 'Personal Test Workspace',
            'slug' => self::PERSONAL_SLUG,
        ]);

        $member = MemberRepository::create([
            'name' => self::PERSONAL_NAME,
            'email' => self::PERSONAL_EMAIL,
            'password' => Hash::make(self::PERSONAL_PASSWORD),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        MemberRepository::for($member)->attach('workspaces', $workspace->id, ['role' => MemberRoles::OWNER()]);

        for ($k = 0; $k < self::MEMBERS_PER_WORKSPACE; ++$k) {
            $member = MemberRepository::create([
                'name' => $faker->name,
                'email' => $faker->safeEmail,
                'password' => Hash::make(self::PERSONAL_PASSWORD),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            MemberRepository::for($member)
                ->attach('workspaces', $workspace->id, ['role' => $this->generateRandomRole()]);
        }
    }

    private function generateRandomRole()
    {
        $key = Arr::flatten(MemberRoles::keys())[rand(1, 8)];

        return MemberRoles::$key();
    }
}
