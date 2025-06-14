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
        Schema::create('event_books', function (Blueprint $table) {
            $table->id();
            $table->integer('event_id');
            $table->date('event_date');
            $table->string('fullname');
            $table->string('email');
            $table->text('description')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->unique(['event_id', 'event_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_books');
    }
};
