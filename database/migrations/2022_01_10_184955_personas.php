<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('fecha_nacimiento',50);
            $table->string('lugar_nacimiento',50);
            $table->string('genero',50);
            $table->string('estado_civil',50);
            $table->string('ocupacion',100);
            $table->string('distrito',20);
            $table->string('sub_central',100);
            $table->string('sindicato',100);
            $table->string('ubicacion');
            $table->unsignedBigInteger('rubro_id');
            $table->string('tipo');
            $table->timestamp('fecha_registro')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->enum('status',['ACTIVO','INACTIVO'])->default('ACTIVO');

            $table->foreign('rubro_id')->references('id')->on('rubros');
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
