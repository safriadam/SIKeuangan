<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePemasukansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemasukans', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tanggal_transaksi');
            $table->string('deskripsi');
            $table->integer('pemasukan');
            $table->enum('jenis_pema',['aset','produksi']);
            $table->integer('saldo_terakhir');
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
        Schema::drop('pemasukans');
    }
}
