<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCryptocurrencyBalancesToCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            // Add cryptocurrency balance columns
            $table->decimal('total_balance', 15, 8)->default(0.00); 
            $table->decimal('bitcoin_balance', 15, 8)->default(0.00);
            $table->decimal('trump_balance', 15, 8)->default(0.00);
            $table->decimal('dogecoin_balance', 15, 8)->default(0.00);

            // Add account number (unique)
            $table->string('account_number')->unique()->after('id'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            // Drop cryptocurrency balance columns
            $table->dropColumn(['total_balance', 'bitcoin_balance', 'trump_balance', 'dogecoin_balance', 'account_number']);
        });
    }
}
