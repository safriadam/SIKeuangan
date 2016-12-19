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
use App\bibit;
use App\nutrisi;
use App\bahan_lain;
use App\Http\Requests\createAnggaran;
use Carbon\Carbon;
use Cartalyst\Alerts\Native\Facades\Alert;
use DateTime;

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
           $saldomt            = anggaran::latest()
                                            ->whereMonth('masa_tanam', '=', date('m'))
                                            ->whereYear('masa_tanam', '=', date('Y'))
                                            ->first();
           $data['saldomt']    = $saldomt;  
           $data['y']          = date('Y');
           $data['m']          = date('m');
           $data['saldo']      = transaksi::latest()->first();

           if ($data['total_ang'] > $data['saldo']->saldo) {
               flash('peringatan ! Anggaran melebihi saldo saat ini','danger');
                //\Flash::error('peringatan ! Anggaran melebihi saldo saat ini');
           }
            
        return view('anggaran.index',$data);  

    }
    public function create()
    {      
        $data['y']          = date('Y');
        $data['m']          = date('m');
        $sayuran            = sayuran::lists('nama_sayur','id');
        $bibit              = bibit::lists('nama_bibit','id');
        $nutrisi            = Nutrisi::lists('nama_nutrisi','id');
        $bahan_lain         = bahan_lain::lists('nama_bahan_lain','id');
        $data['sayuran']    = $sayuran;
        $data['listbibit']  = $bibit;
        $data['listnutrisi']= $nutrisi;
        $data['listbahan']  = $bahan_lain;
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
        $id_bibit       = $request['nama_bibit'];
        $nama_bibit     = bibit::where('id', $id_bibit)->value('nama_bibit');
        $ket_bibit      = $request['ket_bibit'];
    	$nutrisi        = $request['nutrisi'];
        $id_nutrisi     = $request['nama_nutrisi'];
        $nama_nutrisi   = nutrisi::where('id', $id_nutrisi)->value('nama_nutrisi');
        $ket_nutrisi    = $request['ket_nutrisi']; 
        $bahan_lain     = $request['bahan_lain'];
        $id_bahan_lain  = $request['nama_bahan_lain'];
        $nama_bahan_lain= bahan_lain::where('id', $id_bahan_lain)->value('nama_bahan_lain');
        $ket_bahan_lain = $request['ket_bahan_lain'];
        $tot_anggaran   = $request['tot_anggaran'];

        Anggaran::create(array( 'masa_tanam'    =>$masa_tanam,
                                'sayur_id'      =>$sayur,
                                'nama_sayur'    =>$nama_sayur,
                                'bibit'         =>$bibit,
                                'ket_bibit'     =>$nama_bibit.' ('.$ket_bibit.')',
                                'nutrisi'       =>$nutrisi,
                                'ket_nutrisi'   =>$nama_nutrisi.' ('.$ket_nutrisi.')',
                                'bahan_lain'    =>$bahan_lain,
                                'ket_bahan_lain'=>$nama_bahan_lain.'('.$ket_bahan_lain.')',
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
        $saldomt            = anggaran::latest()
                                            ->whereMonth('masa_tanam', '=', $month)
                                            ->whereYear('masa_tanam', '=', $year)
                                            ->first();
        $data['saldomt']    = $saldomt;                                
        $data['anggaran']   = $anggaran;
        $data['y']          = $year;
        $data['m']          = $month;
        $data['saldo']      = transaksi::latest()->first();

        if ($data['total_ang'] > $data['saldo']->saldo) {
               
               flash('peringatan ! Anggaran melebihi saldo saat ini','danger');
                //\Flash::error('peringatan ! Anggaran melebihi saldo saat ini');
           }

        return view('anggaran.index',$data);
      
    }

    public function pdf(request $request)
    {
        $month              = $request['month'];
        $year               = $request['year'];
        $totalang           = anggaran::whereYear('masa_tanam','=',$year)
                                        ->whereMonth('masa_tanam', '=', $month)
                                        ->sum('tot_anggaran');

        $anggaran           = anggaran::whereYear('masa_tanam', '=', $year )
                                         ->whereMonth('masa_tanam', '=', $month )
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
            $pdf->Cell(60,10,'ANGGARAN',1,0,'C');
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
        $pdf->Cell(27,8,'Bibit',1,0);
        $pdf->Cell(27,8,'Nutrisi',1,0);
        $pdf->Cell(30,8,'Bahan Lain',1,0);
        $pdf->Cell(39,8,'Total Anggaran',1,1);

        
        $no = 1;                                
        $pdf->SetFont('Arial','',8);
        foreach ($anggaran as $a) {
        $pdf->Cell(8,8,$no,1,0);
        $pdf->Cell(50,8,$a->nama_sayur,1,0);
        $pdf->Cell(27,8,number_format($a->bibit),1,0);
        $pdf->Cell(27,8,number_format($a->nutrisi),1,0);
        $pdf->Cell(30,8,number_format($a->bahan_lain),1,0);
        $pdf->Cell(39,8,number_format($a->tot_anggaran),1,1);
        $no++;
        }
        $pdf->SetFont('Arial','B',10);
        $pdf->Ln(4);
        $pdf->Cell(35,8,'Total Anggaran: Rp',0,0);
        $pdf->Cell(25,8, number_format($totalang),0,1);
        $pdf->Output();
        die;
    }

}
