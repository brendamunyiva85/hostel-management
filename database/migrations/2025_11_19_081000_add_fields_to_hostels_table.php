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
        Schema::table('hostels', function (Blueprint $table) {
            $table->string('location')->after('warden_id');
            $table->integer('rooms_count')->after('location');
            $table->decimal('price_per_night', 8, 2)->after('rooms_count');
            $table->integer('total_beds')->after('price_per_night');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hostels', function (Blueprint $table) {
            $table->dropColumn('location');
            $table->dropColumn('rooms_count');
            $table->dropColumn('price_per_night');
            $table->dropColumn('total_beds');
        });
    }
};
