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
        Schema::create('salon_jobs', function (Blueprint $table) {
            $table->bigIncrements('job_id');
            $table->integer('job_status')->comment('1: Open , 2: Closed');
            $table->bigInteger('id_salon')->nullable();
            $table->string('job_title');
            $table->string('job_href');
            $table->text('job_desc')->nullable();
            $table->string('job_file')->nullable();
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
        Schema::dropIfExists('salon_jobs');
    }
};
