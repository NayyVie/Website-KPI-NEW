<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('criterion_submissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('unit_id')
                ->constrained('units')
                ->cascadeOnDelete();

            $table->foreignId('criterion_id')
                ->constrained('criteria')
                ->cascadeOnDelete();

            $table->string('file_bukti')->nullable();

            $table->enum('status_verifikasi', [
                'menunggu',
                'sesuai',
                'tidak_sesuai',
            ])->default('menunggu');

            $table->text('catatan_admin')->nullable();

            $table->timestamps();

            $table->unique(
                ['unit_id', 'criterion_id'],
                'submission_unit_criterion_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('criterion_submissions');
    }
};
