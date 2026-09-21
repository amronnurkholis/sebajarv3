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
        Schema::create('rental_sizes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('rental_id')
                ->constrained('rentals')
                ->cascadeOnDelete();

            $table->string('category', 20);
            $table->string('size', 30);
            $table->unsignedInteger('quantity');

            $table->timestamps();

            $table->unique([
                'rental_id',
                'category',
                'size',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_sizes');
    }
};