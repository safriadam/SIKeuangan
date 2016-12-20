<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use fpdf;
use App\Http\Requests;
use App\sayuran;
use App\pengeluaran;
use App\pemasukan;
use App\transaksi;
use App\labarugi;
use App\harga_pokok;
use App\Http\Requests\createPengeluaran;
use Cartalyst\Alerts\Native\Facades\Alert;
use Validator;

class PengeluaranController extends Controller
{
    public function index()
    {
       
        $pengeluaran          = pengeluaran::whereYear('masa_tanam','=', date('Y'))
                                            ->whereMonth('masa_tanam', '=', date('m'))
                                            ->paginate(20);
           
        $data['pengeluaran']  = $pengeluaran;
           
        $data['total_real']   = pengeluaran::whereYear('masa_tanam','=', date('Y'))
                                             ->whereMonth('masa_tanam', '=', date('m'))
                                             ->sum('total_realisasi');
        $data['y']           = date('Y');
        $data['m']           = date('m');
        $data['saldo']       = transaksi::latest()->first();
            
        return view('pengeluaran.index',$data); 

    }

    public function edit($id)
    {
        $data['pengeluaran']   = pengeluaran::find($id);
        return view('pengeluaran.edit',$data);
    }

    public function detail($id)
    {
        $data['pengeluaran']   = pengeluaran::find($id);
        return view('pengeluaran.detail',$data);
    }

    public function update($id, createPengeluaran $request)
    {
        $data = $request->all();

        $pengeluaran = pengeluaran::find($id);      

        $saldo = transaksi::latest()->first();
        
            if ($saldo)
            {
                $saldo = $saldo->saldo - $data['total_realisasi'];

                if($saldo>0)
                {
                    $pengeluaran->update($data);
        
                    harga_pokok::create(array(  'masa_tanam'    =>$data['masa_tanam'],
                                                'sayur_id'      =>$data['sayur_id'],
                                                'nama_sayur'    =>$data['nama_sayur'],
                                                'pengeluaran_id'=>$pengeluaran->id,
                                                'pengeluaran'   =>$data['total_realisasi'],
                                                ));

                    pemasukan::create(array(    'masa_tanam'    =>$data['masa_tanam'],
                                                'id_sayur'      =>$data['sayur_id'],
                                                'nama_sayur'    =>$data['nama_sayur'],
                                                ));

                    transaksi::create(array(    'tgl_transaksi' =>$data['masa_tanam'],
                                                'deskripsi'     =>'Belanja modal sayur '.$data['nama_sayur'],
                                                'pengeluaran_id'=>$pengeluaran->id,
                                                'pengeluaran'   =>$data['total_realisasi'],
                                                'saldo'         =>$saldo,
                                                ));

                    labarugi::create(array(     'periode'       =>$data['masa_tanam'],
                                                'deskripsi'     =>'Belanja modal sayur '.$data['nama_sayur'],
                                                'realisasi_id'  =>$pengeluaran->id,
                                                'pengeluaran'   =>$data['total_realisasi'],
                                                ));
                }
                else
                {
                    \Flash::error('Maaf saldo tidak cukup untuk realisasi');
                    return redirect('pengeluaran');
                }

            }
            else
            {
                \Flash::error('Maaf saldo tidak cukup untuk realisasi');
                return redirect('pengeluaran');
            }
        



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
        $data['saldo']      = transaksi::latest()->first();
        return view('pengeluaran.index',$data);
    }

    public function pdf(request $request)
    {
        $month              = $request['month'];
        $year               = $request['year'];
        $totalreal         = pengeluaran::whereYear('masa_tanam','=',$year)
                                        ->whereMonth('masa_tanam', '=', $month)
                                        ->sum('total_realisasi');

        $pengeluaran        = pengeluaran::whereYear('masa_tanam', '=', $year )
                                         ->whereMonth('masa_tanam', '=', $month )
                                         ->paginate(50);

        $monthName = date("F", mktime(0, 0, 0, $month, 1));
        $operation = $month+2;
        $nextmonthName = date("F", mktime(0, 0, 0, $operation, 1));

        $pdf = new \fpdf\FPDF();
        $pdf->AddPage();
        $pdf->SetTitle('Cetak Realisasi');
        //headernya
                // Select Arial bold 15
            $pdf->SetFont('Arial','B',15);
            // Move to the right
            $pdf->Cell(80);
            // Framed title
            $pdf->Cell(30,10,'Sistem Informasi Keuangan ASRI 12 Kauman',0,1,'C');
            $pdf->Cell(65);
            $pdf->Cell(60,10,'REALISASI',1,0,'C');
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
        $pdf->Cell(27,8,'Realisasi Bibit',1,0);
        $pdf->Cell(27,8,'Real. Nutrisi',1,0);
        $pdf->Cell(30,8,'Real.Bahan Lain',1,0);
        $pdf->Cell(39,8,'Total Realisasi',1,1);

        
        $no = 1;                                
        $pdf->SetFont('Arial','',8);
        foreach ($pengeluaran as $a) {
        $pdf->Cell(8,8,$no,1,0);
        $pdf->Cell(50,8,$a->nama_sayur,1,0);
        $pdf->Cell(27,8,number_format($a->real_bibit),1,0);
        $pdf->Cell(27,8,number_format($a->real_nutrisi),1,0);
        $pdf->Cell(30,8,number_format($a->real_bahan_lain),1,0);
        $pdf->Cell(39,8,number_format($a->total_realisasi),1,1);
        $no++;
        }
        $pdf->SetFont('Arial','B',10);
        $pdf->Ln(4);
        $pdf->Cell(35,8,'Total Realisasi: Rp',0,0);
        $pdf->Cell(25,8, number_format($totalreal),0,1);
        $pdf->Output();
        die;
        }
}

