<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Membuat tabel Good Receipts dengan warehouse_id
        Schema::create('good_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('po_id')->constrained('purchase_orders')->cascadeOnDelete(); // Relasi dengan Purchase Order
            $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnDelete(); // Relasi dengan Warehouse
            $table->date('received_date');
            $table->string('received_by');
            $table->timestamps();
        });

        // Membuat tabel Good Receipt Details dengan locator_id dan bin_id
        Schema::create('good_receipt_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('good_receipt_id')->constrained('good_receipts')->cascadeOnDelete(); // Relasi dengan Good Receipt
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete(); // Relasi dengan Produk
            $table->foreignId('locator_id')->nullable()->constrained('locations')->nullOnDelete(); // Relasi dengan Locator
            $table->foreignId('bin_id')->nullable()->constrained('bins')->nullOnDelete(); // Relasi dengan Bin
            $table->integer('quantity'); // Jumlah produk yang diterima
            $table->decimal('unit_price', 10, 2); // Harga satuan produk yang diterima
            $table->decimal('total_price', 10, 2); // Harga total untuk produk yang diterima
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('good_receipt_details');
        Schema::dropIfExists('good_receipts');
    }
};
