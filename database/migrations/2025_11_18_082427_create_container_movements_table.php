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
        Schema::create('container_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('container_id')->constrained()->onDelete('cascade');
            $table->string('from_status');
            $table->string('to_status');
            $table->string('movement_type')->nullable(); // e.g., 'TRAIN_ARRIVAL', 'CY_TRANSFER', etc.
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Who made the change
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['container_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('container_movements');
    }
};
