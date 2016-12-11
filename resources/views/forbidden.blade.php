<!DOCTYPE html>
<html lang="en">
	<head>
	  <title>Forbidden</title>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
<body>
 
	<div class="container">
		<div class="col-md-8 col-md-offset-2">
		  <hr>
		  <div class="panel panel-danger">
		    <div class="panel-heading" ><h2>Akses ditolak</h2></div>
		    <div class="panel-body">
		    	<div>
		    		<h5>Maaf, Akun anda telah di-Nonaktifkan, silakan hubungi Ketua</h5>
		    	</div>
		    	<button><a href="{{ url('/logout') }}">Kembali</a></button>
		    	
		    </div>
		  </div>
		</div>
	</div>
</body>
</html>
