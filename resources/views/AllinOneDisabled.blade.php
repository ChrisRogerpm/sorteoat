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
  <link rel="stylesheet" href="{{asset('../css/material-bootstrap-wizard.css')}}">
  <link rel="stylesheet" href="{{asset('../css/jquery.dataTables.min.css')}}" />
  
	<!-- CSS Just for demo purpose, don't include it in your project -->
	<style scoped>
		#logoApuestaTotal {
			margin-top:10vh;
			height: 20vh;		
			background-color: white;
			border-radius: 4px;
		}
		@media (max-width: 1200px) {
			#logoApuestaTotal {
				height: 13vh;		
				margin-top:5vh;
			}
			.wizard-card{
				padding-top:0px;
			}
	 }	
	 @media (max-width: 321px) {			
			.wizard-header{
				padding: 10px !important;
			}
	 } 	 
	</style>
</head>

<body style="background-color: #E5E5E5 !important;">
	<div class="image-container set-full-height" style="background: #f5f5f5 !important;">	   

	    <!--   Big container   -->
	    <div class="container" id="container">
	        <div class="row">
		        <div class="col-sm-8 col-sm-offset-2">
		            <!--      Wizard container        -->
		            <div class="wizard-container" style="padding-top:35px !important;">
		                <div class="card wizard-card" data-color="red" id="wizard" style="background-color: #0F1B24; height: 90vh;">
												<div class="image mb text-center">
                            <img src="../images/Logotipo-Horizontal-2258x662.png" alt="CasperoBoard" id="logoApuestaTotal" style="">         
												</div>  
		                    <form method="get" action="{{ route('LogOut') }}">
		                    	<div class="wizard-header">                                                          
                              <br />
                              <br />
		                        	<h3 class="wizard-title" style="color:#F3F3F3;">{{$titulo}}</h3>                                    
                              <br />
															<br />
														<h5 style="color:#F3F3F3; padding-right: 3vw;padding-left: 3vw;">{{$error}}</h5>
		                    	</div>
													<div style="text-align: center;">
															<input type='submit' class='btn  btn-fill btn-danger btn-wd btn-lg' name='' value='Salir' id="btnTerminar" style="font-size: 20px;" />								
													</div>
		                    </form>
		                </div>
		            </div> <!-- wizard container -->
		        </div>
	    	</div> <!-- row -->
		</div> <!--  big container -->
	   
	</div>

</body>
	<!--   Core JS Files   -->
  <script src="{{asset('../js/jquery-2.2.4.min.js')}}"></script>
  <script src="{{asset('../js/bootstrap.min.js')}}"></script>
  <script src="{{asset('../js/jquery.bootstrap.js')}}"></script>
	<!--  Plugin for the Wizard -->
  <script src="{{asset('../js/material-bootstrap-wizard.js')}}"></script>
	<!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
  <script src="{{asset('../js/jquery.validate.min.js')}}"></script>
</html>
