<?php

namespace Database\Seeders\Rebase;

use Exception;
use Faker\Provider\Lorem;
use App\Domain\Roles\Role;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Faker\Provider\Internet;
use Faker\Generator as Faker;
use App\Domain\Members\Member;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Faker\Provider\en_US\Person;
use App\Enums\Rebase\MemberRoles;
use Faker\Provider\en_US\Address;
use Faker\Provider\en_US\Company;
use App\Domain\Customers\Customer;
use App\Domain\Workspaces\Workspace;
use Illuminate\Support\Facades\Hash;
use Faker\Provider\en_US\PhoneNumber;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class PersonalWorkspace extends Seeder
{
    public const MEMBERS_PER_WORKSPACE = 100;
    public const WORKSPACES = 2;
    public const PERSONAL_NAME = 'Joe Cianflone';
    public const PERSONAL_EMAIL = 'joe@cianflone.co';
    public const PERSONAL_PASSWORD = 'password123';
    public const PERSONAL_SUB = 'joecianflone';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = new Faker();
        $faker->addProvider(new Person($faker));
        $faker->addProvider(new Address($faker));
        $faker->addProvider(new PhoneNumber($faker));
        $faker->addProvider(new Company($faker));
        $faker->addProvider(new Lorem($faker));
        $faker->addProvider(new Internet($faker));

        $customer = Customer::create([
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

        $code = Artisan::call('migrate:workspaces', [
            'customerID' => $customer->id,
        ]);

        if ($code === 0) {
            $member = Member::create([
                'name' => self::PERSONAL_NAME,
                'email' => self::PERSONAL_EMAIL,
                'password' => Hash::make(self::PERSONAL_PASSWORD),
                'activated' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            Role::updateOrCreate(
                ['type' => MemberRoles::ACCOUNT_OWNER()],
                ['member_id' => $member->id]
            );

            for ($i = 1; $i <= self::WORKSPACES; $i++) {
                $sub = $i === 1 ? self::PERSONAL_SUB : self::PERSONAL_SUB . '-' . $i;

                $workspace = Workspace::create([
                    'customer_id' => $customer->id,
                    'name' => 'Personal Test Workspace ' . $i,
                    'sub' => $sub,
                ]);

                $member->workspaces()->attach($workspace->id);

                for ($k = 1; $k <= self::MEMBERS_PER_WORKSPACE; $k++) {
                    $otherMembers = Member::create([
                        'name' => $faker->name,
                        'email' => $faker->unique()->safeEmail,
                        'password' => Hash::make(self::PERSONAL_PASSWORD),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                    Role::updateorCreate(
                        ['member_id' => $otherMembers->id, 'workspace_id' => $workspace->id],
                        ['type' => $this->generateRandomRole()]
                    );

                    $otherMembers->workspaces()->attach($workspace->id);
                }

                $this->generateFolderStructure($customer->id, $workspace->id);
            }
        }
    }

    private function generateRandomRole(): string
    {
        try {
            $key = Arr::flatten(MemberRoles::keys())[random_int(3, 9)];
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }

        return MemberRoles::$key();
    }

    private function generateFolderStructure($customerID, $workspaceID)
    {
        Storage::disk('spaces')->makeDirectory("{$customerID}/{$workspaceID}");
    }
}
