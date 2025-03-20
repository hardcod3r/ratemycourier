<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Courier;
use Illuminate\Support\Testing\Fakes\Fake;
class CourierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //create 10 fake couriers
        Courier::factory()->count(10)->create();
    }
}
