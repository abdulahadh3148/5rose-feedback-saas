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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('table_no')->nullable()->after('order_type');
            $table->text('notes')->nullable()->after('status');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->string('notes')->nullable()->after('line_total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['table_no', 'notes']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['notes']);
        });
    }
};

