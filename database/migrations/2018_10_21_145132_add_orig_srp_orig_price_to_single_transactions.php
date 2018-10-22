<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrigSrpOrigPriceToSingleTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('single_transactions', function($table) {
            $table->double('orig_price', 15, 4);
            $table->double('orig_srp', 15, 4);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('single_transactions', function($table) {
            $table->dropColumn('orig_price');
            $table->dropColumn('orig_srp');
        });
    }
}
