<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hoadonbanhang extends Model
{
    use HasFactory;
    protected $table = 'hoadonbanhangs';
    protected $fillable = [
        'ma_hoa_don_ban_hang',
        'tong_tien',
        'giam_gia',
        'id_ban',
        'trang_thai',
        'id_voucher',
        'is_xac_nhan',
        'ngay_thanh_toan',
    ];
}
