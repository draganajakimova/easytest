<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversionInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversion_info', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->integer('source_currency_id');
            $table->integer('target_currency_id');
            $table->float('exchange_rate');
            $table->double('source_currency_value');
            $table->double('target_currency_value');
            $table->timestamps();

            $table->foreign('source_currency_id')
                ->references('id')
                ->on('currencies')
                ->onDelete('cascade');

            $table->foreign('target_currency_id')
                ->references('id')
                ->on('currencies')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conversion_info');
    }
}
