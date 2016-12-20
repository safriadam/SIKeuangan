<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use fpdf;
use App\pemasukan;
use App\transaksi;
use App\labarugi;
use App\Http\Requests\createPemasukan;

class PemasukanController extends Controller
{
    public function index()
    {
  		$pemasukan              = pemasukan::whereYear('created_at', '=', date('Y'))
                                            ->whereMonth('created_at', '=',date('m'))
                                            ->paginate(40);
        $data['total']          = pemasukan::whereYear('created_at','=',date('Y'))
                                            ->whereMonth('created_at', '=', date('m'))
                                            ->sum('pemasukan');                                     
        $data['pemasukan']    	= $pemasukan;
        $saldomt                = pemasukan::latest()
                                            ->whereMonth('masa_tanam', '=', date('m'))
                                            ->whereYear('masa_tanam', '=', date('Y'))
                                            ->first();
        $data['saldomt']        = $saldomt;                                    
        $data['saldo']          = transaksi::latest()->first();
        $data['y']              = date('Y');
        $data['m']              = date('m');
     	return view('pemasukan.index',$data);

    }

    public function create()
    {
    	return view('pemasukan.create');
    }

    public function store(createPemasukan $request)
    {
       	
    	$data       = $request->all(); 
        $pemasukan  = pemasukan::create($data);
        $pemasukan  = pemasukan::latest()->first()->id;
        $saldo      = transaksi::latest()->first();  
        $saldo      = $saldo->saldo + $data['pemasukan'];

        transaksi::create(array(    'tgl_transaksi' =>$data['masa_tanam'],
                                    'deskripsi'     =>'['.$data['jenis_pema'].'] '.$data['keterangan'],
                                    'pemasukan_id'  =>$pemasukan,
                                    'pemasukan'     =>$data['pemasukan'],
                                    'saldo'         =>$saldo,
                                ));

       return redirect('pemasukan');
    }

    public function edit($id)
    {
        $data['pemasukan']   = pemasukan::find($id);
        return view('pemasukan.edit',$data);
    }

    public function update($id, createPemasukan $request)
    {
        $data = $request->all();

        $pemasukan = pemasukan::find($id);

        $saldo = transaksi::latest()->first();

        $saldo = $saldo->saldo + $data['pemasukan'];

        transaksi::create(array(    'tgl_transaksi' =>$data['masa_tanam'],
                                    'deskripsi'     =>'Hasil penjualan sayur '.$data['nama_sayur'],
                                    'pemasukan_id'  =>$pemasukan->id,
                                    'pemasukan'     =>$data['pemasukan'],
                                    'saldo'         =>$saldo,                                
                                ));

        labarugi::create(array(     'periode'       =>$data['masa_tanam'],
                                    'deskripsi'     =>'Hasil penjualan sayur '.$data['nama_sayur'],
                                    'pemasukan_id'  =>$pemasukan->id,
                                    'pemasukan'     =>$data['pemasukan'],
                                    ));
        $pemasukan->update($data);
        
        return redirect('pemasukan');
    }

    public function tahunBulan(request $request)
    {
        $month                  = $request['masaTanam'];
        $year                   = $request['year'];
        $pemasukan              = pemasukan::whereYear('masa_tanam', '=', $year)
                                            ->whereMonth('masa_tanam', '=', $month)
                                            ->paginate(100);
        $data['total']          = pemasukan::whereYear('masa_tanam','=',$year)
                                            ->whereMonth('masa_tanam', '=', $month)
                                            ->sum('pemasukan');
        $saldomt                = pemasukan::latest()
                                            ->whereMonth('masa_tanam', '=', $month)
                                            ->whereYear('masa_tanam', '=', $year)
                                            ->first();
        if ($saldomt){

            $data['saldomt']        = $saldomt;
        }
        else {

            return redirect('laporan/bulanan/tahunBulan/kosong');
            die;
        }
        $data['pemasukan']      = $pemasukan;
        $data['y']              = $year;
        $data['m']              = $month;
        $data['saldo']          = transaksi::latest()->first();
        return view('pemasukan.index',$data);
    }

    public function pdf(request $request)
    {
        $month              = $request['month'];
        $year               = $request['year'];
        $totalpem           = pemasukan::whereYear('masa_tanam','=',$year)
                                        ->whereMonth('masa_tanam', '=', $month)
                                        ->where('jenis_pema','=', 'PENJUALAN')
                                        ->sum('pemasukan');

        $pemasukan          = pemasukan::whereYear('masa_tanam', '=', $year )
                                         ->whereMonth('masa_tanam', '=', $month )
                                         ->where('jenis_pema','=', 'PENJUALAN')
                                         ->paginate(50);

        $nonjual            = pemasukan::whereYear('masa_tanam', '=', $year )
                                         ->whereMonth('masa_tanam', '=', $month )
                                         ->where('jenis_pema','!=', 'PENJUALAN')
                                         ->paginate(50);

        $totalnonjual       = pemasukan::whereYear('masa_tanam','=',$year)
                                        ->whereMonth('masa_tanam', '=', $month)
                                        ->where('jenis_pema','!=', 'PENJUALAN')
                                        ->sum('pemasukan');

        $monthName = date("F", mktime(0, 0, 0, $month, 1));
        $operation = $month+2;
        $nextmonthName = date("F", mktime(0, 0, 0, $operation, 1));

        $pdf = new \fpdf\FPDF();
        $pdf->AddPage();
        $pdf->SetTitle('Cetak Pemasukan');
        //headernya
                // Select Arial bold 15
            $pdf->SetFont('Arial','B',15);
            // Move to the right
            $pdf->Cell(80);
            // Framed title
            $pdf->Cell(30,10,'Sistem Informasi Keuangan ASRI 12 Kauman',0,1,'C');
            $pdf->Cell(65);
            $pdf->Cell(60,10,'Pemasukan',1,0,'C');
            // Line break
            $pdf->Ln(20);
                
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(35,8,'Pemasukan Hasil Penjualan',0,1);
        $pdf->Cell(35,8,'Masa Tanam          : ',0,0);
        $pdf->Cell(21,8,$monthName.' -',0,0);
        $pdf->Cell(18,8,$nextmonthName,0,0);
        $pdf->Cell(10,8, $year,0,1);
        $pdf->Cell(35,8,'Dicetak tanggal     : ',0,0);
        $pdf->Cell(8,8, date('d/m/Y'),0,1);
         $pdf->Ln(5);
        $pdf->Cell(8,8,'No',1,0);
        $pdf->Cell(50,8,'Nama Sayur',1,0);
        $pdf->Cell(80,8,'Keterangan',1,0);
        $pdf->Cell(39,8,'Pemasukan',1,1);

        
        $no = 1;                                
        $pdf->SetFont('Arial','',8);
        foreach ($pemasukan as $a) {
        $pdf->Cell(8,8,$no,1,0);
        $pdf->Cell(50,8,$a->nama_sayur,1,0);
        $pdf->Cell(80,8,$a->keterangan,1,0);
        $pdf->Cell(39,8,number_format($a->pemasukan),1,1);
        $no++;
        }
        $pdf->SetFont('Arial','B',10);
        $pdf->Ln(4);
        $pdf->Cell(40,8,'Total Pemasukan: Rp',0,0);
        $pdf->Cell(25,8, number_format($totalpem),0,1);

         $pdf->Ln(5);
         $pdf->Cell(35,8,'Pemasukan Non-Penjualan',0,1);
        $pdf->Cell(8,8,'No',1,0);
        $pdf->Cell(50,8,'Tanggal Transaksi',1,0);
        $pdf->Cell(80,8,'Keterangan',1,0);
        $pdf->Cell(39,8,'Pemasukan',1,1);

        $no = 1;                                
        $pdf->SetFont('Arial','',8);
        foreach ($nonjual as $a) {
        $pdf->Cell(8,8,$no,1,0);
        $pdf->Cell(50,8,$a->masa_tanam,1,0);
        $pdf->Cell(80,8,$a->keterangan,1,0);
        $pdf->Cell(39,8,number_format($a->pemasukan),1,1);
        $no++;
        }
        $pdf->SetFont('Arial','B',10);
        $pdf->Ln(4);
        $pdf->Cell(40,8,'Total Pemasukan: Rp',0,0);
        $pdf->Cell(25,8, number_format($totalnonjual),0,1);

        $pdf->Output();
        die;
    }
}
