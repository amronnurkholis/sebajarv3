<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel costume_sizes.
     */
    public function up(): void
    {
        Schema::create('costume_sizes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('costume_id')
                ->constrained('costumes')
                ->cascadeOnDelete();

            $table->enum('category', [
                'baju',
                'celana',
            ]);

            $table->string('size', 30);
            $table->unsignedInteger('quantity')->default(0);

            $table->timestamps();

            $table->unique([
                'costume_id',
                'category',
                'size',
            ]);

            $table->index([
                'costume_id',
                'category',
            ]);
        });
    }

    /**
     * Menghapus tabel costume_sizes.
     */
    public function down(): void
    {
        Schema::dropIfExists('costume_sizes');
    }
};
