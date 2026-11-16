
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sub_areas', function (Blueprint $table) {
            $table->foreignId('unit_id')
                ->nullable()
                ->after('id')
                ->constrained('units')
                ->cascadeOnDelete();

            // Kode sub-area nantinya boleh sama
            // jika berada di unit yang berbeda.
            $table->dropUnique('sub_areas_kode_sub_area_unique');

            $table->unique(
                ['unit_id', 'kode_sub_area'],
                'sub_areas_unit_kode_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('sub_areas', function (Blueprint $table) {
            $table->dropUnique('sub_areas_unit_kode_unique');
            $table->dropForeign(['unit_id']);
            $table->dropColumn('unit_id');

            $table->unique('kode_sub_area');
        });
    }
};
