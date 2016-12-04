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
        $data['y']              = date('Y');
        $data['m']              = date('m');
        $data['saldo']          = transaksi::latest()->first();
     	return view('pemasukan.index',$data);

    }

    public function create()
    {
    	return view('pemasukan.create');
    }

    public function store(createPemasukan $request)
    {
       	
    	//$data = $request->all();
        $pem  = $request['pemasukan']; 
        $des  = $request['deskripsi'];
        $tgl  = $request['tanggal_transaksi'];   
        $jen  = $request['jenis_pema'];

        $pemasukan = pemasukan::create(array('deskripsi'=> $des,
                                             'pemasukan'=>$pem,
                                             'jenis_pema'=>$jen));
        
        if($jen == 'produksi') // jika pemasukan berjenis produksi maka di masukan ke tabel labarugi
            {
                
                $labarugi = labarugi::latest()->first();

                if($labarugi)
                {
                    $labarugi = $labarugi->labarugi + $pem;
                }
                else
                {
                    $labarugi = 0 + $pem;
                }

                $pemasukan->labarugi()->create(array('deskripsi'=> $des,'pemasukan'=> $pem,'labarugi'=>$labarugi));
            }
            else
            {
                // jika aset, maka lanjut
            }

        $saldo = transaksi::latest()->first(); //untuk mengambil data terakhir pada tabel transaksi kolom saldo
       
            if ($saldo)
            {
                $saldo = $saldo->saldo + $pem;
            }
            else
            {
                $saldo = 0 + $pem;
            }

        $pemasukan->transaksi()->create(array('deskripsi'=> $des, 'pemasukan'=> $pem,'saldo'=>$saldo));
         //masukan data ke tabel transaksi
        
             

       return redirect('pemasukan');
    }

    // public function edit($id)
    // {
    //     $data['pemasukan'] = pemasukan::find($id);
    //     return view('pemasukan.edit',$data);
    // }

    // public function update($id, createPemasukan $request)
    // {
    //     $data = $request->all();
    //     $pemasukan = pemasukan::find($id);
    //     $pemasukan->update($data);
    //     return redirect('pemasukan');
    // }

    // public function destroy ($id)
    // {
    // 	$pemasukan = pemasukan::find($id);
    //     $pemasukan->delete();
    //     return redirect('pemasukan');
    // }

    // fitur edit dan delete dimatikan demi alasan integritas data

    public function tahunBulan(request $request)
    {
        $month                  = $request['month'];
        $year                   = $request['year'];
        $pemasukan              = pemasukan::whereYear('created_at', '=', $year)
                                            ->whereMonth('created_at', '=', $month)
                                            ->paginate(100);
        $data['total']          = pemasukan::whereYear('created_at','=',$year)
                                            ->whereMonth('created_at', '=', $month)
                                            ->sum('pemasukan');
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
        $saldo              = transaksi::latest()->first();
        $total              = pemasukan::whereYear('created_at','=',$year)
                                            ->whereMonth('created_at', '=', $month)
                                            ->sum('pemasukan');

        $monthName = date("F", mktime(0, 0, 0, $month, 10)); //untuk konversi nama bulan dari angka ke huruf

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
            $pdf->Cell(60,10,'Laporan Pemasukan',1,0,'C');
            // Line break
            $pdf->Ln(20);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(38,8,'Pemasukan Periode : ',0,0);
        $pdf->Cell(20,8, $monthName,0,0);
        $pdf->Cell(8,8, $year,0,1);
        $pdf->Cell(35,8,'Dicetak tanggal      : ',0,0);
        $pdf->Cell(8,8, date('d/m/Y'),0,1);
         $pdf->Ln(5);
        $pdf->Cell(8,8,'No',1,0);
        $pdf->Cell(18,8,'Tanggal',1,0);
        $pdf->Cell(90,8,'Deskripsi',1,0);
        $pdf->Cell(40,8,'Pemasukan',1,0);
        $pdf->Cell(35,8,'Jenis',1,1);

        $pemasukan  = pemasukan::whereYear('created_at', '=', $year )
                                ->whereMonth('created_at', '=', $month )
                                ->paginate(50);

        $no = 1;                             
        $pdf->SetFont('Arial','',8);
        foreach ($pemasukan as $a) {
        $pdf->Cell(8,8,$no,1,0);
        $pdf->Cell(18,8,$a->created_at->format('d-m-Y'),1,0);
        $pdf->Cell(90,8,$a->deskripsi,1,0);
        $pdf->Cell(40,8,number_format($a->pemasukan),1,0);
        $pdf->Cell(35,8,$a->jenis_pema,1,1);
        $no++;
        }
        $pdf->SetFont('Arial','B',10);
        $pdf->Ln(4);
        $pdf->Cell(38,8,'Total Pemasukan: Rp',0,0);
        $pdf->Cell(25,8, number_format($total),0,1);
        $pdf->Output();
        die;
    }
}
