<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('salons', function (Blueprint $table) {
            $table->bigIncrements('salon_id');
            $table->integer('salon_status')->comment('1: Active, 2: Inactive');
            $table->bigInteger('id_user')->unique()->nullable();
            $table->string('salon_name');
            $table->string('salon_href')->nullable();
            $table->string('salon_address');
            $table->bigInteger('id_city')->nullable();
            $table->string('salon_logo');
            $table->string('opening_time');
            $table->string('closing_time');
            $table->string('salon_phone');
            $table->string('salon_email');
            $table->text('salon_about')->nullable();
            $table->bigInteger('id_added')->nullable();
            $table->bigInteger('id_modify')->nullable();
            $table->timestamp('date_added')->nullable();
            $table->timestamp('date_modify')->nullable();
            $table->boolean('is_deleted')->default(false)->comment('1 = deleted');
            $table->bigInteger('id_deleted')->nullable();
            $table->timestamp('date_deleted')->nullable();
            $table->string('ip_deleted')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salons');
    }
};
