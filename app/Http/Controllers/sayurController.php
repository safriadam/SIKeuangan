<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\sayuran;
use App\Bibit;
use App\Nutrisi;
use App\Bahan_lain;

class sayurController extends Controller
{
   public function index()
    {
        $sayur 				= sayuran::all();
        $data['sayuran']    = $sayur;

        $bibit              = Bibit::all();
        $data['bibit']      = $bibit;

        $nutrisi            = Nutrisi::all();
        $data['nutrisi']    = $nutrisi;  

        $bahan_lain         = Bahan_lain::all();
        $data['bahan_lain']    = $bahan_lain;        

        return view('sayuran.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sayuran.create');
    }
    public function store(Request $request)
        {
            $sayur  = $request['nama_sayur'];

            sayuran::create(array('nama_sayur'=> $sayur));

            return redirect('sayuran');
        }

    public function createBibit()
    {
        $sayuran            = sayuran::lists('nama_sayur','id');
        $data['sayuran']    = $sayuran;
        return view('sayuran.createBibit',$data);
    }

    public function storeBibit(Request $request)
        {
            $sayur          = $request['nama_sayur'];
            $nama_sayur     = sayuran::where('id', $sayur)->value('nama_sayur');
            $bibit          = $request['nama_bibit'];
            $harga          = $request['harga_bibit'];

            bibit::create(array('sayur_id'=>$sayur,'nama_sayur'=>$nama_sayur,'nama_bibit'=>$bibit,'harga_bibit'=>$harga));

            return redirect('sayuran');
        }

    public function createNutrisi()
    {
        return view('sayuran.createNutrisi');
    }

    public function storeNutrisi(Request $request)
        {
            $nutrisi  = $request['nama_nutrisi'];
            $harga  = $request['harga_nutrisi'];

            Nutrisi::create(array('nama_nutrisi'=> $nutrisi,'harga_nutrisi'=>$harga));

            return redirect('sayuran');
        }

    public function createBahan()
    {
        return view('sayuran.createBahan');
    }

    public function storeBahan(Request $request)
        {
            $nama  = $request['nama_bahan_lain'];
            $harga  = $request['harga_bahan_lain'];

            Bahan_lain::create(array('nama_bahan_lain'=> $nama,'harga_bahan_lain'=>$harga));

            return redirect('sayuran');
        }

    
}
