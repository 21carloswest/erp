<?php

use App\Models\Empresa;
use App\Models\GrupoImpostos;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Empresa::class, 'empresaId');
            $table->foreignIdFor(GrupoImpostos::class, 'grupoImpostosId');
            $table->string('codigo', 60);
            $table->string('descricao', 120);
            $table->string('ean', 14);
            $table->string('ncm', 8);
            $table->string('cest', 7);
            $table->string('unid', 6);
            $table->decimal('valor', 7, 4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
