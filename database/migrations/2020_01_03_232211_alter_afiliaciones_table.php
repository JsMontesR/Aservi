<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAfiliacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('afiliaciones', function (Blueprint $table) {

            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('servicio_id');
            $table->unsignedBigInteger('empresa_id');

            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('restrict');
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('restrict');
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('restrict');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('afiliaciones', function (Blueprint $table) {

            $table->dropForeign(['cliente_id']);
            $table->dropColumn('cliente_id'); 

            $table->dropForeign(['servicio_id']);
            $table->dropColumn('servicio_id'); 

            $table->dropForeign(['empresa_id']);
            $table->dropColumn('empresa_id'); 
        });
    }
}