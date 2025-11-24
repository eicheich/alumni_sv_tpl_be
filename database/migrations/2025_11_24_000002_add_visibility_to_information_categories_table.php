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
        Schema::table('information_categories', function (Blueprint $table) {
            $table->boolean('visibility')->default(0)->after('name')->comment('0: public (guest & alumni), 1: private (authenticated users only)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('information_categories', function (Blueprint $table) {
            $table->dropColumn('visibility');
        });
    }
};
