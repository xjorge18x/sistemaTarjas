<?php 
	
  
$barcode = $_GET["codigo"];
$dni = $_GET["codigo"];
$apellidos = $_GET["Apellidos"];
$nombre = $_GET["nombre"];
$ocupacion = $_GET["ocupacion"];


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href='img/icono.png' rel='icon' type='image/x-icon'/>
    <title>Sistema de Gestion De Tarjas</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap.min.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="librerias/Scrollbar/jquery.mCustomScrollbar.min.css">
    <!-- Font Awesome JS -->
    <link rel="stylesheet" href="librerias/fontawesome/css/all.css">
    <!--datables CSS básico-->
    <link rel="stylesheet" type="text/css" href="librerias/datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="librerias/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
    <!-- Our Custom CSS -->

    <script type="text/javascript" src="./charts/loader.js"></script>
    <!-- libreberias para los mensajes -->
    <link rel="stylesheet" type="text/css" href="librerias/sweetalert/sweetalert.css"> 
    <script src="librerias/sweetalert/sweetalert.min.js"></script>

    <!-- script -->
    <script src="js/javaScrip1.js"></script>
    <!-- jQuery  -->
    <script src="librerias/jquery/jquery-3.3.1.min.js"></script>
    <!-- Popper.JS -->
    <script src="librerias/popper/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="librerias/bootstrap/js/bootstrap.min.js"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="librerias/Scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>

    <style type="text/css">
  table#mitabla {
    border-collapse: collapse;
    border: 1px solid #CCC;
    font-size: 12px;
    height: 165px;
    width: 661px;
  }
  table#mitabla td {
    padding: 5px 0px;
  }
  table#mitabla span{
  font-size: 16px;
  font-weight: bold;
  letter-spacing: 15pt;
  
  }
  table#mitabla h6{
  
  text-align: right;
  
  }
  table#mitabla h5{
  font-size: 15px;
  text-align: left;
  
  }
/*  table#mitabla h5{
  font-size: 10px;
  text-align: center;
  vertical-align: bottom;
  text-decoration: overline;
  }*/

  </style>
  <script type="text/javascript">

$(document).ready(function () {
    window.print();
});

</script>
</head>
<body>
<div class="container-fluid">
  <div class="row">
     <div class="col-sm-12 d-flex justify-content-sm-center justify-content-md-center" style="padding-top: 15px;">
		 
    <table id="mitabla" >
    
    <tr>
      <td width="50%"  style="text-align: center;padding-right: 15px; " rowspan="2" >
        <img src="librerias/barcode/barcode.php?text=<?php echo $barcode; ?>&size=100&orientation=horizontal&codetype=Code128&print=false&sizefactor=2.2" />
        <span class=""><?php echo $barcode; ?></span> 
      </td>

      <td style="padding-left: 15px; "><h6>NOMBRE :</h6></td>
      <td><h5><?php echo $nombre; ?></h5></td>
    </tr>
    <tr>
      <td style="padding-left: 15px; "><h6>APELLIDOS :</h6></td>
      <td><h5><?php echo $apellidos ; ?></h5></td>
    </tr>

  </table>   

</div>
  </div>
</div>
</body>
</html>   
        
