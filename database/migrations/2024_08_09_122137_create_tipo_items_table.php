<?php

use App\Models\TipoItem;
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
        Schema::create('tipo_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        TipoItem::insert([['id' => 1, 'name'=> 'Produto'], ['id' => 2, 'name'=> 'Serviço']]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_items');
    }
};
