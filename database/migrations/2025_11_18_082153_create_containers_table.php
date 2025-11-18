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
        Schema::create('containers', function (Blueprint $table) {
            $table->id();
            $table->string('container_number')->unique();
            $table->enum('size', ['20ft', '40ft', '45ft']);
            $table->enum('type', ['STANDARD', 'REEFER', 'FLATRACK']);
            $table->enum('status', [
                'ON_TRAIN', 'DISCH', 'FULL_OUT_CY',
                'EMPTY_IN_CY', 'EMPTY_OUT_CY', 'FULL_IN_CY', 'LOAD'
            ])->default('ON_TRAIN');
            $table->string('current_location')->nullable();
            $table->foreignId('train_shipment_id')->nullable(); // Foreign key will be added after train_shipments table is created
            $table->foreignId('depo_id')->nullable(); // Foreign key will be added after depots table is created
            $table->enum('condition', ['GOOD', 'DAMAGED', 'MAINTENANCE'])->default('GOOD');
            $table->boolean('is_borrowed')->default(false);
            $table->string('borrowed_to')->nullable(); // Who borrowed this container
            $table->timestamp('borrowed_at')->nullable(); // When it was borrowed
            $table->string('purpose')->nullable(); // Purpose like 'STUFFING' or 'RETURN'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('containers');
    }
};
