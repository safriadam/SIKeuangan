<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use fpdf;
use App\Http\Requests;
use App\sayuran;
use App\pengeluaran;
use App\transaksi;
use App\labarugi;
use App\harga_pokok;
use App\Http\Requests\createPengeluaran;

class PengeluaranController extends Controller
{
    public function index()
    {
       
        $pengeluaran         = pengeluaran::whereYear('masa_tanam','=', date('Y'))
                                            ->whereMonth('masa_tanam', '=', date('m'))
                                            ->paginate(20);
           
        $data['pengeluaran'] = $pengeluaran;
           
        $data['total_real']   = pengeluaran::whereYear('masa_tanam','=', date('Y'))
                                             ->whereMonth('masa_tanam', '=', date('m'))
                                             ->sum('total_realisasi');
          
        $data['saldo']       = 40000;
        $data['y']           = date('Y');
        $data['m']           = date('m');
     //    $data['saldo']      = transaksi::latest()->first();
    //     $pema               = labarugi::whereYear('created_at', '=', date('Y'))
    //                                         ->whereMonth('created_at', '=', date('m')-1)
    //                                         ->sum('pemasukan');
    //     $penge              = labarugi::whereYear('created_at', '=', date('Y'))
    //                                         ->whereMonth('created_at', '=', date('m')-1)
    //                                         ->sum('pengeluaran');                                   
    //     $data['labarugi']   = $pema - $penge;
    

            
        return view('pengeluaran.index',$data); 

    }

    public function edit($id)
    {
        $data['pengeluaran']   = pengeluaran::find($id);
        return view('pengeluaran.edit',$data);
    }

    public function update($id, createPengeluaran $request)
    {
        $data = $request->all();

        $pengeluaran = pengeluaran::find($id);      
    
        $pengeluaran->update($data);
        
        harga_pokok::create(array(  'masa_tanam'    =>$data['masa_tanam'],
                                    'sayur_id'      =>$data['sayur_id'],
                                    'nama_sayur'    =>$data['nama_sayur'],
                                    'pengeluaran_id'=>$pengeluaran->id,
                                    'pengeluaran'   =>$data['total_realisasi'],
                                    ));

        return redirect('pengeluaran');
    }

    public function create()
    {
    	return view('pengeluaran.create');
    }

    public function store(createPengeluaran $request)
    {

       	
        $sat  = $request['harga_satuan_peng']; 
        $qty  = $request['qty_peng'];
        $peng = $sat * $qty;
        $item = $request['item_pengeluaran'];
        $tgl  = $request['tanggal_transaksi'];
        $jen  = $request['jenis_peng'];
       
        $pengeluaran = pengeluaran::create(array('item_pengeluaran'=> $item,
                                                 'harga_satuan_peng'=> $sat,
                                                 'qty_peng'=>$qty,
                                                 'pengeluaran'=>$peng,
                                                 'jenis_peng'=>$jen));

        

        if($jen == 'produksi') // jika pengeluaran berjenis produksi maka di masukan ke tabel labarugi
            {
                
                $labarugi = labarugi::latest()->first();

                if($labarugi)
                {
                    $labarugi = $labarugi->labarugi - $peng;
                }
                else
                {
                    $labarugi = 0 - $peng;
                }

                $pengeluaran->labarugi()->create(array('pengeluaran'=> $peng,
                                                        'deskripsi'=>$item,
                                                        'labarugi'=>$labarugi));
            }
            else
            {
                // jika aset, maka lanjut
            }

            $saldo = transaksi::latest()->first();
        
            if ($saldo)
            {
                $saldo = $saldo->saldo - $peng;
            }
            else
            {
                $saldo = 0 - $peng;
            }

        $pengeluaran->transaksi()->create(array('deskripsi'=> $item, 'pengeluaran'=> $peng,'saldo'=>$saldo));
    
        return redirect('pengeluaran');
    }

    // public function edit($id)
    // {
    //     $data['pengeluaran'] = pengeluaran::find($id);
    //     return view('pengeluaran.edit',$data);
    // }

    // public function update($id, createPengeluaran $request)
    // {
    //     $data = $request->all();
    //     $pengeluaran = pengeluaran::find($id);
    //     $pengeluaran->update($data);
    //     return redirect('pengeluaran');
    // }

    // public function destroy ($id)
    // {
    // 	$pengeluaran = pengeluaran::find($id);
    //     $pengeluaran->delete();
    //     return redirect('pengeluaran');
    // }

    // fitur edit dan delete dimatikan demi alasan integritas data

    public function tahunBulan(request $request)
    {
        $month              = $request['masaTanam'];
        $year               = $request['year'];
        $pengeluaran        = pengeluaran::whereYear('masa_tanam', '=', $year)
                                        ->whereMonth('masa_tanam', '=', $month)
                                        ->paginate(50);
        $data['total_real'] = pengeluaran::whereYear('masa_tanam','=', $year)
                                        ->whereMonth('masa_tanam', '=', $month)
                                        ->sum('total_realisasi');
        $data['pengeluaran']= $pengeluaran;
        $data['y']          = $year;
        $data['m']          = $month;
        $data['saldo']      = 4000000;                                    
        
        //$data['saldo']      = transaksi::latest()->first();
        return view('pengeluaran.index',$data);
    }

    public function pdf(request $request)
    {
        $month              = $request['month'];
        $year               = $request['year'];
        $saldo              = transaksi::latest()->first();
        $total              = pengeluaran::whereYear('created_at','=',$year)
                                         ->whereMonth('created_at', '=', $month)
                                         ->sum('pengeluaran');
        $monthName = date("F", mktime(0, 0, 0, $month, 10));
        $pdf = new \fpdf\FPDF();
        $pdf->AddPage();
        $pdf->SetTitle('Cetak Pengeluaran');
        //headernya
                // Select Arial bold 15
            $pdf->SetFont('Arial','B',15);
            // Move to the right
            $pdf->Cell(80);
            // Framed title
            $pdf->Cell(30,10,'Sistem Informasi Keuangan ASRI 12 Kauman',0,1,'C');
            $pdf->Cell(65);
            $pdf->Cell(60,10,'Laporan Pengeluaran',1,0,'C');
            // Line break
            $pdf->Ln(20);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(38,8,'Pengeluaran Periode : ',0,0);
        $pdf->Cell(20,8, $monthName,0,0);
        $pdf->Cell(8,8, $year,0,1);
        $pdf->Cell(38,8,'Dicetak tanggal          : ',0,0);
        $pdf->Cell(8,8, date('d/m/Y'),0,1);
         $pdf->Ln(5);
        $pdf->Cell(8,8,'No',1,0);
        $pdf->Cell(18,8,'Tanggal',1,0);
        $pdf->Cell(78,8,'Item Pengeluaran',1,0);
        $pdf->Cell(25,8,'Harga Satuan',1,0);
        $pdf->Cell(15,8,'QTY',1,0);
        $pdf->Cell(25,8,'Pengeluaran',1,0);
        $pdf->Cell(20,8,'Jenis',1,1);

        $pengeluaran  = pengeluaran::whereYear('created_at', '=', $year )
                                    ->whereMonth('created_at', '=', $month )
                                    ->paginate(50); 
        $no = 1;                             
        $pdf->SetFont('Arial','',8);
        foreach ($pengeluaran as $a) {
        $pdf->Cell(8,8,$no,1,0);
        $pdf->Cell(18,8,$a->created_at->format('d-m-Y'),1,0);
        $pdf->Cell(78,8,$a->item_pengeluaran,1,0);
        $pdf->Cell(25,8,number_format($a->harga_satuan_peng),1,0);
        $pdf->Cell(15,8,$a->qty_peng,1,0);
        $pdf->Cell(25,8,number_format($a->pengeluaran),1,0);
        $pdf->Cell(20,8,$a->jenis_peng,1,1);
        $no++;
        }
        $pdf->SetFont('Arial','B',10);
        $pdf->Ln(4);
        $pdf->Cell(40,8,'Total Pengeluaran: Rp',0,0);
        $pdf->Cell(25,8, number_format($total),0,1);
        $pdf->Output();
        die;
    }
}

