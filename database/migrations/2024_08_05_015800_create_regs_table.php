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
        Schema::create('regs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nik')->constrained('wp_datas','nik')->onDelete('cascade');
            $table->foreignId('merchant_id')->constrained()->onDelete('cascade');
            $table->foreignId('status_id')->constrained()->onDelete('cascade');
            $table->datetime('tgl_bill');
            $table->string('bill_img',100)->nullable();
            $table->integer('status_tappingbox')->nullable();
            $table->string('tappingbox_id')->nullable();
            $table->string('keterangan')->nullable();
            $table->date('created_at');
            $table->date('updated_at');
           // $table->string('qris_img',100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regs');
    }
};
