<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel rentals.
     */
    public function up(): void
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();

            $table->string('customer_name', 100);
            $table->string('team_name', 100);
            $table->string('phone', 25);

            $table->string('costume_code', 50);

            $table->unsignedInteger('quantity');

            $table->date('rental_start');
            $table->date('rental_end');

            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'completed',
            ])->default('pending');

            $table->timestamps();

            $table->index('costume_code');
            $table->index('status');
            $table->index([
                'costume_code',
                'rental_start',
                'rental_end',
            ]);
        });
    }

    /**
     * Menghapus tabel rentals.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
