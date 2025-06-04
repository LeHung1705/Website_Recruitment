<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tintuyendung', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoi_dang_id')->constrained('users')->onDelete('cascade'); 
            $table->string('tieu_de');
            $table->text('mo_ta');
            $table->string('nganh_nghe');
            $table->string('yeu_cau'); //yêu cầu: kinh nghiệm, trình độ
            $table->string('loai_cong_viec'); //hình thức: onsite, remote, hybrid
            $table->enum('thanh_pho', ['TP.HCM', 'TP.Hà Nội', 'TP.Đà Nẵng']);
            $table->string('dia_diem');
            $table->decimal('luong', 15, 2);
            $table->enum('trang_thai', ['da_phe_duyet', 'da_huy'])->default('da_phe_duyet');
            $table->timestamp('ngay_dang')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('tintuyendung');
    }
};
