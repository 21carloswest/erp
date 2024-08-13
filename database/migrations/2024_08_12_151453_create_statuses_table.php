<?php

use App\Models\Status;
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
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();


        });
        Status::insert([
            ['id' => 1, 'name' => 'Emitida'],
            ['id' => 2, 'name' => 'Cancelada'],
            ['id' => 3, 'name' => 'Denegada'],
            ['id' => 4, 'name' => 'Não enviada'],
            ['id' => 5, 'name' => 'Sefaz retorno'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};
