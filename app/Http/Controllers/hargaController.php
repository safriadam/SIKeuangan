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

    public function hargapdf(request $request)
    {

        $month              = $request['month'];
        $year               = $request['year'];
        $hargapokok         = harga_pokok::whereYear('masa_tanam','=',$year)
                                        ->whereMonth('masa_tanam', '=', $month)
                                        ->paginate(50);

        $monthName = date("F", mktime(0, 0, 0, $month, 1));
        $operation = $month+2;
        $nextmonthName = date("F", mktime(0, 0, 0, $operation, 1));

        $pdf = new \fpdf\FPDF();
        $pdf->AddPage();
        $pdf->SetTitle('Cetak Anggaran');
        //headernya
                // Select Arial bold 15
            $pdf->SetFont('Arial','B',15);
            // Move to the right
            $pdf->Cell(80);
            // Framed title
            $pdf->Cell(30,10,'Sistem Informasi Keuangan ASRI 12 Kauman',0,1,'C');
            $pdf->Cell(65);
            $pdf->Cell(60,10,'HARGA JUAL PRODUK',1,0,'C');
            // Line break
            $pdf->Ln(20);
                
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(35,8,'Masa Tanam          : ',0,0);
        $pdf->Cell(21,8,$monthName.' -',0,0);
        $pdf->Cell(18,8,$nextmonthName,0,0);
        $pdf->Cell(10,8, $year,0,1);
        $pdf->Cell(35,8,'Dicetak tanggal     : ',0,0);
        $pdf->Cell(8,8, date('d/m/Y'),0,1);
         $pdf->Ln(5);
        $pdf->Cell(8,8,'No',1,0);
        $pdf->Cell(50,8,'Nama Sayur',1,0);
        $pdf->Cell(39,8,'Harga Jual',1,1);

        
        $no = 1;                                
        $pdf->SetFont('Arial','',8);
        foreach ($hargapokok as $a) {
        $pdf->Cell(8,8,$no,1,0);
        $pdf->Cell(50,8,$a->nama_sayur,1,0);
        $pdf->Cell(39,8,number_format($a->harga_jual),1,1);
        $no++;
        }
        $pdf->Output();
        die;
    }
}
