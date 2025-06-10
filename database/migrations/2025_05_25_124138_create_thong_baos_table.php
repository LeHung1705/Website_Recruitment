<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('thongbao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoi_nhan_id')->constrained('users')->onDelete('cascade');
            $table->text('noi_dung');
            $table->enum('trang_thai', ['da_doc', 'chua_doc'])->default('chua_doc');
            $table->dateTime('thoi_gian_gui');
            $table->foreignId('bai_kiem_tra_id')->nullable()->constrained('baikiemtra')->onDelete('cascade');
            $table->enum('loai_thong_bao', ['phong_van', 'ket_qua_phong_van', 'khac'])->default('khac');
            $table->string('link')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('thongbao');
    }
};
