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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('userid');
            $table->integer('invoiceid')->unique();
            $table->string('promocode')->nullable();
            $table->string('credit');
            $table->string('payment_method')->nullable();
            $table->string('txid')->nullable();
            $table->string('status');
            $table->timestamp('due_at')->nullable();
            $table->timestamp('paid_on')->nullable();
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
        Schema::dropIfExists('invoices');
    }
};
