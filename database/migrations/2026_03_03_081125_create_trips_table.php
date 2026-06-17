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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('overview')->nullable();
            $table->string('departure_city');
            $table->string('destination');
            $table->string('meeting_point');
            $table->string('meeting_address')->nullable();
            $table->decimal('price', 12, 2);
            $table->integer('duration_days');
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive', 'draft'])->default('draft');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
