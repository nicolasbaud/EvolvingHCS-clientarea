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
        Schema::create('pterodactyl_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('price');
            $table->integer('memory');
            $table->integer('cpu')->default(100);
            $table->integer('swap')->default(64);
            $table->integer('disk')->default(1000);
            $table->integer('databases')->default(1);
            $table->integer('backups')->default(1);
            $table->integer('allocations')->default(0);
            $table->integer('nest');
            $table->integer('egg');
            $table->integer('node');
            $table->string('visibility')->default('public');
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
        Schema::dropIfExists('pterodactyl_products');
    }
};
