<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ketquaphongvan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('phong_van_id')->constrained('phongvan')->onDelete('cascade');
            $table->integer('diem_so');
            $table->text('nhan_xet');
            $table->enum('ket_qua', ['dau', 'rot'])->default('rot');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ketquaphongvan');
    }
};
