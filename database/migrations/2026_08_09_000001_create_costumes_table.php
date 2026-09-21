<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel costumes.
     */
    public function up(): void
    {
        Schema::create('costumes', function (Blueprint $table) {
            $table->id();

            $table->string('code', 50)->unique();
            $table->string('name', 150);
            $table->string('image')->nullable();
            $table->text('description')->nullable();

            $table->enum('status', [
                'active',
                'inactive',
            ])->default('active');

            $table->timestamps();

            $table->index('status');
        });
    }

    /**
     * Menghapus tabel costumes.
     */
    public function down(): void
    {
        Schema::dropIfExists('costumes');
    }
};
