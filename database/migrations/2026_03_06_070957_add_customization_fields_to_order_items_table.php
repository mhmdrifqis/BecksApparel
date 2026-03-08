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
        Schema::table('order_items', function (Blueprint $table) {
            $table->string('size')->after('product_id')->nullable();
            $table->string('custom_name')->after('size')->nullable();
            $table->string('custom_number')->after('custom_name')->nullable();
            $table->foreignId('design_id')->after('custom_number')->nullable()->constrained('designs')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['design_id']);
            $table->dropColumn(['size', 'custom_name', 'custom_number', 'design_id']);
        });
    }
};
