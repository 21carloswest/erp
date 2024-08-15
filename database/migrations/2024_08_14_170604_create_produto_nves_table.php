<?php

use App\Models\Nfe;
use App\Models\Produto;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produto_nfe', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Nfe::class, 'nfeId');
            $table->foreignIdFor(Produto::class, 'produtoId');
            $table->string('cfop');
            $table->decimal('vOutro', 13, 2);
            $table->decimal('vDesc', 13, 2);
            $table->decimal('vSeg', 13, 2);
            $table->decimal('vFrete', 13, 2);
            $table->decimal('valor', 7, 4);
            $table->decimal('quantidade', 11, 4);
            $table->decimal('vProd', 13, 2);

            $table->decimal('vBcIcms', 13, 2);
            $table->decimal('aliquotaIcms', 4, 4);
            $table->decimal('vICMS', 13, 2);

            $table->decimal('vBcIcmsSt', 13, 2);
            $table->decimal('aliquotaIcmsSt', 4, 4);
            $table->decimal('vICMSSt', 13, 2);

            $table->decimal('vBcIpi', 13, 2);
            $table->decimal('aliquotaIpi', 4, 4);
            $table->decimal('vIpi', 13, 2);

            $table->decimal('vBcCofins', 13, 2);
            $table->decimal('aliquotaCofins', 4, 4);
            $table->decimal('vCofins', 13, 2);

            $table->decimal('vBcPis', 13, 2);
            $table->decimal('aliquotaPis', 4, 4);
            $table->decimal('vPis', 13, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produto_nfe');
    }
};
