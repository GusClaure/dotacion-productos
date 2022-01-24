<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Rubros extends Migration
{
    /**
     * Run the migrations.
     *s
     * @return void
     */
    public function up(){
        Schema::create('rubros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre_rubro',150)->nullable(false);
            $table->string('descripcion',100);
            $table->integer('status')->default(1);
            $table->timestamp('fecha_registro')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rubros');
    }
}
