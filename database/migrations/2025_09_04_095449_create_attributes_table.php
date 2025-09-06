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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_type_id'); // link to Hair, Skin, etc.
            $table->string('key')->unique(); // e.g., suitable_for_hair_type
            $table->string('label'); // e.g., "Suitable for Hair Type"
            $table->enum('input_type', ['text', 'number', 'select', 'multiselect', 'radio', 'checkbox']); 
            $table->boolean('is_required')->default(false);
            $table->timestamps();

            $table->foreign('service_type_id')->references('id')->on('service_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};
