<?php

use App\Models\Destinatario;
use App\Models\DestinatarioEndereco;
use App\Models\Empresa;
use App\Models\Finalidade;
use App\Models\IndicadorDestino;
use App\Models\IndicadorPresenca;
use App\Models\Intermediador;
use App\Models\NfeImposto;
use App\Models\NfeInfo;
use App\Models\Status;
use App\Models\Transportadora;
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
        Schema::create('nfe', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Empresa::class, 'empresaId');
            $table->foreignIdFor(Finalidade::class, 'finalidadeId')->nullable();
            $table->foreignIdFor(IndicadorDestino::class, 'destinoId')->nullable();
            $table->foreignIdFor(Status::class, 'statusId');
            $table->foreignIdFor(Intermediador::class, 'intermediadorId')->nullable();
            $table->foreignIdFor(Destinatario::class, 'destinatarioId')->nullable();
            $table->foreignIdFor(DestinatarioEndereco::class, 'destinatarioEnderecoId')->nullable();
            $table->foreignIdFor(Transportadora::class, 'transportadoraId')->nullable();

            $table->ipAddress('ipEnvio')->nullable();
            $table->string('naturezaOperacao', 60)->nullable();
            $table->boolean('saida')->nullable();
            $table->integer('ambiente')->default(1); //0 producao 1 homologacao

            $table->timestamp('dtEmissao');
            $table->timestamp('dtSaida')->nullable();
            $table->timestamp('dtAutorizacao')->nullable();

            $table->string('chave', 55)->nullable();
            $table->integer('serie');
            $table->integer('numero');
            $table->string('codigo', 8);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nves');
    }
};
