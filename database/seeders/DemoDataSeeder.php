<?php

namespace Database\Seeders;

use App\Models\Api;
use App\Models\ApiVersion;
use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::firstOrCreate(['slug' => 'acme'], ['name' => 'Acme Corp', 'billing_email' => 'billing@acme.test']);
        $admin = User::firstOrCreate(['email' => 'admin@acme.test'], ['name' => 'Admin User', 'password' => Hash::make('password')]);

        $admin->roles()->syncWithoutDetaching([Role::where('name', 'admin')->firstOrFail()->id]);
        $admin->tenants()->syncWithoutDetaching([$tenant->id => ['is_default' => true]]);

        $api = Api::firstOrCreate(['tenant_id' => $tenant->id, 'slug' => 'orders'], [
            'name' => 'Orders API',
            'description' => 'Primary orders service',
            'base_url' => 'https://orders.internal',
            'status' => true,
            'rate_limit_per_minute' => 120,
        ]);

        ApiVersion::firstOrCreate(['api_id' => $api->id, 'version' => 'v1'], ['status' => true]);
    }
}
