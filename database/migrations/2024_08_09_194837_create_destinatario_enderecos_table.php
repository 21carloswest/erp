<?php

use App\Models\Destinatario;
use App\Models\Municipio;
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
        Schema::create('destinatario_enderecos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Destinatario::class, 'destinatarioId');
            $table->foreignIdFor(Municipio::class, 'municipioId');
            $table->string('cep');
            $table->string('bairro', 255);
            $table->string('endereco', 255);
            $table->string('numero', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinatario_enderecos');
    }
};
