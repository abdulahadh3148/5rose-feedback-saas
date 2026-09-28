<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('feedback', function (Blueprint $table) {

            $table->string('status', 20)
                ->default('pending')
                ->after('customer_name')
                ->index();

            $table->timestamp('approved_at')
                ->nullable()
                ->after('status');

            $table->timestamp('rejected_at')
                ->nullable()
                ->after('approved_at');
        });
    }

    public function down(): void
    {
        Schema::table('feedback', function (Blueprint $table) {

            $table->dropIndex(['status']);

            $table->dropColumn([
                'status',
                'approved_at',
                'rejected_at',
            ]);
        });
    }
};
