<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('criteria', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sub_area_id')
                ->constrained('sub_areas')
                ->cascadeOnDelete();

            $table->foreignId('maturity_level_id')
                ->constrained('maturity_levels')
                ->cascadeOnDelete();

            $table->string('kode_kriteria');
            $table->string('nama_kriteria');
            $table->text('deskripsi')->nullable();
            $table->unsignedInteger('urutan')->default(1);

            $table->timestamps();

            $table->unique([
                'sub_area_id',
                'maturity_level_id',
                'kode_kriteria'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('criteria');
    }
};