<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bp_accounting', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_partner_id')->constrained('business_partners')->cascadeOnDelete();

            // Accounting fields
            $table->foreignId('ar_account_id')->nullable()->constrained('chart_of_accounts')->nullOnDelete();
            $table->foreignId('ap_account_id')->nullable()->constrained('chart_of_accounts')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bp_accounting');
    }
};
