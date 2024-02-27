<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KhuVucSeeder extends Seeder
{
    public function run()
    {
        DB::table('khuvucs')->delete();
        DB::table('khuvucs')->truncate();

        DB::table('khuvucs')->insert([
            [
                'ten_khu'          =>'Tầng 1',
                'slug_khu'         =>'tang-1',
                'tinh_trang_kv'    => random_int(0, 1),
            ],
            [
                'ten_khu'          =>'Tầng 2',
                'slug_khu'         =>'tang-2',
                'tinh_trang_kv'    => random_int(0, 1),
            ],
            [
                'ten_khu'          =>'tầng 3',
                'slug_khu'         =>'tang-3',
                'tinh_trang_kv'    => random_int(0, 1),
            ],
        ]);
    }
}
