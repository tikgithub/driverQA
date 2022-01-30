<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegisterTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_tests', function (Blueprint $table) {
            $table->id();
            $table->string('testerFullname')->nullable();
            $table->string('testingNo')->nullable();
            $table->string('testing_timespan')->nullable();
            $table->string('testTypeId')->nullable();
            $table->string('contact')->nullable();
            $table->string('email')->nullable();
            $table->dateTime('start_test_date')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('register_tests');
    }
}
