<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourierServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courierServices = [
            [
                'name' => 'Pathao',
                'code' => 'PATHAO',
                'description' => 'Fast delivery service within Dhaka and major cities',
                'base_charge' => 60.00,
                'inside_dhaka_charge' => 60.00,
                'outside_dhaka_charge' => 120.00,
                'delivery_days_inside' => 1,
                'delivery_days_outside' => 2,
                'contact_phone' => '018XXXXXXXX',
                'website' => 'https://pathao.com',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'RedX',
                'code' => 'REDX',
                'description' => 'A concern of Daraz Bangladesh',
                'base_charge' => 50.00,
                'inside_dhaka_charge' => 50.00,
                'outside_dhaka_charge' => 100.00,
                'delivery_days_inside' => 1,
                'delivery_days_outside' => 3,
                'contact_phone' => '018XXXXXXXX',
                'website' => 'https://redx.com.bd',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sundarban Courier',
                'code' => 'SUNDARBAN',
                'description' => 'Traditional courier service with nationwide coverage',
                'base_charge' => 80.00,
                'inside_dhaka_charge' => 80.00,
                'outside_dhaka_charge' => 150.00,
                'delivery_days_inside' => 2,
                'delivery_days_outside' => 4,
                'contact_phone' => '017XXXXXXXX',
                'website' => 'https://sundarban.com',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Steadfast',
                'code' => 'STEADFAST',
                'description' => 'Logistics solution for e-commerce businesses',
                'base_charge' => 70.00,
                'inside_dhaka_charge' => 70.00,
                'outside_dhaka_charge' => 130.00,
                'delivery_days_inside' => 1,
                'delivery_days_outside' => 3,
                'contact_phone' => '018XXXXXXXX',
                'website' => 'https://steadfast.com.bd',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'eCourier',
                'code' => 'ECOURIER',
                'description' => 'Technology-based courier service',
                'base_charge' => 65.00,
                'inside_dhaka_charge' => 65.00,
                'outside_dhaka_charge' => 125.00,
                'delivery_days_inside' => 1,
                'delivery_days_outside' => 3,
                'contact_phone' => '017XXXXXXXX',
                'website' => 'https://ecourier.com.bd',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Paperfly',
                'code' => 'PAPERFLY',
                'description' => 'Digital logistics platform',
                'base_charge' => 55.00,
                'inside_dhaka_charge' => 55.00,
                'outside_dhaka_charge' => 110.00,
                'delivery_days_inside' => 1,
                'delivery_days_outside' => 2,
                'contact_phone' => '018XXXXXXXX',
                'website' => 'https://paperfly.net',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'SA Paribahan',
                'code' => 'SAPARIBAHAN',
                'description' => 'Transport and courier service',
                'base_charge' => 75.00,
                'inside_dhaka_charge' => 75.00,
                'outside_dhaka_charge' => 140.00,
                'delivery_days_inside' => 2,
                'delivery_days_outside' => 4,
                'contact_phone' => '017XXXXXXXX',
                'website' => 'https://saparibahan.com',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jonty',
                'code' => 'JONTY',
                'description' => 'Fast and reliable delivery service',
                'base_charge' => 60.00,
                'inside_dhaka_charge' => 60.00,
                'outside_dhaka_charge' => 115.00,
                'delivery_days_inside' => 1,
                'delivery_days_outside' => 3,
                'contact_phone' => '018XXXXXXXX',
                'website' => 'https://jonty.com',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('courier_services')->insert($courierServices);
    }
}
