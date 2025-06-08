<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ketquabaikiemtra', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoi_lam_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('bai_kiem_tra_id')->constrained('baikiemtra')->onDelete('cascade');
            $table->foreignId('don_ung_tuyen_id')->constrained('donungtuyen')->onDelete('cascade');
            $table->integer('diem_so');
            $table->dateTime('ngay_lam');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ketquabaikiemtra');
    }
};
