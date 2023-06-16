<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('users', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('salutation_id')
            ->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('firstname', 100)->nullable(false);
            $table->string('lastname', 100)->nullable(false);
            $table->string('email')->unique();
            $table->string('password')->nullable(false);
            $table->string('phone', 11)->nullable(false);
            $table->string('house_number', 11)->nullable(false);
            $table->string('street', 50)->nullable(false);
            $table->string('city', 30)->nullable(false);
            $table->string('postcode', 10)->nullable(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

        });
        DB::statement("ALTER TABLE `users` ADD `passport_image` LONGBLOB NULL AFTER `phone`");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
