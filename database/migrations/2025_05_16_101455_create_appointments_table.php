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
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('status')->default(2)->comment('1: Accepted, 2: Pending, 3: Rejected');
            $table->string('href')->nullable();

            // Foreign keys
            $table->bigInteger('id_client')->nullable();
            $table->bigInteger('id_salon')->nullable();
            $table->bigInteger('id_service')->nullable();

            // Client info
            $table->string('client_name');
            $table->string('client_phone');
            $table->string('client_email');

            // Appointment details
            $table->string('appointment_date');
            $table->string('appointment_time');

            // Completion Status
            $table->boolean('is_completed')->default(false)->comment('1 = completed');


            // Audit fields
            $table->bigInteger('id_added')->nullable();
            $table->bigInteger('id_modify')->nullable();
            $table->timestamp('date_added')->nullable();
            $table->timestamp('date_modify')->nullable();

            // Soft delete fields
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
        Schema::dropIfExists('appointments');
    }
};
