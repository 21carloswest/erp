<?php

use App\Models\Empresa;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('configuracaos', function (Blueprint $table) {
            $table->id();
            $table->integer('ambiente')->default(1); //0 producao 1 homologacao
            $table->boolean('habilitaNfe')->default(false);
            $table->boolean('habilitaNfce')->default(false);
            $table->boolean('habilitaNfse')->default(false);
            $table->integer('proxNfe')->nullable();
            $table->integer('proxNfce')->nullable();
            $table->integer('proxNfse')->nullable();
            $table->integer('serieNfe')->nullable();
            $table->integer('serieNfce')->nullable();
            $table->integer('serieNfse')->nullable();
            $table->foreignIdFor(Empresa::class,'empresaId');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracaos');
    }
};
