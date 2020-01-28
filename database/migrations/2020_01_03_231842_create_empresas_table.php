<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Empresa;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->unique();
            $table->timestamps();
        });

        $empresa1 = new Empresa;
        $empresa1->id = 1;
        $empresa1->nombre = "Olga Lucía Arias";
        $empresa1->save();

        $empresa2 = new Empresa;
        $empresa2->id = 2;
        $empresa2->nombre = "José Alonso Amézquita";
        $empresa2->save();

        $empresa3 = new Empresa;
        $empresa3->id = 3;
        $empresa3->nombre = "Nelly Morales";
        $empresa3->save();

        $empresa4 = new Empresa;
        $empresa4->id = 4;
        $empresa4->nombre = "Valentina Ramirez";
        $empresa4->save();

        $empresa5 = new Empresa;
        $empresa5->id = 5;
        $empresa5->nombre = "John Fabio Ramirez";
        $empresa5->save();

        $empresa6 = new Empresa;
        $empresa6->id = 6;
        $empresa6->nombre = "Nora Elena Muñoz";
        $empresa6->save();

        $empresa7 = new Empresa;
        $empresa7->id = 7;
        $empresa7->nombre = "Independiente";
        $empresa7->save();

        $empresa8 = new Empresa;
        $empresa8->id = 8;
        $empresa8->nombre = "Externos";
        $empresa8->save();


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresas');
    }
}
