<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestDataSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup test data for development';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Setting up test data...');
        
        // Create test user
        $user = \App\Models\User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'name' => 'Test User'
        ]);
        
        $this->info("✓ Test user created with ID: {$user->id}");
        $this->info("  Email: {$user->email}");
        $this->info("  Password: password");
        
        // Check IP count
        $ipCount = \App\Models\IntellectualProperty::count();
        $this->info("✓ Total IPs in database: {$ipCount}");
        
        // Show first 5 IPs
        $ips = \App\Models\IntellectualProperty::take(5)->get();
        $this->info("✓ Sample IPs:");
        foreach ($ips as $ip) {
            $this->line("  - {$ip->title} ({$ip->type})");
        }
        
        $this->info("\n🎉 Setup completed!");
        $this->info("You can now test the API at: http://thonburi-culture.test/api/");
        
        return Command::SUCCESS;
    }
}
