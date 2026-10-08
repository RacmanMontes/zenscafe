<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('status')->default('active')->after('slug');
        });

        Schema::table('suppliers', function (Blueprint $table) {
            $table->string('status')->default('active')->after('slug');
        });

        DB::table('categories')->whereNotNull('deleted_at')->update(['status' => 'archived']);
        DB::table('suppliers')->whereNotNull('deleted_at')->update(['status' => 'archived']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
