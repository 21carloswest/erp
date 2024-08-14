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
        Schema::create('transportadoras', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Empresa::class, 'empresaId');
            $table->string('cnpjCpf', 14);
            $table->string('nomeRazao', 70);
            $table->string('inscricaoEstadual', 14);
            $table->string('endereco', 62);
            $table->string('municpio', 62);
            $table->string('uf', 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transportadoras');
    }
};
