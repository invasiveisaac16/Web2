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
        Schema::create('comments', function (Blueprint $table) {
        $table->id();

        // Columna para el contenido del comentario
        $table->text('content');

        // Llave foránea para el USUARIO que escribió el comentario
        $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

        // Llave foránea para el POST al que pertenece el comentario
        $table->foreignId('post_id')->constrained()->cascadeOnDelete();

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
