<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        Supplier::insert([
            [
                'name' => 'ABC Distributors',
                'contact' => 'contact@abcdistributors.com',
                'phone' => '0771234567',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Global Supplies Ltd',
                'contact' => 'sales@globalsupplies.com',
                'phone' => '0789876543',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sri Lanka Traders',
                'contact' => 'info@sltraders.lk',
                'phone' => '0712345678',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
