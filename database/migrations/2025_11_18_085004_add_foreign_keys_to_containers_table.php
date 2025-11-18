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
        Schema::table('containers', function (Blueprint $table) {
            // Add foreign key constraints after referenced tables exist
            $table->foreign('train_shipment_id')->references('id')->on('train_shipments')->onDelete('set null');
            $table->foreign('depo_id')->references('id')->on('depots')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('containers', function (Blueprint $table) {
            $table->dropForeign(['train_shipment_id']);
            $table->dropForeign(['depo_id']);
        });
    }
};
