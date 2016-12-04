<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\sayuran;

class sayurController extends Controller
{
   public function index()
    {
        $sayur 				= sayuran::all();
        $data['sayuran']    = $sayur;

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
}
