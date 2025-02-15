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
        Schema::create('crypto_rates', function (Blueprint $table) {
            $table->id();
            $table->decimal('bitcoin', 16, 8)->default(0.00000000);
            $table->decimal('trump', 16, 8)->default(0.00000000);
            $table->decimal('dogecoin', 16, 8)->default(0.00000000);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crypto_rates');
    }
};
