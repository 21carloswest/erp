<?php

use App\Models\Nfe;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nfe_impostos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Nfe::class);
            $table->decimal('vBC', 13, 2);
            $table->decimal('vICMS', 13, 2);
            $table->decimal('vICMSDeson', 13, 2);
            $table->decimal('vFCPUFDest', 13, 2)->nullable();
            $table->decimal('vICMSUFDest', 13, 2)->nullable();
            $table->decimal('vICMSUFRemet', 13, 2)->nullable();
            $table->decimal('vFCP', 13, 2);
            $table->decimal('vBCST', 13, 2);
            $table->decimal('vST', 13, 2);
            $table->decimal('vFCPST', 13, 2);
            $table->decimal('vFCPSTRet', 13, 2);
            $table->decimal('vProd', 13, 2);
            $table->decimal('vFrete', 13, 2);
            $table->decimal('vSeg', 13, 2);
            $table->decimal('vDesc', 13, 2);
            $table->decimal('vII', 13, 2);
            $table->decimal('vIPI', 13, 2);
            $table->decimal('vIPIDevol', 13, 2);
            $table->decimal('vPIS', 13, 2);
            $table->decimal('vCOFINS', 13, 2);
            $table->decimal('vOutro', 13, 2);
            $table->decimal('vNF', 13, 2);
            $table->decimal('vTotTrib', 13, 2)->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nfe_impostos');
    }
};
