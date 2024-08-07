<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        DB::table('permissions')->insert([
            ['name' => 'UserStore'],
            ['name' => 'UserUpdate'],
            ['name' => 'UserDestroy'],
            ['name' => 'UserIndex'],
            ['name' => 'UserShow'],

            ['name' => 'EmpresaUpdate'],
            ['name' => 'EmpresaDestroy'],
            ['name' => 'EmpresaShow'],

            ['name' => 'ImpostoStore'],
            ['name' => 'ImpostoUpdate'],
            ['name' => 'ImpostoDestroy'],
            ['name' => 'ImpostoIndex'],
            ['name' => 'ImpostoShow'],

            ['name' => 'ProdutoServicoStore'],
            ['name' => 'ProdutoServicoUpdate'],
            ['name' => 'ProdutoServicoDestroy'],
            ['name' => 'ProdutoServicoIndex'],
            ['name' => 'ProdutoServicoShow'],

            ['name' => 'DestinatarioStore'],
            ['name' => 'DestinatarioUpdate'],
            ['name' => 'DestinatarioDestroy'],
            ['name' => 'DestinatarioIndex'],
            ['name' => 'DestinatarioShow'],

            ['name' => 'NotaStore'],
            ['name' => 'NotaEnviar'],
            ['name' => 'NotaUpdate'],
            ['name' => 'NotaDestroy'],
            ['name' => 'NotaIndex'],
            ['name' => 'NotaShow'],

        ], );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
