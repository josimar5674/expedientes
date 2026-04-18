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
    Schema::create('expedientes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');


        $table->string('numero_expediente')->unique();
        $table->string('tipo_tramite');

        $table->string('matricula')->nullable();
        $table->string('sede')->nullable();

        $table->text('pretension_principal')->nullable();
        $table->decimal('cuantia', 12, 2)->nullable();

        $table->date('fecha_presentacion')->nullable();
        $table->text('descripcion_proceso')->nullable();

        $table->string('estado')->default('pendiente');
    
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expedientes');
    }
};
