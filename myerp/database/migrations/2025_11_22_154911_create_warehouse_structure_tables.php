<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Warehouse Header
        Schema::create('warehouses', function (Blueprint $t) {
            $t->id();
            $t->string('code')->unique();
            $t->string('name');
            $t->timestamps();
        });

        // Locations under warehouse
        Schema::create('locations', function (Blueprint $t) {
            $t->id();
            $t->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnDelete();
            $t->string('code');
            $t->string('name');
            $t->timestamps();
        });

        // Bins under location
        Schema::create('bins', function (Blueprint $t) {
            $t->id();
            $t->foreignId('location_id')->constrained('locations')->cascadeOnDelete();
            $t->string('code');
            $t->string('name');
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bins');
        Schema::dropIfExists('locations');
        Schema::dropIfExists('warehouses');
    }
};
