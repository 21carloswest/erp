<?php

use App\Models\IndicadorPresenca;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('indicador_presencas', function (Blueprint $table) {
            $table->integer('id');
            $table->string('name');

            // 0=Não se aplica (por exemplo, Nota Fiscal complementar 
            // ou de ajuste);
            // 1=Operação presencial;
            // 2=Operação não presencial, pela Internet; 
            // 3=Operação não presencial, Teleatendimento; 
            // 4=NFC-e em operação com entrega a domicílio; 
            // 5=Operação presencial, fora do estabelecimento; (incluído 
            // NT2016.002)
            // 9=Operação não presencial, outros.

        });

        IndicadorPresenca::insert([
            ['id' => 0, 'name' => 'Não se aplica'],
            ['id' => 1, 'name' => 'Operação presencial'],
            ['id' => 2, 'name' => 'Operação não presencial, pela Internet'],
            ['id' => 3, 'name' => 'Operação não presencial, Teleatendimento'],
            ['id' => 4, 'name' => 'NFC-e em operação com entrega a domicílio'],
            ['id' => 5, 'name' => 'Operação presencial, fora do estabelecimento'],
            ['id' => 9, 'name' => 'Operação não presencial, outros'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicador_presencas');
    }
};
