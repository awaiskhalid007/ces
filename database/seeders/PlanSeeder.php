<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;
use App\Http\Controllers\SubscriptionController;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name' => 'Monthly Plan','currency' => 'USD', 'price' => 69],
            ['name' => 'Yearly Plan','currency' => 'USD', 'price' => 179],
            ];

        foreach ($items as $item) {
            if (Plan::where('name', '=', $item['name'])->first() === null) {
                (new SubscriptionController)->createPlan($item['name'],$item['price'],$item['currency']);
            }
        }

    }
}
