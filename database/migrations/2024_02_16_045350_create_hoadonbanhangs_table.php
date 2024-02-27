<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hoadonbanhangs', function (Blueprint $table) {
            $table-> id();
            $table-> string ('ma_hoa_don_ban_hang') ;
            $table-> double ('tong_tien')->default(0) ;
            $table-> double ('giam_gia')->default(0) ;
            $table-> integer ('id_ban') ;
            $table-> integer ('trang_thai')->default(0)->comment('0:Đang hoạt dộng , 1:Hóa đơn hoàn thành') ;
            $table->integer('id_voucher')->default(0);
            $table->integer('is_xac_nhan')->default(0);
            $table->dateTime('ngay_thanh_toan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hoadonbanhangs');
    }
};
