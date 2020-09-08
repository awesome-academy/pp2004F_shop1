<?php

use Illuminate\Database\Seeder;
use App\Models\Order;

class BillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = Order::where('status', Order::STT['completed'])->get();
        foreach ($orders as $order) {
            \DB::table('bills')->insert([
                'check_number' => uniqid(),
                'payment_date' => $order->created_at,
                'amount' => $order->getAmount(),
                'order_id' => $order->id,
            ]);
        }
    }
}
