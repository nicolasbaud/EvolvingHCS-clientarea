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
        Schema::create('pterodactyl_services', function (Blueprint $table) {
            $table->id();
            $table->integer('userid');
            $table->string('serviceid')->unique();
            $table->string('offer_id');
            $table->string('first_price');
            $table->string('recurrent_price');
            $table->string('location');
            $table->string('status');
            $table->timestamps();
            $table->timestamp('expired_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pterodactyl_services');
    }
};
