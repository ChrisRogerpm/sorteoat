<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Material Bootstrap Wizard by Creative Tim</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta name="viewport" content="width=device-width" />
	<meta name="csrf-token" content="{{ csrf_token() }}" />	

	<!--     Fonts and icons     -->
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

	<!-- CSS Files -->
   <link rel="stylesheet" href="{{asset('../css/bootstrap.min.css')}}">
   <link rel="stylesheet" href="{{asset('../css/numeros.css')}}" />
  
	<!-- CSS Just for demo purpose, don't include it in your project -->

</head>

<body>
	<canvas id="confeti" width="300" height="300" class="active"></canvas>
	<div class="contenedor" >	   
		<div class="container" style="width: 100% !important; margin-top:15vh !important;">
			<div class="row">
				<div class="col-md-3 col-md-offset-3 contendorGenerador">
					<div id="Opcion1" class="fly-inn">  
						
					</div>					
				</div>
				<div class="col-md-3 contendorGenerador">
					<div id="Opcion2" class="fly-inn">  
					
					</div>					
				</div>				
			</div>
			<div class="row">
				<div class="col-md-3 contendorGenerador">
					<div id="Opcion3" class="fly-inn">  
						
					</div>					
				</div>
				<div class="col-md-3 contendorGenerador">
					<div id="Opcion4" class="fly-inn">  
					
					</div>					
				</div>	
				<div class="col-md-3 contendorGenerador">
					<div id="Opcion5" class="fly-inn">  
					
					</div>					
				</div>
				<div class="col-md-3 contendorGenerador">
					<div id="Opcion6" class="fly-inn">  
					
					</div>				
				</div>				
			</div>
			<div class="row">
				<div class="col-md-3 contendorGenerador ">
					<div id="Opcion7" class="fly-inn">  
					
					</div>					
				</div>
				<div class="col-md-3 contendorGenerador">
					<div id="Opcion8" class="fly-inn">  
						
					</div>					
				</div>	
				<div class="col-md-3 contendorGenerador">
					<div id="Opcion9" class="fly-inn">  
						
					</div>					
				</div>							
			</div>	
			<div class="row">
				<div class="col-md-3 col-md-offset-3 contendorGenerador">
					<div id="Opcion10" class="fly-inn">  
						
					</div>				
				</div>							
			</div>			
		</div>		   
	</div>
	<svg class="svg" height="100%" width="100%" viewBox="0 0 100 100"  preserveAspectRatio="none">
    	<path d="M0 0 H 100 V 100 H 00 Z" fill="transparent" stroke="black" vector-effect="non-scaling-stroke"/>
    </svg>
</body>
	

	<script src="{{asset('../js/jquery-2.2.4.min.js')}}"></script>
	<script src="{{asset('../js/bootstrap.min.js')}}"></script>
  	<script src="{{asset('../js/jquery.bootstrap.js')}}"></script> 
	<script src="{{asset('../js/anime.min.js')}}"></script>	
	<script src="{{asset('../js/funciones.js')}}"></script>	
	<script src="{{asset('../js/numeros.js')}}"></script>	
	

</html>
