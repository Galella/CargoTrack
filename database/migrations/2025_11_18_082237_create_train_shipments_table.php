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
        Schema::create('train_shipments', function (Blueprint $table) {
            $table->id();
            $table->string('train_number');
            $table->string('train_name');
            $table->string('origin_station');
            $table->string('destination_station');
            $table->timestamp('departure_time');
            $table->timestamp('estimated_arrival');
            $table->timestamp('actual_arrival')->nullable();
            $table->integer('wagon_count');
            $table->enum('status', ['PENDING', 'SHIPPED', 'ARRIVED', 'DELIVERED'])->default('PENDING');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('train_shipments');
    }
};
