<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EntregasProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entregas_productos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_registro');
            $table->unsignedBigInteger('id_producto');
            $table->timestamp('fecha_entrega')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('fecha_anulacion')->nullable();
            $table->integer('usuario_anulo')->nullable();
            $table->string('status')->default('ENTREGADO');
        
         
            $table->foreign('id_usuario')->references('id')->on('users');
            $table->foreign('id_registro')->references('id')->on('registros_entregas');
            $table->foreign('id_producto')->references('id')->on('productos');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entregas_productos');
    }
}
