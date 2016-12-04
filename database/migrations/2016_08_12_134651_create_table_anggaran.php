<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAnggaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anggarans', function (Blueprint $table) {
            $table->increments('id');
            $table->date('masa_tanam');
            $table->foreign('sayur_id')->references('id')->on('sayurans');
            $table->string('nama_sayur',100);
            $table->integer('bibit',10);
            $table->string('ket_bibit',10);
            $table->integer('nutrisi',10);
            $table->string('ket_nutrisi',10);
            $table->integer('bahan_lain',10);
            $table->string('ket_bahan_lain',10);
            $table->integer('tot_anggaran',10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('anggaran');
    }
}
