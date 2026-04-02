<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
{
    Schema::create('sales', function (Blueprint $table) {

        $table->id();

        $table->foreignId('customer_id')
            ->nullable()
            ->constrained()
            ->nullOnDelete();

        $table->decimal('total',10,2);

        $table->timestamps();

    });
}

};
