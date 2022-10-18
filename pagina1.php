<?php 

require_once("cont/CFunciones.php");
include_once("verificar.php");
$obj = new CFunciones;
$codigoGrupo= $_GET["grupo"];
$numcolumnas = 1;
$i = 1;
$query = "select p.codigoEmpleado,p.DNIempleado,CONCAT(p.APEPATempleado,' ',p.APEMATempleado,' ',P.NombresEmpleado)as nombre,P.NombresEmpleado,CONCAT(p.APEPATempleado,' ',p.APEMATempleado)as apellido,
g.NombreGrupo,o.NombreOcupacion,l.NombreLinea from detalleOcupacionEmpleado d
inner join persona p on(p.codigoEmpleado=d.codigoEmpleado)
inner join GrupoTrabajo g on(g.codGrupoTrabajo=d.codGrupoTrabajo)
inner join Ocupacion o on (o.codigoOcupacion=g.codigoOcupacion)
inner join linea l on (l.codigoLinea=o.codigoLinea)
where d.codGrupoTrabajo='$codigoGrupo' ";
$smtv = $obj->consultar1($query);
$total_resultados = sqlsrv_num_rows($smtv);
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
/*	table#mitabla h5{
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
	<table>
<?php

while($row2 = sqlsrv_fetch_array($smtv,SQLSRV_FETCH_ASSOC))
{
	$resto = ($i % $numcolumnas); 
	       if($resto == 1)
	       	{ /*si es el primer elemento creamos una nueva fila*/ 
	         echo "<tr>";
	     	}?>
	     	<td>
	
	<table id="mitabla" >
		
		<tr>
			<td width="50%"  style="text-align: center;padding-right: 15px; " rowspan="2" >
				<img src="librerias/barcode/barcode.php?text=<?php echo $row2 ['DNIempleado']; ?>&size=100&orientation=horizontal&codetype=Code128&print=false&sizefactor=2.2" />
				<span class=""><?php echo $row2 ['DNIempleado']; ?></span> 
			</td>

			<td style="padding-left: 15px; "><h6>NOMBRE :</h6></td>
			<td><h5><?php echo $row2 ['NombresEmpleado']; ?></h5></td>
		</tr>
		<tr>
			<td style="padding-left: 15px; "><h6>APELLIDOS :</h6></td>
			<td><h5><?php echo $row2 ['apellido']; ?></h5></td>
		</tr>

	</table>

</td>

<?php 
		if($resto == 0){
	      /*cerramos la fila*/ 
	      echo "</tr>"; 
	    }
	   $i++; 

}

 if($resto != 0){
	  /*Si en la última fila sobran columnas, creamos celdas vacías*/
	   for ($j = 0; $j < ($numcolumnas - $resto); $j++){
	     echo "<td></td>"; 
	    }
	   echo "</tr>";
} 

?>
	</table>
	</div>
	</div>
</div>
</body>
</html>