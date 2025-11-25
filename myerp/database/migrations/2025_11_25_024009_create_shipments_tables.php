<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Shipment Header
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('so_id')->constrained('sales_orders')->cascadeOnDelete();
            $table->string('shipment_number')->unique();
            $table->date('shipment_date');
            $table->foreignId('warehouse_id')->constrained('warehouses');
            $table->string('delivered_by')->nullable();
            $table->string('status')->default('draft'); // draft, posted
            $table->timestamps();
        });

        // Shipment Detail
        Schema::create('shipment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->constrained('shipments')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('uom_id')->constrained('uoms');
            $table->decimal('quantity', 15, 2);
            $table->foreignId('bin_id')->constrained('bins');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipment_details');
        Schema::dropIfExists('shipments');
    }
};
