<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migración para la tabla de solicitudes de soporte TI (Módulo 4)
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solicitudes_soporte', function (Blueprint $table) {
            $table->id();
            $table->string('solicitante', 100);
            $table->string('email_contacto');
            $table->enum('tipo_incidente', ['hardware', 'software', 'red', 'otro']);
            $table->text('descripcion_problema');
            $table->enum('urgencia', ['baja', 'media', 'alta', 'critica']);
            $table->string('equipo_afectado', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitudes_soporte');
    }
};
