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
        Schema::create('product_category_accts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('product_category_id');
            $table->unsignedBigInteger('inventory_account_id')->nullable();
            $table->unsignedBigInteger('cogs_account_id')->nullable();
            $table->unsignedBigInteger('sales_account_id')->nullable();

            $table->timestamps();

            $table->foreign('product_category_id')->references('id')->on('product_categories')->onDelete('cascade');
            $table->foreign('inventory_account_id')->references('id')->on('chart_of_accounts')->onDelete('set null');
            $table->foreign('cogs_account_id')->references('id')->on('chart_of_accounts')->onDelete('set null');
            $table->foreign('sales_account_id')->references('id')->on('chart_of_accounts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_category_acct');
    }
};
