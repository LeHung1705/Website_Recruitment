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
            $table->enum('trang_thai', ['cho_duyet', 'da_duyet', 'tu_choi'])->default('cho_duyet');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('donungtuyen');
    }
};
