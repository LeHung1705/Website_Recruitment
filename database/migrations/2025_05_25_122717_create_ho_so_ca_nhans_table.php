<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hosocanhan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoi_dung_id')->constrained('users')->onDelete('cascade');
            $table->text('hoc_van');
            $table->text('kinh_nghiem');
            $table->text('ky_nang');
            $table->string('cv_path')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hosocanhan');
    }
};
