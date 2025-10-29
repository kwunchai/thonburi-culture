<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IntellectualProperty;
use App\Models\User;

class IntellectualPropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding Intellectual Properties...');

        // Create test users if they don't exist
        $users = User::factory()->count(5)->create();

        // Create various types of IPs
        $this->command->info('Creating Copyrights...');
        IntellectualProperty::factory()
            ->count(15)
            ->copyright()
            ->registered()
            ->recycle($users)
            ->create();

        $this->command->info('Creating Patents...');
        IntellectualProperty::factory()
            ->count(10)
            ->patent()
            ->active()
            ->recycle($users)
            ->create();

        $this->command->info('Creating Local Wisdom entries...');
        IntellectualProperty::factory()
            ->count(20)
            ->localWisdom()
            ->registered()
            ->recycle($users)
            ->create();

        $this->command->info('Creating Expiring IPs...');
        IntellectualProperty::factory()
            ->count(5)
            ->expiringSoon()
            ->recycle($users)
            ->create();

        $this->command->info('Creating Expired IPs...');
        IntellectualProperty::factory()
            ->count(3)
            ->expired()
            ->recycle($users)
            ->create();

        $this->command->info('Creating Draft IPs...');
        IntellectualProperty::factory()
            ->count(8)
            ->state(['status' => 'draft'])
            ->recycle($users)
            ->create();

        $totalCount = IntellectualProperty::count();
        $this->command->info("✓ Successfully created {$totalCount} intellectual properties!");
    }
}