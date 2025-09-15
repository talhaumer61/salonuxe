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
        Schema::create('salon_query_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('query_id');
            $table->enum('sender_type', ['user','salon']); // who sent it
            $table->unsignedBigInteger('sender_id');      // id of user or salon owner (depends on your auth)
            $table->text('message');
            $table->timestamp('created_at')->nullable();
            // no updated_at for messages needed usually
            $table->foreign('query_id')->references('id')->on('salon_queries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salon_query_messages');
    }
};
