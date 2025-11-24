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
        Schema::create('stock_movements', function (Blueprint $t) {
            $t->id();
            $t->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $t->string('ref_type')->nullable(); // e.g. purchase, sale, adjust
            $t->unsignedBigInteger('ref_id')->nullable();
            $t->foreignId('from_warehouse_id')->nullable()->constrained('warehouses')->nullOnDelete();
            $t->foreignId('to_warehouse_id')->nullable()->constrained('warehouses')->nullOnDelete();
            $t->foreignId('from_location_id')->nullable()->constrained('locations')->nullOnDelete();
            $t->foreignId('to_location_id')->nullable()->constrained('locations')->nullOnDelete();
            $t->foreignId('to_bin_id')->nullable()->constrained('bins')->nullOnDelete();
            $t->decimal('qty', 20, 4);
            $t->string('note')->nullable();
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
