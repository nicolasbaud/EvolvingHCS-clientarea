<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets_replies', function (Blueprint $table) {
            $table->id();
            $table->biginteger('ticketid')->references('id')->on('tickets');
            $table->integer('userid')->references('id')->on('users');
            $table->string('adminid')->nullable();
            $table->longtext('content');
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
        Schema::dropIfExists('tickets_replies');
    }
};
