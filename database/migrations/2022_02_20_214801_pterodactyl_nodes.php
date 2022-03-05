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
        Schema::create('pterodactyl_nodes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location_id');
            $table->text('fqdn');
            $table->string('key');
            $table->string('pass');
            $table->string('status')->default('public');
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
        Schema::dropIfExists('pterodactyl_nodes');
    }
};
