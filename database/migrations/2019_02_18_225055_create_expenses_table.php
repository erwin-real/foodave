<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('month')->nullable();
            $table->double('capital', 15, 4);
            $table->double('profit', 15, 4);
            $table->double('clerk', 15, 4);
            $table->double('rental', 15, 4);
            $table->double('water', 15, 4);
            $table->double('electric', 15, 4);
            $table->double('service', 15, 4);
            $table->double('others', 15, 4);
            $table->double('net_income', 15, 4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}
