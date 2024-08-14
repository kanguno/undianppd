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
        Schema::create('wp_datas', function (Blueprint $table) {
            $table->unsignedBigInteger('nik')->primary();
            $table->string('nm_wp',100);
            $table->string('alm_wp',150);
            $table->string('no_hp',20);
            $table->string('email',50);
            $table->date('created_at');
            $table->date('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wp_datas');
    }
};
