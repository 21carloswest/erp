<?php

use App\Models\IndicadorDestino;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('indicador_destinos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        IndicadorDestino::insert([['name' => 'estadual'], ['name' => 'interestadual'], ['name' => 'exterior']]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicador_destinos');
    }
};
