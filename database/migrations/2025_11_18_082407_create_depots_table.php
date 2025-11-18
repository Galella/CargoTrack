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
        Schema::create('depots', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->string('address');
            $table->string('contact_person')->nullable();
            $table->string('contact_phone')->nullable();
            $table->text('description')->nullable();
            $table->enum('type', ['CY', 'WAREHOUSE', 'YARD'])->default('CY');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depots');
    }
};
