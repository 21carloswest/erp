<?php

use App\Models\Empresa;
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
        Schema::create('destinatarios', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Empresa::class, 'empresaId');
            $table->string('cnpjCpf', 14);
            $table->string('inscricaoEstadual', 14);
            $table->string('inscricaoMunicipal', 14);
            $table->enum('tipoIndicador', ['is', 'ic', 'nc']); //isenta icms nao contribuinte
            $table->string('nomeRazao', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinatarios');
    }
};
