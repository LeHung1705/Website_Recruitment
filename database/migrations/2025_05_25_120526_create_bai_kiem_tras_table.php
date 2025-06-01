<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('baikiemtra', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoi_tao_id')->constrained('users')->onDelete('cascade');
            $table->text('noi_dung');
            $table->string('loai_bai');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('baikiemtra');
    }
};
