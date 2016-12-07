<?php

namespace App\Http\Controllers;



use fpdf;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\anggaran;
use App\pengeluaran;
use App\sayuran;
use App\transaksi;
use App\labarugi;
use App\Http\Requests\createAnggaran;


class AnggaranController extends Controller
{
    public function index()
    {

  		   $anggaran = anggaran::whereYear('masa_tanam','=', date('Y'))
                               ->whereMonth('masa_tanam', '=', date('m'))
                               ->paginate(20);
           $data['anggaran']   = $anggaran;
           
           $data['total_ang']  = anggaran::whereYear('masa_tanam','=', date('Y'))
                                            ->whereMonth('masa_tanam', '=', date('m'))
                                            ->sum('tot_anggaran');
           $data['y']          = date('Y');
           $data['m']          = date('m');
           $data['saldo']      = transaksi::latest()->first();
    //     $pema               = labarugi::whereYear('created_at', '=', date('Y'))
    //                                         ->whereMonth('created_at', '=', date('m')-1)
    //                                         ->sum('pemasukan');
    //     $penge              = labarugi::whereYear('created_at', '=', date('Y'))
    //                                         ->whereMonth('created_at', '=', date('m')-1)
    //                                         ->sum('pengeluaran');                                   
    //     $data['labarugi']   = $pema - $penge;
    

            
        return view('anggaran.index',$data);  

    }
    public function create()
    {      
        $data['y']          = date('Y');
        $data['m']          = date('m');
        $sayuran            = sayuran::lists('nama_sayur','id');
        $data['sayuran']    = $sayuran;
    	return view('anggaran.create',$data);
    }

    public function store(createAnggaran $request)
    {
        
        $year           = $request['year'];
        $mastam         = $request['masaTanam'];
        $masa_tanam     = $year.'-'.$mastam.'-'.date('d'); 
        $sayur          = $request['nama_sayur'];
        $nama_sayur     = sayuran::where('id', $sayur)->value('nama_sayur');
        $bibit          = $request['bibit'];
        $ket_bibit      = $request['ket_bibit'];
    	$nutrisi        = $request['nutrisi'];
        $ket_nutrisi    = $request['ket_nutrisi']; 
        $bahan_lain     = $request['bahan_lain'];
        $ket_bahan_lain = $request['ket_bahan_lain'];
        $tot_anggaran   = $request['tot_anggaran'];

        Anggaran::create(array( 'masa_tanam'    =>$masa_tanam,
                                'sayur_id'      =>$sayur,
                                'nama_sayur'    =>$nama_sayur,
                                'bibit'         =>$bibit,
                                'ket_bibit'     =>$ket_bibit,
                                'nutrisi'       =>$nutrisi,
                                'ket_nutrisi'   =>$ket_nutrisi,
                                'bahan_lain'    =>$bahan_lain,
                                'ket_bahan_lain'=>$ket_bahan_lain,
                                'tot_anggaran'  =>$tot_anggaran));
        


        $insertedId    = anggaran::latest()->first()->id; //untuk mengambil id terakhir yang terisi di anggaran.

        pengeluaran::create(array(  'masa_tanam'    =>$masa_tanam,
                                    'id_sayur'      =>$sayur,
                                    'nama_sayur'    =>$nama_sayur,
                                    'ang_bibit'     =>$bibit,
                                    'ang_nutrisi'   =>$nutrisi,
                                    'ang_bahan_lain'=>$bahan_lain,
                                    'id_anggaran'   =>$insertedId,
                                    'anggaran_total'=>$tot_anggaran,));  
    
        return redirect('anggaran');
    }


    public function update($id, createAnggaran $request)
    {
        $data = $request->all();
        $anggaran = anggaran::find($id);
        $anggaran->update($data);
        return redirect('anggaran');
    }

    public function edit($id)
    {
        $data['anggaran']   = anggaran::find($id);
        return view('anggaran.detail',$data);
    }

    public function destroy ($id)
    {
    	$anggaran = anggaran::find($id);
        $anggaran->delete();
        return redirect('anggaran');
    }

    public function search(request $request)
    {
        $keyword            = $request['keyword'];
        $anggaran           = anggaran::where('nama_item_anggaran', 'LIKE', '%'.$keyword.'%')->paginate(15);
        $data['saldo']      = transaksi::latest()->first();
        $data['anggaran']   = $anggaran;
        $data['y']          = date('Y');
        $data['m']          = date('m');
        return view('anggaran.index',$data);
    }
    
    public function tahunBulan(request $request)
    {

        
        
        $month              = $request['masaTanam'];
        $year               = $request['year'];
        $anggaran           = anggaran::whereYear('masa_tanam', '=', $year)
                                        ->whereMonth('masa_tanam', '=', $month)
                                        ->paginate(50);
        $data['total_ang']   = anggaran::whereYear('masa_tanam','=', $year)
                                        ->whereMonth('masa_tanam', '=', $month)
                                        ->sum('tot_anggaran');
        $data['anggaran']   = $anggaran;
        $data['y']          = $year;
        $data['m']          = $month;
        $data['saldo']      = 4000000;   //transaksi::latest()->first();
        // $pema               = labarugi::whereYear('created_at', '=', $year)
        //                                     ->whereMonth('created_at', '=', $month-1)
        //                                     ->sum('pemasukan');
        // $penge              = labarugi::whereYear('created_at', '=', $year)
        //                                     ->whereMonth('created_at', '=', $month-1)
        //                                     ->sum('pengeluaran');                                   
        //$data['labarugi']   = $pema - $penge;
        //$data['totalmod']   = anggaran::whereYear('periode','=',$year)
        //                                    ->whereMonth('periode', '=',$month)
        //                                   ->sum('anggaran');
        
        return view('anggaran.index',$data);
    }

    public function pdf(request $request)
    {
        $month              = $request['month'];
        $year               = $request['year'];
        $totalmod           = anggaran::whereYear('periode','=',$year)
                                            ->whereMonth('periode', '=', $month)
                                            ->sum('anggaran');
        $monthName = date("F", mktime(0, 0, 0, $month, 10));
        $pdf = new \fpdf\FPDF();
        $pdf->AddPage();
        $pdf->SetTitle('Cetak Belanja Modal');
        //headernya
                // Select Arial bold 15
            $pdf->SetFont('Arial','B',15);
            // Move to the right
            $pdf->Cell(80);
            // Framed title
            $pdf->Cell(30,10,'Sistem Informasi Keuangan ASRI 12 Kauman',0,1,'C');
            $pdf->Cell(65);
            $pdf->Cell(60,10,'Belanja Modal',1,0,'C');
            // Line break
            $pdf->Ln(20);
                
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(35,8,'Periode                  : ',0,0);
        $pdf->Cell(20,8, $monthName,0,0);
        $pdf->Cell(8,8, $year,0,1);
        $pdf->Cell(35,8,'Dicetak tanggal     : ',0,0);
        $pdf->Cell(8,8, date('d/m/Y'),0,1);
         $pdf->Ln(5);
        $pdf->Cell(8,8,'No',1,0);
        $pdf->Cell(30,8,'Periode',1,0);
        $pdf->Cell(65,8,'Nama Item',1,0);
        $pdf->Cell(30,8,'Harga Satuan',1,0);
        $pdf->Cell(20,8,'QTY',1,0);
        $pdf->Cell(25,8,'Anggaran',1,1);

        $anggaran  = anggaran::whereYear('periode', '=', $year )
                             ->whereMonth('periode', '=', $month )
                             ->paginate(50);
        $no = 1;                                
        $pdf->SetFont('Arial','',8);
        foreach ($anggaran as $a) {
        $pdf->Cell(8,8,$no,1,0);
        $pdf->Cell(30,8,$a->periode,1,0);
        $pdf->Cell(65,8,$a->nama_item_anggaran,1,0);
        $pdf->Cell(30,8,number_format($a->harga_satuan),1,0);
        $pdf->Cell(20,8,$a->qty,1,0);
        $pdf->Cell(25,8,number_format($a->anggaran),1,1);
        $no++;
        }
        $pdf->SetFont('Arial','B',10);
        $pdf->Ln(4);
        $pdf->Cell(30,8,'Total Belanja: Rp',0,0);
        $pdf->Cell(25,8, number_format($totalmod),0,1);
        $pdf->Output();
        die;
    }

}
