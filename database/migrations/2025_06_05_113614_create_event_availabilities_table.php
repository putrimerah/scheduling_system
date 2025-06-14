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
        Schema::create('event_availabilities', function (Blueprint $table) {
            $table->id();
            $table->integer('event_id')->constrained('events')->onDelete('cascade');
            $table->string('event_day'); // e.g., Monday, or ISO date
            $table->json('event_times'); // e.g., ["09:00", "14:30"]
            $table->timestamp('created_at')->useCurrent();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_availabilities');
    }
};
