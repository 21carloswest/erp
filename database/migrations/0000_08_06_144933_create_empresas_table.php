<?php

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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('cnpj', 14)->unique();
            $table->string('email')->unique();
            $table->string('razaoSocial');
            $table->string('nomeFantasia')->nullable();
            $table->string('inscricaoEstadual', 14)->nullable();
            $table->string('inscricaoMunicipal', 14)->nullable();
            $table->boolean('ativa');
            $table->string('password');
            $table->integer('regimeTributario')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
