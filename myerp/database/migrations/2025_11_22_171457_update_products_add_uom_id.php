<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('uom_id')
                ->nullable()
                ->after('category_id')
                ->constrained('uoms')
                ->nullOnDelete();

            $table->dropColumn('uom'); // remove old varchar field
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('uom_id');
            $table->string('uom')->nullable();
        });
    }
};
