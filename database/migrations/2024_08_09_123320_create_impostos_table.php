<?php

use App\Models\Cfop;
use App\Models\GrupoImpostos;
use App\Models\IndicadorDestino;
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
        Schema::create('impostos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(GrupoImpostos::class, 'grupoImpostosId');
            $table->foreignIdFor(IndicadorDestino::class, 'indicadorDestinoId');
            $table->foreignIdFor(Cfop::class, 'cfopId');
            $table->decimal('aliqIcms', 7, 4);
            $table->decimal('aliqIcmst', 7, 4);
            $table->decimal('aliqIcmsCredito', 7, 4);
            $table->decimal('aliqIpi', 7, 4);
            $table->decimal('aliqPis', 7, 4);
            $table->decimal('aliqCofins', 7, 4);
            $table->decimal('aliqIss', 7, 4);
            $table->integer('cstIcms');
            $table->integer('cstIpi');
            $table->integer('cstPis');
            $table->integer('cstCofins');
            $table->integer('enquadramentoIpi');
            $table->integer('origem');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('impostos');
    }
};
