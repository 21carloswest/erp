<?php

use App\Models\Nfe;
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
        Schema::create('nfe_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Nfe::class, 'nfeId');
            $table->text('infoFisco')->nullable();
            $table->text('infoComplementares')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nfe_infos');
    }
};
