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
        Schema::create('uom_conversions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('uom_from_id')->constrained('uoms')->cascadeOnDelete();
            $table->foreignId('uom_to_id')->constrained('uoms')->cascadeOnDelete();
            $table->decimal('factor', 30, 12); // qty_in_to = qty_in_from * factor
            $table->timestamps();

            $table->unique(['uom_from_id', 'uom_to_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uom_conversions');
    }
};
