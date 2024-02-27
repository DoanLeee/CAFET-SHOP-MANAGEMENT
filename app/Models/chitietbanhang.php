<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chitietbanhang extends Model
{
    use HasFactory;
    protected $table = 'chitietbanhangs';
    protected $fillable = [
        'id_hoa_don_ban_hang',
        'id_menu',
        'ten_mon',
        'so_luong_ban',
        'don_gia_ban',
        'tien_chiet_khau',
        'thanh_tien',
        'ghi_chu',
        'is_in_bep',
        'is_che_bien',
    ];
}
