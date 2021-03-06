<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SI Keuangan ASRI 12</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <!-- Bootstrap CSS -->    
    <link href="{{ asset('css/bootstrap.min.css') }} " rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="{{ asset('css/bootstrap-theme.css') }}" rel="stylesheet">
    <!-- font icon -->
    <link href="{{ asset('css/elegant-icons-style.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" />    
    <!-- owl carousel -->
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.css') }}" type="text/css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.css') }}" type="text/css">
    <link href="{{ asset('css/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet">
    <!-- Custom styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style-responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('css/xcharts.min.css') }}" rel=" stylesheet">  
    <link href="{{ asset('css/jquery-ui-1.10.4.min.css') }}" rel="stylesheet">
    <!-- Custom styles for this template footer-->
    <link href="{{ asset('css/sticky-footer-navbar.css') }}" rel="stylesheet" type="text/css">
    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }

        .btn-space {
             margin-right: 6px;  /*css untuk nambah spasi button group*/
        }

    </style>
    <script type=”text/javascript”>
   
}
 
    </script>


</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container-fluid">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    SI Keuangan ASRI 12 
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                @if (Auth::guest())

                @elseif(Auth::user()->jabatan == 'ANGGOTA')
                    <li><a href="{{ url('sayuran') }}">Sayuran</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Laporan<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('laporan/bulanan') }}"><i class="fa fa-btn fa fa-usd"></i> Keuangan Bulanan</a></li>
                                <li><a href="{{ url('laporan/labarugi') }}"><i class="fa fa-btn fa-bar-chart"></i></i>Laba-Rugi</a></li>
                                <li><a href="{{ url('/harga') }}"><i class="fa fa-btn fa fa-money"></i></i>Harga Jual Produk</a></li>
                        </ul>
                    </li>
                @else
                    <li><a href="{{ url('anggaran') }}">Anggaran</a></li>
                    <li><a href="{{ url('pengeluaran') }}">Realisasi</a></li>
                    <li><a href="{{ url('pemasukan') }}">Pemasukan</a></li>
                    <li><a href="{{ url('sayuran') }}">Sayuran</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Laporan<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('laporan/bulanan') }}"><i class="fa fa-btn fa fa-usd"></i> Keuangan Bulanan</a></li>
                                <li><a href="{{ url('laporan/labarugi') }}"><i class="fa fa-btn fa-bar-chart"></i></i>Laba-Rugi</a></li>
                                <li><a href="{{ url('/harga') }}"><i class="fa fa-btn fa fa-money"></i></i>Harga Jual Produk</a></li>
                        </ul>
                    </li>
                        
                @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        
                    @elseif(Auth::user()->jabatan =='KETUA')
                        <li><a href="{{ url('/pengguna') }}">Pengguna</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                {{ Auth::user()->name }}<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('pengguna/'.Auth::user()->id.'/profil') }}"><i class="fa fa-btn fa fa-user"></i></i>Profil</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @elseif(Auth::user()->jabatan =='BENDAHARA')
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                               {{ Auth::user()->name }}<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('pengguna/'.Auth::user()->id.'/profil') }}"><i class="fa fa-btn fa fa-user"></i></i>Profil</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('pengguna/'.Auth::user()->id.'/profil') }}"><i class="fa fa-btn fa fa-user"></i></i>Profil</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

  
   
    
@yield('content')
    


    <!-- JavaScripts -->
    <script src="{{ asset('js/2.2.3-jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js')  }}"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/jquery-ui-1.10.4.min.js') }}"></script>
    <script src="{{ asset('js/jquery-1.8.3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-ui-1.9.2.custom.min.js') }}"></script>

     <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="{{ asset('css/ie10-viewport-bug-workaround.css')}}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/navbar-static-top.css') }}" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="{{ asset('js/ie-emulation-modes-warning.js') }}" ></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script type="text/javascript" src="jquery.js"></script>
    <script type="text/javascript">
         $( function() {
            $( "#datepicker" ).datepicker({
                dateFormat : 'yy-mm-dd'
                });
        });
    </script>

    <script type="text/javascript" src="{{ asset ('js/jquery.js') }}"></script>

<script type="text/javascript" >

            $(document).ready(function() {
            //this calculates values automatically 
            sum();
            $("#bibit, #nutrisi, #bahan_lain").on("keydown keyup", function() {
                sum();
            });
        });

        function sum() {
                    var num1 = document.getElementById('bibit').value;
                    var num2 = document.getElementById('nutrisi').value;
                    var num3 = document.getElementById('bahan_lain').value;
                    var result = parseInt(num1) + parseInt(num2) + parseInt(num3);

                    if (!isNaN(result)) {
                        document.getElementById('tot_anggaran').value = result;
                    }
                }
</script>

<script type="text/javascript">

     $("#bibit, #nutrisi, #bahan_lain").keyup(function(){
 
         var bibit = $("#bibit").val();
         var ang_bibit = $("#ang_bibit").val();
         var nutrisi = $("#nutrisi").val();
         var ang_nutrisi = $("#ang_nutrisi").val(); 
         var bahan_lain = $("#bahan_lain").val();
         var ang_bahan_lain = $("#ang_bahan_lain").val();
 
         if ( parseInt(bibit) > parseInt(ang_bibit) )
             {
                alert("Maaf, Realisasi tidak boleh lebih dari anggaran");
                 $("#bibit").val("");
             }
         else if (parseInt(nutrisi) > parseInt(ang_nutrisi))
             {
                 alert("Maaf, Realisasi tidak boleh lebih dari anggaran");
                 $("#nutrisi").val("");
             }
         else if (parseInt(bahan_lain) > parseInt(ang_bahan_lain))
             {
                 alert("Maaf, Realisasi tidak boleh lebih dari anggaran");
                 $("#bahan_lain").val("");
             }
 
         else{
         
             }
 
     });
 
</script>

<script type="text/javascript">
    $("#total_panen, #profit, #harga_rekomen").keyup(function(){
 
        var num1   = $("#total_modal").val();
        var num2   = $("#total_panen").val();
        var num3   = $("#profit").val();
        var sat     = (parseInt(num1) / parseInt(num2));
        var pro     =  parseInt(sat) * (parseInt(num3)/100);
        var result  = sat + pro;

        if (!isNaN(parseInt(result))) {

                $("#harga_rekomen").val(result);
                       
            }
         
 
     });
</script>



</body>
</html>
