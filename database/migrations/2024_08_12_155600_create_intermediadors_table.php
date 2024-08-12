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
        Schema::create('intermediadors', function (Blueprint $table) {
            $table->id();
            $table->string('cnpj', 14);
            $table->string('name', 60);
            $table->foreignIdFor(Empresa::class, 'empresaId');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intermediadors');
    }
};
