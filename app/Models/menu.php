<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
    use HasFactory;use HasFactory;
    protected $table = 'menus';
    protected $fillable = [
        'ten_mon',
        'slug_mon',
        'gia_ban',
        'tinh_trang_m',
        'id_danh_muc',
        'hinh_anh',
    ];
}
