<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('khuvucs', function (Blueprint $table) {
            $table->id();
            $table->string("ten_khu");
            $table->string("slug_khu");
            $table->integer("tinh_trang_kv");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khuvucs');
    }
};
