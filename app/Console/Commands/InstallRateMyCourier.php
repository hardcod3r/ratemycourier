<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\UserSeeder;
use Database\Seeders\CourierSeeder;
use Illuminate\Support\Facades\Redis;
class InstallRateMyCourier extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install-rate-my-courier';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Rate My Courier application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('migrate:fresh');
        //clear the cache
        Redis::flushall();
        $this->info('Database has been migrated successfully.');
        $this->info('Seeding users and couriers...');
        $this->call(UserSeeder::class);
        $this->call(CourierSeeder::class);
        $this->info('Users and Couriers have been seeded successfully.');
        //run tests
        $this->info('Running tests...');
        $this->call('test');
        $this->info('Tests have been run successfully.');
        $this->info('Generating application key...');
        $this->call('key:generate');
        $this->info('Application key has been generated successfully.');
        $this->info('Rate My Courier application has been installed successfully.');
        //run queue in the background
        $this->info('Rate My Courier application has been installed successfully.');
        $this->info('Please run "sail artisan queue:work" to start processing the queue.');
        //also show the user the command to run the playground
        $this->info('You can run the Courier Rating Playground by running "sail artisan courier:playground"');
    }
}
