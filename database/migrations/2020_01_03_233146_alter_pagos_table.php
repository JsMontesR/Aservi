<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->unsignedBigInteger('afiliacion_id');
            $table->foreign('afiliacion_id')->references('id')->on('afiliaciones')->onDelete('restrict');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropForeign(['afiliacion_id']);
        $table->dropColumn('afiliacion_id'); 
        $table->dropForeign(['user_id']);
        $table->dropColumn('user_id');
    }
}
