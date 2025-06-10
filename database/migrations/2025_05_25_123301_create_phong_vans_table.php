<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('phongvan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoi_to_chuc_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('don_ung_tuyen_id')->constrained('donungtuyen')->onDelete('cascade');
            $table->dateTime('thoi_gian');
            $table->string('hinh_thuc');
            $table->enum('trang_thai', ['cho_xac_nhan', 'da_xac_nhan'])->default('cho_xac_nhan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('phongvan');
    }
};
