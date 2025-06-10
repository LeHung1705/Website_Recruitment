<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('donungtuyen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ung_vien_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('tin_tuyen_dung_id')->constrained('tintuyendung')->onDelete('cascade');
            $table->foreignId('nha_tuyen_dung_id')->constrained('users')->onDelete('cascade');
            $table->enum('trang_thai', ['phu_hop', 'khong_phu_hop', 'cho_xu_ly', 'da_tu_choi'])->default('cho_xu_ly');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('donungtuyen');
    }
};
