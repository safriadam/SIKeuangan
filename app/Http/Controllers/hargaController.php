<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\pengeluaran;
use App\harga_pokok;

class hargaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $harga = harga_pokok::all();
        $data['harga']      = $harga;
        $data['y']          = date('Y');
        $data['m']  = date('m');
        return view('hargapokok.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['harga']   = harga_pokok::find($id);
        return view('hargapokok.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $harga = harga_pokok::find($id);      
        $harga->update($data);
        
        return redirect('harga');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function tahunBulan(request $request)
    {
        $month                  = $request['masaTanam'];
        $year                   = $request['year'];
        $harga                  = harga_pokok::whereYear('masa_tanam', '=', $year)
                                             ->whereMonth('masa_tanam', '=', $month)
                                             ->paginate(40);
        $data['harga']          = $harga;
        $data['y']              = $year;
        $data['m']              = $month;
        $data['saldo']          = 40000; //transaksi::latest()->first();
        return view('hargapokok.index',$data);
    }
}
