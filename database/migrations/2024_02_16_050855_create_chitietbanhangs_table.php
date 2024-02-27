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
        Schema::create('chitietbanhangs', function (Blueprint $table) {
            $table->id();
            $table->integer('id_hoa_don_ban_hang');
            $table->integer('id_menu');
            $table->string('ten_mon');
            $table->double('so_luong_ban');
            $table->double('don_gia_ban');
            $table->double('tien_chiet_khau');
            $table->double('thanh_tien');
            $table->string('ghi_chu')->nullable();
            $table->integer('is_in_bep')->default(0);
            $table->integer('is_che_bien')->default(0);

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
        Schema::dropIfExists('chitietbanhangs');
    }
};
