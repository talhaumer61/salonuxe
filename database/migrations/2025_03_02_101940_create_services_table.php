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
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('service_id');
            $table->integer('service_status')->comment('1: Active, 2: Inactive');
            $table->bigInteger('id_salon')->nullable();
            $table->string('service_name');
            $table->string('service_href');
            $table->bigInteger('id_type')->nullable();
            $table->bigInteger('service_price')->nullable();
            $table->text('service_desc')->nullable();
            $table->string('service_photo')->nullable();
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
        Schema::dropIfExists('services');
    }
};
