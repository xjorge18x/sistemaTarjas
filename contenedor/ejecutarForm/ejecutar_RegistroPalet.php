<?php
require_once("../../cont/CFunciones.php");
include("../../conectar.php");
include_once("../../verificar.php");
$obj = new Cfunciones;

if(isset($_POST["accion"]))
{
	$accion = $_POST["accion"];

	 if($accion == "EnviarPalet")
	 {
	 	$CantidadPalte = $_POST["CantidadPalet"];
	 	$NomPalet = $_POST["NomPalet"];
		$CodUsuario = $_POST["CodUsuario"];
		$pagina = $_POST["pagina"];
		$idPalet = $_POST["idPalet"];
		$tipo = $_POST["tipo"];
		$TipoProc = $_POST["TipoProc"];

	 	$query = "{call RegistroPalet(?,?,?,?,?,?)}";
	 	$parametros = array(
		 		array(&$CantidadPalte,SQLSRV_PARAM_IN),
		 		array(&$CodUsuario,SQLSRV_PARAM_IN),
		 		array(&$idPalet,SQLSRV_PARAM_IN),
		 		array(&$tipo,SQLSRV_PARAM_IN),
		 		array(&$TipoProc,SQLSRV_PARAM_IN),
		 		array(&$NomPalet,SQLSRV_PARAM_IN),);
		$ejecutar = $obj->ejecutar_PA($query,$parametros);
		if($ejecutar===false)
					{
					echo "Ocurrio un error";
					die( print_r( sqlsrv_errors(), true));
					$sw = 2;
					}
					else
					{
					$sw = 1;
					}

		?>
		<div id="sw" class="respuestaMsg"><?php echo $sw; ?></div>
		<?php
		$pagina = $pagina;
		$TipoProc = $TipoProc;
		include_once("../etiquetado/tabla_PaletGenerados.php");

	 }
	 elseif ($accion == "EnviarCaja")
	 {

	 	$codigoBarra = $_POST["codigoBarra"];
	 	$idPalet = $_POST["idPalet"];
	 	$idaccion = $_POST["idaccion"];
	 	$CodUsuario = $_POST["CodUsuario"];

	 	$ejeCodigo = $obj->consultar("SELECT Estado,IdCaja_Project numerofilas
	 	FROM Caja_Project WHERE IdCaja_Project='$codigoBarra'");
	 	$filas = sqlsrv_num_rows($ejeCodigo);
	 	$rows = sqlsrv_fetch_array($ejeCodigo,SQLSRV_FETCH_ASSOC); 

	 	$ejeCodigo2 = $obj->consultar("SELECT CodDetalle,IdCaja_Project,IdPalet_Generado,Estado FROM DetalleProject WHERE IdCaja_Project='$codigoBarra' and Estado=1");
	 	$filas2 = sqlsrv_num_rows($ejeCodigo2);
	 	$rows2 = sqlsrv_fetch_array($ejeCodigo2,SQLSRV_FETCH_ASSOC); 

	 	$ejeCodigo3 = $obj->consultar("SELECT CodDetalle,IdCaja_Project,IdPalet_Generado,Estado FROM DetalleProject WHERE IdCaja_Project='$codigoBarra' and IdPalet_Generado='$idPalet' and Estado=1");
	 	$filas3 = sqlsrv_num_rows($ejeCodigo3);

	 	$ejeCodigo4 = $obj->consultar("SELECT (SELECT Capacidad_Max FROM Pallet_Generado WHERE IdPallet_Generado='$idPalet') capacidad,COUNT(d.IdCaja_Project) as tcjs FROM DetalleProject d 
			WHERE IdPalet_Generado='$idPalet'and Estado=1");
	 	$rows4 = sqlsrv_fetch_array($ejeCodigo4,SQLSRV_FETCH_ASSOC); 



	 	$EstadoCaja = $rows["Estado"];
	 	$CodDetalle = $rows2["CodDetalle"];
	 	$IdCaja_Project = $rows2["IdCaja_Project"];
	 	$IdPalet_Generado = $rows2["IdPalet_Generado"];
	 	$EstadoDetall = $rows2["Estado"];
	 	$Capacidad = $rows4["capacidad"];
	 	$totalCjs= $rows4["tcjs"];

	  	if(($obj->ValidaCajaReg($filas,$idaccion,$EstadoCaja,$IdPalet_Generado,$idPalet,$filas3,$Capacidad,$totalCjs)==1))
		{
	 	$query = "{call Insertar_DetallePalet(?,?,?,?,NULL)}";
	 	$parametros = array(
		 		array(&$codigoBarra,SQLSRV_PARAM_IN),
		 		array(&$idPalet,SQLSRV_PARAM_IN),
		 		array(&$idaccion,SQLSRV_PARAM_IN),
		 		array(&$CodUsuario,SQLSRV_PARAM_IN),);
		$ejecutar = $obj->ejecutar_PA($query,$parametros);
		if($ejecutar===false)
					{
					echo "Ocurrio un error";
					die( print_r( sqlsrv_errors(), true));
					$sw = 2;
					}
					else
					{
					$sw = 1;
					}
		}
		else
		{
		$sw = $obj->ValidaCajaReg($filas,$idaccion,$EstadoCaja,$IdPalet_Generado,$idPalet,$filas3,$Capacidad,$totalCjs);
		}
		?>
		<div id="sw2" class="respuestaMsg"><?php echo $sw; ?></div>
		<div id="CodCaja" class="respuestaMsg" ><?php echo $IdCaja_Project;?></div>
		<div id="CodDetalle" class="respuestaMsg" ><?php echo $CodDetalle;?></div>
		<?php
		$idPalet =$idPalet;
		include_once("../etiquetado/tabla_CajasRegistradas.php");

	 }
	 elseif ($accion == "EnviarRuma") {
	 
	 	$codigoBarra = $_POST["codigoBarra"];
	 	$idPalet = $_POST["idPalet"];
	 	$idaccion = $_POST["idaccion"];
	 	$CodUsuario = $_POST["CodUsuario"];

	 	$ejeCodigo = $obj->consultar("SELECT Estado
	 	FROM Pallet_Generado WHERE IdPallet_Generado='$codigoBarra' and TipoProceso=1");
	 	$filas = sqlsrv_num_rows($ejeCodigo);
	 	$rows = sqlsrv_fetch_array($ejeCodigo,SQLSRV_FETCH_ASSOC); 

	 	$ejeCodigo2 = $obj->consultar("SELECT CodDetalle,IdRuma,IdPalet_Generado,Estado FROM DetalleProject WHERE IdRuma='$codigoBarra' and Estado=1");
	 	$filas2 = sqlsrv_num_rows($ejeCodigo2);
	 	$rows2 = sqlsrv_fetch_array($ejeCodigo2,SQLSRV_FETCH_ASSOC); 

	 	$ejeCodigo3 = $obj->consultar("select count(d.IdCaja_Project)Cajas
		from DetalleProject d
		inner join Pallet_Generado p on p.IdPallet_Generado=d.IdPalet_Generado
		where p.IdPallet_Generado='$codigoBarra' and d.Estado= 1");
	 	$filas3 = sqlsrv_num_rows($ejeCodigo3);
	 	$rows3 = sqlsrv_fetch_array($ejeCodigo3,SQLSRV_FETCH_ASSOC);

	 	$ejeCodigo4 = $obj->consultar("SELECT CodDetalle,IdCaja_Project,IdPalet_Generado,Estado FROM DetalleProject WHERE IdRuma='$codigoBarra' and IdPalet_Generado='$idPalet' and Estado=1");
	 	$filas4 = sqlsrv_num_rows($ejeCodigo4);

	 	$EstadoCaja = $rows["Estado"];
	 	$IdCaja_Project = $rows2["IdRuma"];
	 	$CodDetalle = $rows2["CodDetalle"];
	 	$IdPalet_Generado = $rows2["IdPalet_Generado"];
	 	$CajasRuma = $rows3["Cajas"];
	  	if(($obj->ValidaRumaReg($filas,$idaccion,$filas2,$IdPalet_Generado,$idPalet,$CajasRuma,$filas4)==1))
		{
	 	$query = "{call Insertar_DetallePalet(?,?,?,?,NULL)}";
	 	$parametros = array(
		 		array(&$codigoBarra,SQLSRV_PARAM_IN),
		 		array(&$idPalet,SQLSRV_PARAM_IN),
		 		array(&$idaccion,SQLSRV_PARAM_IN),
		 		array(&$CodUsuario,SQLSRV_PARAM_IN),);
		$ejecutar = $obj->ejecutar_PA($query,$parametros);
		if($ejecutar===false)
					{
					echo "Ocurrio un error";
					die( print_r( sqlsrv_errors(), true));
					$sw = 2;
					}
					else
					{
					$sw = 1;
					}
		}
		else
		{
		$sw = $obj->ValidaRumaReg($filas,$idaccion,$filas2,$IdPalet_Generado,$idPalet,$CajasRuma,$filas4);
		}
		?>
		<div id="sw2" class="respuestaMsg"><?php echo $sw; ?></div>
		<div id="CodCaja" class="respuestaMsg" ><?php echo $IdCaja_Project;?></div>
		<div id="CodDetalle" class="respuestaMsg" ><?php echo $CodDetalle;?></div>
		<?php
		$idPalet =$idPalet;
		include_once("../etiquetado/tabla_CajasRegistradas.php");
	 }


	  elseif ($accion == "traslado")
	  {
		$CodCaja = $_POST["CodCaja"];
		$idPalet = $_POST["idPalet"];
		$CodUsuario = $_POST["CodUsuario"];
		$CodDetalle = $_POST["CodDetalle"];

		$ejeCodigo = $obj->consultar("SELECT idTipoOpe  from DetalleProject where codDetalle='$CodDetalle'");
	 	$rows = sqlsrv_fetch_array($ejeCodigo,SQLSRV_FETCH_ASSOC);

	 	if ($rows['idTipoOpe'] == 0 ) {
	 		$idaccion = 2;
	 	}
	 	else if ($rows['idTipoOpe'] == 1 )
	 	{
	 		$idaccion = 5;
	 	}
		

		$query = "{call Insertar_DetallePalet(?,?,?,?,?)}";
	 	$parametros = array(
		 		array(&$CodCaja,SQLSRV_PARAM_IN),
		 		array(&$idPalet,SQLSRV_PARAM_IN),
		 		array(&$idaccion,SQLSRV_PARAM_IN),
		 		array(&$CodUsuario,SQLSRV_PARAM_IN),
		 		array(&$CodDetalle,SQLSRV_PARAM_IN),);
		$ejecutar = $obj->ejecutar_PA($query,$parametros);
		if($ejecutar===false)
					{
					echo "Ocurrio un error";
					die( print_r( sqlsrv_errors(), true));
					$sw = 2;
					}
					else
					{
					$sw = 1;
					}

	  	?>
	  	<div id="sw" class="respuestaMsg" ><?php echo $sw;?></div>
	  	<?php
	  	$idPalet =$idPalet ;
		include_once("../etiquetado/tabla_CajasRegistradas.php");

	  }
	  elseif ($accion =="CerrarPalet") {
	  	$idPalet = $_POST["idPalet"];
		$CodUsuario = $_POST["CodUsuario"];
		$tipo = $_POST['tipo'];
		$tipoproc = $_POST['tipoproc'];

		$query = "{call RegistroPalet(NULL,?,?,2,NULL,NULL)}";
	 	$parametros = array(
		 		array(&$CodUsuario,SQLSRV_PARAM_IN),
		 		array(&$idPalet,SQLSRV_PARAM_IN),);
		$ejecutar = $obj->ejecutar_PA($query,$parametros);
		if($ejecutar===false)
					{
					echo "Ocurrio un error";
					die( print_r( sqlsrv_errors(), true));
					$sw = 2;
					}
					else
					{
					$sw = 1;
					}
	  	

	  	?>
	  	<div id="sw" class="respuestaMsg" ><?php echo $sw;?></div>
	  	<?php 
	  	if ($tipo==1) {
	  		$pagina = 1;
	  		$TipoProc = $tipoproc;
	  		include_once("../etiquetado/tabla_PaletGenerados.php");
	  	}
	  	else
	  	{
	  		$codigoBarras = $idPalet;
	  		include_once("../etiquetado/tabla_PaletGestion.php");
	  	}
	  	
	  }

	  elseif ($accion == 'Buscar') {
	  	$codigoBarras = $_POST["codigoBarras"];
	  	$tipo = $_POST["tipo"];
	  	if ($tipo == 1) {
	  		include_once("../etiquetado/tabla_PaletGestion.php");
	  	}
	  	elseif ($tipo == 2) {
	  		include_once("../etiquetado/tabla_CajaGestion.php");
	  	}
	  	
	  }

	  elseif ($accion == 'Trazabilidad') {
	  	$codigoBarras = $_POST["codigoBarras"];
	
	  		include_once("../etiquetado/tabla_TrazabilidadCja.php");

	  }

	   elseif ($accion == 'EnviarCajasPalet') 
	   {
	   	$codigoBarras = $_POST["codigoBarra"];//
	   	$idPalet = $_POST["idPalet"];//Destino
	   	$idaccion = $_POST["idaccion"];

	 	$ejeCodigo = $obj->consultar("SELECT COUNT(P.IdPallet_Generado) PALET ,
		(SELECT COUNT(IdPalet_Generado) FROM DetalleProject WHERE IdPalet_Generado=P.IdPallet_Generado AND Estado=1) AS DETALLE 
		FROM Pallet_Generado P
		WHERE P.IdPallet_Generado='$codigoBarras' 
		GROUP BY P.IdPallet_Generado
		");
	 
	 	$rows = sqlsrv_fetch_array($ejeCodigo,SQLSRV_FETCH_ASSOC);
	 	$Palet = $rows["PALET"];
	 	$Paletdetalle = $rows["DETALLE"];

	  if(($obj->ValidaTrasPalet($idPalet,$codigoBarras,$idaccion,$Palet,$Paletdetalle)==1))
		{
	   	$query = "{call Insertar_Cajas_palet(?,?)}";
	 	$parametros = array(
		 		array(&$codigoBarras,SQLSRV_PARAM_IN),
		 		array(&$idPalet,SQLSRV_PARAM_IN),);
		$ejecutar = $obj->ejecutar_PA($query,$parametros);
		if($ejecutar===false)
					{
					echo "Ocurrio un error";
					die( print_r( sqlsrv_errors(), true));
					$sw = 2;
					}
					else
					{
					$sw = 1;
					}
		}
		else
		{
		$sw = $obj->ValidaTrasPalet($idPalet,$codigoBarras,$idaccion,$Palet,$Paletdetalle );
		}

		?>
		<div id="sw2" class="respuestaMsg"><?php echo $sw; ?></div>

		<?php
		$idPalet =$idPalet;
		include_once("../etiquetado/tabla_CajasRegistradas.php");

	   }

	   	else if ($accion == 'VerDetallePalet') {
	
		$Palet = $_POST['Palet'];
		$NumCajas = $_POST['numcjas'];

		$querydetalle = "{call DetallePaletV1 (?)}";
		$parametros = array(
		        array(&$Palet,SQLSRV_PARAM_IN));

		$ejecutar_ControlP1= $obj->ejecutar_PA($querydetalle,$parametros);

		if( $ejecutar_ControlP1 === false )
				    {        
				        echo "Ocurrio un error.\n";
				        die( print_r( sqlsrv_errors(), true));
				    }
				else
				    {
				    	if ($NumCajas <> 0) {
				    			?>
				    <table class="table table-bordered">
				    	<tr>
						<td><div class="contenedor">Producto / Palet(<?php echo $Palet;?>)</div></td>
						<td><div class="contenedor">Total</div></td>
					</tr>
				   <?php
				   while($row2 = sqlsrv_fetch_array($ejecutar_ControlP1,SQLSRV_FETCH_ASSOC)) 

	       					{?>
							<tr>
								<td><span style="font-size: 13px"><?php  echo $row2["NomPro"]; ?></span></td>
								<td><div class="contenedor"><?php echo $row2['total']?></div></td>
							</tr>
							 <?php } ?>

					</table>
					<?php
				    	}
				    
				    }
	}

}

?>