<?php
$idPalet=$_GET['idPalet'];
?>
<!DOCTYPE html> 
<html> 
    <head> 
    <style> 
    body { 
 
    background: rgb(204,204,204) !important; 
 
} 
 
page { 
 
    background: white; 
 
    display: block; 
 
    margin: 0 auto; 
 
    margin-bottom: 0.5cm; 
 
    box-shadow: 0 0 0.5cm rgba(0,0,0,0.5); 
 
} 
 
page[size="A4"] { 
 
    width: 10.5cm; 
 
    height: 15.5cm; 
 
} 
 
page[size="A4"][layout="portrait"] { 
 
    width: 10.5cm; 
 
    height: 15.5cm; 
 
} 
 
@media print { 
 
    body, page { 
 
    margin: 0; 
 
    box-shadow: 0; 
 
    } 
    </style> 
     <link rel="stylesheet" href="css/style3.css">
	<link rel="stylesheet" href="librerias/bootstrap-4.5.3/css/bootstrap.min.css">
    <!-- jQuery  -->
    <script src="librerias/jquery/jquery-3.3.1.min.js"></script>
    <!-- Popper.JS -->
    <script src="librerias/popper/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="librerias/bootstrap-4.5.3/js/bootstrap.min.js"></script>

    </head> 
<body>
<!--  <body class="h-100 bg-primary"> -->
	<page size="A4" layout="portrait">
    <div class="container h-100 d-flex align-items-center">
                       <img src="librerias/barcode/barcode.php?text=<?php echo $idPalet;?>&size=300&orientation=vertical&codetype=Code128&print=false&sizefactor=2.2" class="mx-auto d-block "/>               
    </div>  
	</page>


    </body> 
</html>