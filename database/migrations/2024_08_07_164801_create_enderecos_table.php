<?php

use App\Models\Empresa;
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
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Empresa::class, 'empresaId');
            $table->foreignIdFor(Municipio::class, 'municipioId')->nullable();
            $table->integer('cep')->unsigned()->nullable();
            $table->string('bairro', 255)->nullable();
            $table->string('endereco', 255)->nullable();
            $table->string('numero', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enderecos');
    }
};
