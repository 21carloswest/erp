<?php

use App\Models\Finalidade;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('finalidades', function (Blueprint $table) {
            $table->integer('id');
            $table->string('name');
            $table->timestamps();

        });
        Finalidade::insert([
            ['id' => 1, 'name' => 'Normal'],
            ['id' => 1, 'name' => 'Complementar'],
            ['id' => 1, 'name' => 'Ajuste'],
            ['id' => 1, 'name' => 'Devolução'],
        ]);
        // 1=NF-e normal; 
        // 2=NF-e complementar; 
        // 3=NF-e de ajuste; 
        // 4=Devolução de mercadoria.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finalidades');
    }
};
