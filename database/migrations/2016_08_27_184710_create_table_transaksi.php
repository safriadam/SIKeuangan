<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\pemasukan;
use App\pengeluaran;
class CreateTableTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Transaksis', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tgl_transaksi');
            $table->integer('pengeluaran_id')->unsigned();
            $table->foreign('pengeluaran_id')->references('id')->on('pengeluaran');
            $table->integer('pemasukan_id')->unsigned();
            $table->foreign('pemasukan_id')->references('id')->on('pemasukan');
            $table->integer('pengeluaran');
            $table->integer('pemasukan');
            $table->integer('saldo');
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
        Schema::drop('Transaksis');
    }
}
