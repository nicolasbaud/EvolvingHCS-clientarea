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
        Schema::create('pterodactyl_logs', function (Blueprint $table) {
            $table->id();
            $table->string('serviceid')->nullable();
            $table->string('name');
            $table->string('type');
            $table->longText('result');
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
        Schema::dropIfExists('pterodactyl_logs');
    }
};
