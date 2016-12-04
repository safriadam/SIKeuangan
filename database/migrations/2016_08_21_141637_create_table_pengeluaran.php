<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePengeluaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengeluarans', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tanggal_transaksi');
            $table->string('item_pengeluaran');
            $table->integer('harga_satuan_peng')->nullable();
            $table->integer('qty_peng')->nullable();
            $table->integer('pengeluaran');
            $table->enum('jenis_peng',['aset','produksi']);
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
        Schema::drop('pengeluarans');
    }
}
