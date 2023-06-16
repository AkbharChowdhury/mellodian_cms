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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_title', 100)->nullable(false);
            $table->text('event_description')->nullable(false);
            $table->date('event_date')->nullable(false);
            $table->time('start_time', $precision = 0)->nullable(false);
            $table->time('end_time', $precision = 0)->nullable(false);
            $table->char('adult_supervision', 1)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
