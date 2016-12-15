<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use fpdf;
use App\pengeluaran;
use App\pemasukan;
use App\transaksi;
use App\labarugi;
use App\Http\Requests;
use App\Http\Requests\createHarga;

class LaporanController extends Controller
{
    public function index()
    {
    	return view('laporan.index');

    } 

    public function labarugi()

    {
        $data['y']              = date('Y');
        $data['m']              = date('m');
        $labarugi               = labarugi::whereYear('periode', '=', date('Y'))
                                            ->whereMonth('periode', '=', date('m'))
                                            ->paginate(40);
        $pema                   = labarugi::whereYear('periode', '=', date('Y'))
                                            ->whereMonth('periode', '=', date('m'))
                                            ->sum('pemasukan');
        $penge                  = labarugi::whereYear('periode', '=', date('Y'))
                                            ->whereMonth('periode', '=', date('m'))
                                            ->sum('pengeluaran');
        $data['saldo']          = transaksi::latest()->first();                                   
        $data['labarugi']       = $pema - $penge;
        $data['laba_rugi']      = $labarugi;
    
        return view('laporan.labarugi',$data);
    }

    public function bulanan()
    {
        $data['y']              = date('Y');
        $data['m']              = date('m');
        $bulanan                = transaksi::whereYear('tgl_transaksi', '=', date('Y'))
                                            ->whereMonth('tgl_transaksi', '=', date('m'))
                                            ->paginate(40);
        $saldomt                  = transaksi::latest()
                                            ->whereMonth('tgl_transaksi', '=', date('m'))
                                            ->whereYear('tgl_transaksi', '=', date('Y'))
                                            ->first();
       
        $data['saldomt']        = $saldomt;                                    
        $data['saldo']          = transaksi::latest()->first();
        $data['transaksi']      = $bulanan;
        return view('laporan.bulanan',$data);
    }

    public function bulananpdf(request $request)
    {
        $month              = $request['month'];
        $year               = $request['year'];
        $saldo              = transaksi::latest()->first();

        $monthName = date("F", mktime(0, 0, 0, $month, 10));
        $pdf = new \fpdf\FPDF();
        $pdf->AddPage();
        $pdf->SetTitle('Cetak Laporan Bulanan');
        //headernya
                // Select Arial bold 15
            $pdf->SetFont('Arial','B',15);
            // Move to the right
            $pdf->Cell(80);
            // Framed title
            $pdf->Cell(30,10,'Sistem Informasi Keuangan ASRI 12 Kauman',0,1,'C');
            $pdf->Cell(55);
            $pdf->Cell(80,10,'Laporan Keuangan Bulanan',1,0,'C');
            // Line break
            $pdf->Ln(20);
                
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(48,8,'Laporan Bulanan Periode : ',0,0);
        $pdf->Cell(20,8, $monthName,0,0);
        $pdf->Cell(8,8, $year,0,1);
        $pdf->Cell(35,8,'Dicetak tanggal     : ',0,0);
        $pdf->Cell(8,8, date('d/m/Y'),0,1);
        $pdf->Cell(35,8,'Saldo Saat ini : Rp',0,0);
        $pdf->Cell(40,8, number_format($saldo->saldo),0,1);
            $pdf->Ln(5);
        $pdf->Cell(8,8,'No',1,0);
        $pdf->Cell(18,8,'Tanggal',1,0);
        $pdf->Cell(90,8,'Deskripsi',1,0);
        $pdf->Cell(25,8,'Pemasukan',1,0);
        $pdf->Cell(25,8,'Pengeluaran',1,0);
        $pdf->Cell(25,8,'Saldo',1,1);

        $transaksi          = transaksi::whereYear('tgl_transaksi', '=', $year )
                              ->whereMonth('tgl_transaksi', '=', $month )
                              ->paginate(80);
        $totpema            = transaksi::whereYear('tgl_transaksi', '=', $year )
                              ->whereMonth('tgl_transaksi', '=', $month )
                              ->sum('pemasukan');
        $totpeng            = transaksi::whereYear('tgl_transaksi', '=', $year )
                              ->whereMonth('tgl_transaksi', '=', $month )
                              ->sum('pengeluaran');
        $saldomt            = transaksi::latest()
                              ->whereMonth('tgl_transaksi', '=', $month)
                              ->whereYear('tgl_transaksi', '=', $year )
                              ->first();                      
        $no = 1;                             
        $pdf->SetFont('Arial','',8);
        foreach ($transaksi as $a) {
        $pdf->Cell(8,8,$no,1,0);
        $pdf->Cell(18,8,$a->tgl_transaksi->format('d-m-Y'),1,0);
        $pdf->Cell(90,8,$a->deskripsi,1,0);
        $pdf->Cell(25,8,number_format($a->pemasukan),1,0);
        $pdf->Cell(25,8,number_format($a->pengeluaran),1,0);
        $pdf->Cell(25,8,number_format($a->saldo),1,1);
        $no++;
        }
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(116,8,'TOTAL',1,0);
        $pdf->Cell(25,8,number_format($totpema),1,0);
        $pdf->Cell(25,8,number_format($totpeng),1,1);
        
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(23,8,'Saldo Peride ',0,0);
        $pdf->Cell(20,8, $monthName.':',0,0);
        $pdf->Cell(8,8,' Rp '.number_format($saldomt->saldo),0,1);
        $pdf->Output();
        die;
    }

    public function tahunBulan(request $request)
    {
        $month                  = $request['month'];
        $year                   = $request['year'];
        $bulanan                = transaksi::whereYear('tgl_transaksi', '=', $year)
                                            ->whereMonth('tgl_transaksi', '=', $month)
                                            ->paginate(40);
        $saldomt                = transaksi::latest()
                                            ->whereMonth('tgl_transaksi', '=', $month)
                                            ->whereYear('tgl_transaksi', '=', $year)
                                            ->first();
         if ($saldomt){

            $data['saldomt']        = $saldomt;
        }
        else {

            return redirect('laporan/bulanan/tahunBulan/kosong');
            die;
        }

        $data['transaksi']      = $bulanan;
        $data['y']              = $year;
        $data['m']              = $month;
        $data['saldo']          = transaksi::latest()->first();
        return view('laporan.bulanan',$data);
    }

    public function labarugiBulanan(request $request)
    {
        $month                  = $request['masaTanam'];
        $year                   = $request['year'];
        $bulanan                = labarugi::whereYear('periode', '=', $year)
                                            ->whereMonth('periode', '=', $month)
                                            ->paginate(40);
        $pema                   = labarugi::whereYear('periode', '=', $year)
                                            ->whereMonth('periode', '=', $month)
                                            ->sum('pemasukan');          // menjumlahkan pemasukan
        $penge                  = labarugi::whereYear('periode', '=',$year)  
                                            ->whereMonth('periode', '=',$month)
                                            ->sum('pengeluaran');      // menjumlahkan pengeluaran                          
        $data['labarugi']       = $pema - $penge; //untuk mengisi form laba rugi dan rumus laba rugi
        $data['y']              = $year;
        $data['saldo']          = transaksi::latest()->first();
        $data['m']              = $month;
        $data['laba_rugi']      = $bulanan;
        return view('laporan.labarugi',$data);
    }

    public function labarugipdf(request $request)
    {
        $month              = $request['month'];
        $year               = $request['year'];

        $monthName = date("F", mktime(0, 0, 0, $month, 1));
        $operation = $month+2;
        $nextmonthName = date("F", mktime(0, 0, 0, $operation, 1));

        $labarugi               = labarugi::whereYear('created_at', '=', $year)
                                            ->whereMonth('created_at', '=', $month)
                                            ->paginate(50);
        $pema                   = labarugi::whereYear('created_at', '=', $year)
                                            ->whereMonth('created_at', '=', $month)
                                            ->sum('pemasukan');          // menjumlahkan pemasukan
        $penge                  = labarugi::whereYear('created_at', '=',$year)  
                                            ->whereMonth('created_at', '=',$month)
                                            ->sum('pengeluaran');      // menjumlahkan pengeluaran                          
        $laba_rugi               = $pema - $penge;

        $pdf = new \fpdf\FPDF();
        $pdf->AddPage();
        $pdf->SetTitle('Cetak Laporan Laba-rugi');
        //headernya
                // Select Arial bold 15
            $pdf->SetFont('Arial','B',15);
            // Move to the right
            $pdf->Cell(80);
            // Framed title
            $pdf->Cell(30,10,'Sistem Informasi Keuangan ASRI 12 Kauman',0,1,'C');
            $pdf->Cell(65);
            $pdf->Cell(60,10,'Laporan Laba-Rugi',1,0,'C');
            // Line break
            $pdf->Ln(20);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(36,8,'Masa Tanam           : ',0,0);
        $pdf->Cell(21,8,$monthName.' -',0,0);
        $pdf->Cell(18,8,$nextmonthName,0,0);
        $pdf->Cell(8,8, $year,0,1);
        $pdf->Cell(35,8,'Dicetak tanggal      : ',0,0);
        $pdf->Cell(8,8, date('d/m/Y'),0,1);
         $pdf->Ln(5);
        $pdf->Cell(8,8,'No',1,0);
        $pdf->Cell(18,8,'Tanggal',1,0);
        $pdf->Cell(90,8,'Deskripsi',1,0);
        $pdf->Cell(35,8,'Pemasukan',1,0);
        $pdf->Cell(35,8,'Pengeluaran',1,1);

        $no = 1;                             
        $pdf->SetFont('Arial','',8);
        foreach ($labarugi as $a) {
        $pdf->Cell(8,8,$no,1,0);
        $pdf->Cell(18,8,$a->created_at->format('d-m-Y'),1,0);
        $pdf->Cell(90,8,$a->deskripsi,1,0);
        $pdf->Cell(35,8,number_format($a->pemasukan),1,0);
        $pdf->Cell(35,8,number_format($a->pengeluaran),1,1);
        $no++;
        }
        $pdf->SetFont('Arial','B',10);
        $pdf->Ln(4);
        $pdf->Cell(27,8,'Laba-Rugi: Rp',0,0);
        $pdf->Cell(25,8, number_format($laba_rugi),0,1);
        $pdf->Output();
        die;
    }

    public function harga(request $request)
    {
        $data['y']                  = date('Y');
        $data['m']                  = date('m');
        $pengeluaran_prod           = labarugi::whereYear('created_at', '=', date('Y'))
                                                ->whereMonth('created_at', '=', date('m'))
                                                ->sum('pengeluaran');
        $data['pengeluaran_prod']   = $pengeluaran_prod; 
        $data['hasil_panen']        = null;
        $data['hasil']              = null;
        $data['margin']             = null;

        return view('laporan.harga',$data);

    } 

    public function hasilHarga(createHarga $request)
    {
        $month                  = $request['month'];
        $year                   = $request['year'];
        $pengeluaran_prod       = labarugi::whereYear('created_at', '=', $year)
                                            ->whereMonth('created_at', '=', $month)
                                            ->sum('pengeluaran');
        $hasil_panen            = $request['hasil_panen'];
        $margin                 = $request['margin'];
        $data['y']              = $year;
        $data['m']              = $month;

        $hasil                  = ($pengeluaran_prod / $hasil_panen) + $margin;  //rumus penentuan harga pokok

        $data['pengeluaran_prod'] = $pengeluaran_prod;
        $data['hasil_panen']    = $hasil_panen;
        $data['hasil']          = $hasil;
        $data['margin']         = $margin;

        return view('laporan.harga',$data);

    }


    public function tahunan(request $request)
    {
        $data['y']              = date('Y');
        
        $januari  = transaksi::whereYear('tgl_transaksi', '=', date('Y'))->whereMonth('tgl_transaksi','=',1)
                                         ->sum('pemasukan');
        $februari = transaksi::whereYear('tgl_transaksi', '=', date('Y'))->whereMonth('tgl_transaksi','=',2)
                                         ->sum('pemasukan');
        $maret = transaksi::whereYear('tgl_transaksi', '=', date('Y'))->whereMonth('tgl_transaksi','=',3)
                                         ->sum('pemasukan');
        $april  = transaksi::whereYear('tgl_transaksi', '=', date('Y'))->whereMonth('tgl_transaksi','=',4)
                                         ->sum('pemasukan');
        $mei = transaksi::whereYear('tgl_transaksi', '=', date('Y'))->whereMonth('tgl_transaksi','=',5)
                                         ->sum('pemasukan');
        $juni = transaksi::whereYear('tgl_transaksi', '=', date('Y'))->whereMonth('tgl_transaksi','=',6)
                                         ->sum('pemasukan');                                 
        $juli  = transaksi::whereYear('tgl_transaksi', '=', date('Y'))->whereMonth('tgl_transaksi','=',7)
                                         ->sum('pemasukan');
        $agustus = transaksi::whereYear('tgl_transaksi', '=', date('Y'))->whereMonth('tgl_transaksi','=',8)
                                         ->sum('pemasukan');
        $september = transaksi::whereYear('tgl_transaksi', '=', date('Y'))->whereMonth('tgl_transaksi','=',9)
                                         ->sum('pemasukan');                                
        $oktober  = transaksi::whereYear('tgl_transaksi', '=', date('Y'))->whereMonth('tgl_transaksi','=',10)
                                         ->sum('pemasukan');
        $november  = transaksi::whereYear('tgl_transaksi', '=', date('Y'))->whereMonth('tgl_transaksi','=',11)
                                         ->sum('pemasukan');
        $desember = transaksi::whereYear('tgl_transaksi', '=', date('Y'))->whereMonth('tgl_transaksi','=',12)
                                         ->sum('pemasukan');                                                           
        $pemasukan = array($januari,$februari,$maret,$april,$mei,$juni,$juli,$agustus,$september,$oktober,$november,$desember);

//----------------------------------------------------------------------------------------------------------------------------------

        $pengjanuari  = transaksi::whereYear('tgl_transaksi', '=', date('Y'))->whereMonth('tgl_transaksi','=',1)
                                         ->sum('pengeluaran');
        $pengfebruari = transaksi::whereYear('tgl_transaksi', '=', date('Y'))->whereMonth('tgl_transaksi','=',2)
                                         ->sum('pengeluaran');
        $pengmaret = transaksi::whereYear('tgl_transaksi', '=', date('Y'))->whereMonth('tgl_transaksi','=',3)
                                         ->sum('pengeluaran');
        $pengapril  = transaksi::whereYear('tgl_transaksi', '=', date('Y'))->whereMonth('tgl_transaksi','=',4)
                                         ->sum('pengeluaran');
        $pengmei = transaksi::whereYear('tgl_transaksi', '=', date('Y'))->whereMonth('tgl_transaksi','=',5)
                                         ->sum('pengeluaran');
        $pengjuni = transaksi::whereYear('tgl_transaksi', '=', date('Y'))->whereMonth('tgl_transaksi','=',6)
                                         ->sum('pengeluaran');                                 
        $pengjuli  = transaksi::whereYear('tgl_transaksi', '=', date('Y'))->whereMonth('tgl_transaksi','=',7)
                                         ->sum('pengeluaran');
        $pengagustus = transaksi::whereYear('tgl_transaksi', '=', date('Y'))->whereMonth('tgl_transaksi','=',8)
                                         ->sum('pengeluaran');
        $pengseptember = transaksi::whereYear('tgl_transaksi', '=', date('Y'))->whereMonth('tgl_transaksi','=',9)
                                         ->sum('pengeluaran');                                
        $pengoktober  = transaksi::whereYear('tgl_transaksi', '=', date('Y'))->whereMonth('tgl_transaksi','=',10)
                                         ->sum('pengeluaran');
        $pengnovember  = transaksi::whereYear('tgl_transaksi', '=', date('Y'))->whereMonth('tgl_transaksi','=',11)
                                         ->sum('pengeluaran');
        $pengdesember = transaksi::whereYear('tgl_transaksi', '=', date('Y'))->whereMonth('tgl_transaksi','=',12)
                                         ->sum('pengeluaran');

        $pengeluaran = array($pengjanuari,$pengfebruari,$pengmaret,$pengapril,$pengmei,$pengjuni,$pengjuli,$pengagustus,$pengseptember,$pengoktober,$pengnovember,$pengdesember);

        $saldomt                = transaksi::latest()
                                            ->whereYear('tgl_transaksi', '=', date('Y'))
                                            ->first();
        if ($saldomt){

            $data['saldomt']        = $saldomt;
        }
        else {

            return redirect('laporan/bulanan/tahunBulan/kosong');
            die;
        }
                                                                                                                                                     
        $monthName = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
        $data['pengeluaran'] = $pengeluaran;
        $data['pemasukan'] = $pemasukan;
       
        $data['monthName'] = $monthName;
        return view('laporan/tahunan',$data);
    }

    public function tahun(request $request)
    {

        $y              = $request['year'];
       
        $januari  = transaksi::whereYear('tgl_transaksi', '=', $y)->whereMonth('tgl_transaksi','=',1)
                                         ->sum('pemasukan');
        $februari = transaksi::whereYear('tgl_transaksi', '=', $y)->whereMonth('tgl_transaksi','=',2)
                                         ->sum('pemasukan');
        $maret = transaksi::whereYear('tgl_transaksi', '=', $y)->whereMonth('tgl_transaksi','=',3)
                                         ->sum('pemasukan');
        $april  = transaksi::whereYear('tgl_transaksi', '=', $y)->whereMonth('tgl_transaksi','=',4)
                                         ->sum('pemasukan');
        $mei = transaksi::whereYear('tgl_transaksi', '=', $y)->whereMonth('tgl_transaksi','=',5)
                                         ->sum('pemasukan');
        $juni = transaksi::whereYear('tgl_transaksi', '=', $y)->whereMonth('tgl_transaksi','=',6)
                                         ->sum('pemasukan');                                 
        $juli  = transaksi::whereYear('tgl_transaksi', '=', $y)->whereMonth('tgl_transaksi','=',7)
                                         ->sum('pemasukan');
        $agustus = transaksi::whereYear('tgl_transaksi', '=', $y)->whereMonth('tgl_transaksi','=',8)
                                         ->sum('pemasukan');
        $september = transaksi::whereYear('tgl_transaksi', '=',$y)->whereMonth('tgl_transaksi','=',9)
                                         ->sum('pemasukan');                                
        $oktober  = transaksi::whereYear('tgl_transaksi', '=', $y)->whereMonth('tgl_transaksi','=',10)
                                         ->sum('pemasukan');
        $november  = transaksi::whereYear('tgl_transaksi', '=', $y)->whereMonth('tgl_transaksi','=',11)
                                         ->sum('pemasukan');
        $desember = transaksi::whereYear('tgl_transaksi', '=', $y)->whereMonth('tgl_transaksi','=',12)
                                         ->sum('pemasukan');                                                           
        $pemasukan = array($januari,$februari,$maret,$april,$mei,$juni,$juli,$agustus,$september,$oktober,$november,$desember);

//----------------------------------------------------------------------------------------------------------------------------------

        $pengjanuari  = transaksi::whereYear('tgl_transaksi', '=', $y)->whereMonth('tgl_transaksi','=',1)
                                         ->sum('pengeluaran');
        $pengfebruari = transaksi::whereYear('tgl_transaksi', '=', $y)->whereMonth('tgl_transaksi','=',2)
                                         ->sum('pengeluaran');
        $pengmaret = transaksi::whereYear('tgl_transaksi', '=',$y)->whereMonth('tgl_transaksi','=',3)
                                         ->sum('pengeluaran');
        $pengapril  = transaksi::whereYear('tgl_transaksi', '=', $y)->whereMonth('tgl_transaksi','=',4)
                                         ->sum('pengeluaran');
        $pengmei = transaksi::whereYear('tgl_transaksi', '=', $y)->whereMonth('tgl_transaksi','=',5)
                                         ->sum('pengeluaran');
        $pengjuni = transaksi::whereYear('tgl_transaksi', '=', $y)->whereMonth('tgl_transaksi','=',6)
                                         ->sum('pengeluaran');                                 
        $pengjuli  = transaksi::whereYear('tgl_transaksi', '=', $y)->whereMonth('tgl_transaksi','=',7)
                                         ->sum('pengeluaran');
        $pengagustus = transaksi::whereYear('tgl_transaksi', '=', $y)->whereMonth('tgl_transaksi','=',8)
                                         ->sum('pengeluaran');
        $pengseptember = transaksi::whereYear('tgl_transaksi', '=', $y)->whereMonth('tgl_transaksi','=',9)
                                         ->sum('pengeluaran');                                
        $pengoktober  = transaksi::whereYear('tgl_transaksi', '=', $y)->whereMonth('tgl_transaksi','=',10)
                                         ->sum('pengeluaran');
        $pengnovember  = transaksi::whereYear('tgl_transaksi', '=', $y)->whereMonth('tgl_transaksi','=',11)
                                         ->sum('pengeluaran');
        $pengdesember = transaksi::whereYear('tgl_transaksi', '=', $y)->whereMonth('tgl_transaksi','=',12)
                                         ->sum('pengeluaran');

        $pengeluaran = array($pengjanuari,$pengfebruari,$pengmaret,$pengapril,$pengmei,$pengjuni,$pengjuli,$pengagustus,$pengseptember,$pengoktober,$pengnovember,$pengdesember);

        $saldomt                = transaksi::latest()
                                            ->whereYear('tgl_transaksi', '=', $y)
                                            ->first();
        if ($saldomt){

            $data['saldomt']        = $saldomt;
        }
        else {

            return redirect('laporan/bulanan/tahunBulan/kosong');
            die;
        }
                                                                                                                                                     
        $monthName = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
        $data['pengeluaran'] = $pengeluaran;
        $data['pemasukan'] = $pemasukan;
        $data['monthName'] = $monthName;
        $data['y']         = $y;

        return view('laporan/tahunan',$data);
    }
    
}
