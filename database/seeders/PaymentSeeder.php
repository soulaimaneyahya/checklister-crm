<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use App\Models\Payment;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payments = [
            [
                'user_id' => 1,
                'payment_id' => '9585510193037',
                'payer_id' => '9585513037297',
                'payer_email' => 'admin@admin.com',
                'amount' => 1.00,
                'currency' => 'USD',
                'payment_status' => Arr::random(Payment::STATUS),
            ],
            [
                'user_id' => 2,
                'payment_id' => 'ca-28592725040297',
                'payer_id' => 'ba-28592725040297',
                'payer_email' => 'john@doe.com',
                'amount' => 1.00,
                'currency' => 'USD',
                'payment_status' => Arr::random(Payment::STATUS),
            ]
        ];
        
        foreach($payments as $pay) {
            Payment::firstOrCreate($pay);
        }
    }
}
