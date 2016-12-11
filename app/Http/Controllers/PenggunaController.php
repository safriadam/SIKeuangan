<?php

namespace App\Http\Controllers;

use Cartalyst\Alerts\Native\Facades\Alert;
use Illuminate\Http\Request;
use App\pengguna;
use App\User;
use Validator;
use App\Http\Requests;
use App\Http\Requests\simpanProfil;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengguna = User::all();
        $data['pengguna']   = $pengguna;
        return view('pengguna.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pengguna.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(request $request)
    {
           $name = $request['name'];
           $email = $request['email'];
           $password = bcrypt('123456');
           $jabatan  = $request['jabatan'];
           User::create(array('name'=> $name,'email'=>$email,'password'=>$password,'jabatan'=>$jabatan));
        return redirect('pengguna');
    }

    // public function update(Request $request, $id)
    // {
    //     $name = $request['name'];
    //     $email = $request['email'];
    //     $password = bcrypt($request['password']);
    //     $jabatan  = $request['jabatan'];
    //     $pengguna   = User::find($id);
    //     $pengguna->update(array('name'=> $name,'email'=>$email,'password'=>$password,'jabatan'=>$jabatan));

    //     return redirect('pengguna');
    // }

    public function edit($id)
    {
        $pengguna = User::find($id);

        $identitas = Auth()->user()->id;

        if ($identitas == $id) {

                \Flash::error('Maaf anda tidak dapat menonaktifkan anda sendiri');

                return redirect('pengguna');
            }

        elseif($pengguna->status == 'AKTIF')
            {
                $pengguna->status = 'NONAKTIF';
                $pengguna->save();
            }
        else
            {
                $pengguna->status = 'AKTIF';
                $pengguna->save();
            }

        return redirect('pengguna');
    }

    public function reset($id)
    {
        $pengguna = User::find($id);
        $pengguna->password = bcrypt('123456');
        $pengguna->save();

        \Flash::success('password '.$pengguna->name.' telah direset menjadi: 123456 ');

        return redirect('pengguna');
    }

    

    public function profil($id)
    {
        $data['pengguna']    = user::find($id);
        $data['nama']       = null;
        $data['email']       = null;
        return view('pengguna.profil',$data);
    }


    public function simpan(simpanProfil $request, $id)
    {
        $pengguna = User::find($id);
        $password = $request['password'];

        $pengguna->name = $request['name'];
        $pengguna->email = $request['email'];
        $pengguna->password = bcrypt($password);
        $pengguna->save();

        \Flash::success('profil '.$pengguna->name.' telah berhasil disimpan');

        $data['pengguna']    = user::find($id);
        $data['nama']        = null;
        $data['email']       = null;
        return view('pengguna.profil',$data);
    }
   
    public function destroy($id)
    {

        $identitas = Auth()->user()->id;

        $pengguna = User::find($id);

           if ($identitas == $id) {

                \Flash::error('Maaf anda tidak dapat menghapus anda sendiri');

                return redirect('pengguna');
            }

           else{
            $pengguna->delete();
            }

            return redirect('pengguna');
        
    }
}
