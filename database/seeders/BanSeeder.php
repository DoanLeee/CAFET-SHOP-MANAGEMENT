<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BanSeeder extends Seeder
{
    public function run()
    {
        DB::table('bans')->delete();
        DB::table('bans')->truncate();

        DB::table('bans')->insert([
            // [
            //     'ten_ban'       => 'Bàn 1',
            //     'slug_ban'      => 'ban1',
            //     'id_khu_vuc'    =>  1,
            //     'tinh_trang_b'  => random_int(0, 1),
            //     'trang_thai'  => random_int(0, 1),
            // ],
            [
                'ten_ban'       => 'Bàn 1',
                'slug_ban'      => 'ban-1',
                'id_khu_vuc'    => 1,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
            [
                'ten_ban'       => 'Bàn 2',
                'slug_ban'      => 'ban-2',
                'id_khu_vuc'    => 1,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
            [
                'ten_ban'       => 'Bàn 3',
                'slug_ban'      => 'ban-3',
                'id_khu_vuc'    => 1,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
            [
                'ten_ban'       => 'Bàn 4',
                'slug_ban'      => 'ban-4',
                'id_khu_vuc'    => 1,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
            [
                'ten_ban'       => 'Bàn 5',
                'slug_ban'      => 'ban-5',
                'id_khu_vuc'    => 1,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
            [
                'ten_ban'       => 'Bàn 6',
                'slug_ban'      => 'ban-6',
                'id_khu_vuc'    => 1,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
            [
                'ten_ban'       => 'Bàn 7',
                'slug_ban'      => 'ban-7',
                'id_khu_vuc'    => 1,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
            [
                'ten_ban'       => 'Bàn 8',
                'slug_ban'      => 'ban-8',
                'id_khu_vuc'    => 1,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
            [
                'ten_ban'       => 'Bàn 9',
                'slug_ban'      => 'ban-9',
                'id_khu_vuc'    => 1,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
            [
                'ten_ban'       => 'Bàn 10',
                'slug_ban'      => 'ban-10',
                'id_khu_vuc'    => 1,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
                ////////////////////////////////////////////
            [
                'ten_ban'       => 'Bàn 11',
                'slug_ban'      => 'ban-11',
                'id_khu_vuc'    =>  2,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
            [
                'ten_ban'       => 'Bàn 12',
                'slug_ban'      => 'ban-12',
                'id_khu_vuc'    => 2,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
            [
                'ten_ban'       => 'Bàn 13',
                'slug_ban'      => 'ban-13',
                'id_khu_vuc'    => 2,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
            [
                'ten_ban'       => 'Bàn 14',
                'slug_ban'      => 'ban-14',
                'id_khu_vuc'    => 2,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
            [
                'ten_ban'       => 'Bàn 15',
                'slug_ban'      => 'ban-15',
                'id_khu_vuc'    => 2,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
            [
                'ten_ban'       => 'Bàn 16',
                'slug_ban'      => 'ban-16',
                'id_khu_vuc'    => 2,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
            [
                'ten_ban'       => 'Bàn 17',
                'slug_ban'      => 'ban-17',
                'id_khu_vuc'    => 2,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
            [
                'ten_ban'       => 'Bàn 18',
                'slug_ban'      => 'ban-18',
                'id_khu_vuc'    => 2,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
            [
                'ten_ban'       => 'Bàn 19',
                'slug_ban'      => 'ban-19',
                'id_khu_vuc'    => 2,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
            [
                'ten_ban'       => 'Bàn 20',
                'slug_ban'      => 'ban-20',
                'id_khu_vuc'    => 2,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
                //////////////////////////////////////
            [
                'ten_ban'       => 'Bàn 21',
                'slug_ban'      => 'ban-21',
                'id_khu_vuc'    => 3,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
            [
                'ten_ban'       => 'Bàn 22',
                'slug_ban'      => 'ban-22',
                'id_khu_vuc'    => 3,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
            [
                'ten_ban'       => 'Bàn 23',
                'slug_ban'      => 'ban-23',
                'id_khu_vuc'    => 3,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
            [
                'ten_ban'       => 'Bàn 24',
                'slug_ban'      => 'ban-24',
                'id_khu_vuc'    => 3,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],

            [
                'ten_ban'       => 'Bàn 25',
                'slug_ban'      => 'ban-25',
                'id_khu_vuc'    => 3,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
            [
                'ten_ban'       => 'Bàn 26',
                'slug_ban'      => 'ban-26',
                'id_khu_vuc'    => 3,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
            [
                'ten_ban'       => 'Bàn 27',
                'slug_ban'      => 'ban-27',
                'id_khu_vuc'    => 3,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
            [
                'ten_ban'       => 'Bàn 28',
                'slug_ban'      => 'ban-28',
                'id_khu_vuc'    => 3,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
            [
                'ten_ban'       => 'Bàn 29',
                'slug_ban'      => 'ban-29',
                'id_khu_vuc'    => 3,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
            [
                'ten_ban'       => 'Bàn 30',
                'slug_ban'      => 'ban-30',
                'id_khu_vuc'    => 3,
                'tinh_trang_b'  => 1,
                'trang_thai'  => 0,
            ],
        ]);
    }
}
