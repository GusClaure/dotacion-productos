<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Personas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->integer('nro_formulario');
            $table->integer('nro_cel');
            $table->string('nombre',150);
            $table->string('primer_ap',100);
            $table->string('segundo_ap',100);
            $table->string('ci',20)->unique();
            $table->string('expedido',50);
            $table->string('distrito',20);
            $table->string('sub_central',100);
            $table->string('sindicato',100);
            $table->string('ubicacion');
            $table->timestamp('fecha_registro')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('usuario_id')->nullable();
            $table->timestamp('fecha_entrega')->nullable();
            $table->unsignedBigInteger('categoria_id');
            $table->string('tipo');
            $table->string('producto')->nullable();;
            $table->text('observacion')->nullable();
            $table->enum('status',['PENDIENTE','ENTREGADO', 'OBSERVADO'])->default('PENDIENTE');
            $table->foreign('categoria_id')->references('id')->on('categorias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personas');
    }
}
