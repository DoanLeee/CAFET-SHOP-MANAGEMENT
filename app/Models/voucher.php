<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class voucher extends Model
{
    use HasFactory;

    protected $table = "vouchers";
    protected $fillable = [
        'ten_voucher',
        'tien_voucher',
    ];
}