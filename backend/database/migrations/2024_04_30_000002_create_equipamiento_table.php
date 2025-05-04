<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('equipamiento', function (Blueprint $table) {
            $table->id('id_equipamiento');
            $table->foreignId('id_ubicacion')->constrained('ubicaciones', 'id_ubicacion');
            $table->string('tipo');
            $table->string('marca');
            $table->string('modelo');
            $table->string('numero_serie')->unique();
            $table->string('estado');
            $table->date('fecha_adquisicion');
            $table->date('fecha_garantia')->nullable();
            $table->text('observaciones')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipamiento');
    }
}; 