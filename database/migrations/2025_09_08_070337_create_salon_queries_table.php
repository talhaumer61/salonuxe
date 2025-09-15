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
        Schema::create('salon_queries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_id')->nullable();   // optional, if query about a job
            $table->unsignedBigInteger('salon_id');            // salon being asked (salons.salon_id)
            $table->unsignedBigInteger('user_id');             // user who asked (users.id or your session user id)
            $table->string('subject')->nullable();
            $table->enum('status', ['open','closed'])->default('open');
            $table->boolean('is_replied')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salon_queries');
    }
};
