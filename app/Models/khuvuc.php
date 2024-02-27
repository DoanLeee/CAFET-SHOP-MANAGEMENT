<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class khuvuc extends Model
{
    use HasFactory;use HasFactory;
    protected $table = 'khuvucs';
    protected $fillable = [
        'ten_khu',
        'slug_khu',
        'tinh_trang_kv',
    ];
}
