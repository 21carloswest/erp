<?php

use App\Models\Cnae;
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
        Schema::create('empresa_cnaes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Empresa::class, 'empresaId');
            $table->foreignIdFor(Cnae::class,'cnaeId');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresa_cnaes');
    }
};
