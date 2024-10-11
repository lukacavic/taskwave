<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Contract;
use App\Models\Event;
use App\Models\Lead;
use App\Models\Organisation;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Admin::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'name' => 'admin',
            'password' => bcrypt('admin'),
            'email' => 'admin@admin.com',
        ]);

        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'name' => 'admin',
            'administrator' => true,
            'password' => bcrypt('org1'),
            'email' => 'admin@org1.com',
            'organisation_id' => 1
        ]);

        Organisation::factory()->create([
            'name' => 'Company 1',
        ]);

        Client::factory()->count(10)->create();
        Contact::factory()->count(10)->create();
        Lead::factory()->count(10)->create();
        Project::factory()->count(10)->create();
        Contract::factory()->count(10)->create();
        Task::factory()->count(10)->create();
        Event::factory()->count(10)->create();
    }
}
