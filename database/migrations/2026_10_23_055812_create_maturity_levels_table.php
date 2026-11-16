<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maturity_levels', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('level')
                ->unique();

            $table->string('nama_level');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maturity_levels');
    }
};