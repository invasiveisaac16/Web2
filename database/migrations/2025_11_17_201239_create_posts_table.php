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
        Schema::create('posts', function (Blueprint $table) {
        $table->id();

        // Columna para el título del post
        $table->string('title'); 

        // Columna para el contenido (usamos 'text' para artículos largos)
        $table->text('content'); 

        // Columna para la LLAVE FORÁNEA (para conectar con categories)
        $table->foreignId('category_id')->constrained(); 

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
