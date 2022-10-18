
<?php
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
$obj = new Cfunciones;
if(isset($_POST["accion"]))
{
    $accion = $_POST["accion"];
	if($accion=="ejecutar_asistencia")
	{
		$codigo= $_POST["codigo"];
		$hora= $_POST["hora"];
		$tipoturno= $_POST["tipoturno"];
		$codGrupo= $_POST["codGrupo"];
		$asistencia = $_POST["asistencia"];
		$pagina = $_POST["pagina"];

		if(($asistencia==1) and ($tipoturno==1)){
			$hora = "00:00";
		}
		if(($asistencia==2) and ($tipoturno==2)){
			$hora = "00:00";
		}
		$ejeCodigo = $obj->consultar("SELECT d.codigoEmpleado,d.asistencia,d.nolaboral,CONVERT (char(5), d.fechaIngreso, 108) as inciolaboral,CONVERT (char(5), d.fechaSalida, 108) as fimlaboral FROM DetalleCabRegistro d
		INNER JOIN persona p ON(p.codigoEmpleado=d.codigoEmpleado)
		WHERE d.codDetalle='$codigo'");
		$rows = sqlsrv_fetch_array($ejeCodigo,SQLSRV_FETCH_ASSOC);//Verifica estado de registro no laborable
		                                                          
		$codEmpl= $rows['codigoEmpleado'];        

		$ejeCodigo2 = $obj->consultar("SELECT TOP 1 codDetalle,CONVERT (char(5), fechaSalida, 108) as finlaboral,asistencia
		FROM DetalleCabRegistro
		WHERE codDetalle NOT IN (SELECT Max(codDetalle) FROM DetalleCabRegistro) and codigoEmpleado='$codEmpl'
		ORDER BY codDetalle DESC");
		$rows2 = sqlsrv_fetch_array($ejeCodigo2,SQLSRV_FETCH_ASSOC);

		$registroAnteriorHora=$rows2["finlaboral"];

		$ejeCodigo3 = $obj->consultar("SELECT COUNT(*) AS TOTAL FROM DetalleCabRegistro d
		inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
		inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
			WHERE d.codigoEmpleado='$codEmpl' AND c.estado='1' and t.estado='0' and d.codigogrupo='$codGrupo'");
		$rows3 = sqlsrv_fetch_array($ejeCodigo3,SQLSRV_FETCH_ASSOC);

		$totalreg = $rows3['TOTAL'];

		$estadoNolab = $rows["nolaboral"];
		$fechaIngreso = $rows["inciolaboral"];
		$fechaSalida = $rows["fimlaboral"];
		$estadoasistencia = $rows["asistencia"];
	
		if(($obj->validarAsistencia($hora,$estadoNolab,$tipoturno,$fechaIngreso,$fechaSalida,$estadoasistencia,$registroAnteriorHora,$totalreg)==1))
		{
			$horaarray = explode(":", $hora); // separa la hora en dos dentro de un array
			$NroHoras = (int) $horaarray[0];
			$NroMinut = (int) $horaarray[1];
			$query = "{call actualizar_asistencia (?,?,?,0,0,0,?)}";

			$parametros = array(
			array(&$codigo,SQLSRV_PARAM_IN),
			array(&$NroHoras,SQLSRV_PARAM_IN),
			array(&$NroMinut,SQLSRV_PARAM_IN),
			array(&$tipoturno,SQLSRV_PARAM_IN),);
			$ejecutar = $obj->ejecutar_PA($query,$parametros);
			if ($ejecutar===false){
			echo "Ocurrio un error";
			die( print_r( sqlsrv_errors(), true));
			$sw = 2;
			}
			else{
			$sw = 1; // ingreso con exito	 
			}

		}
		else
		{
			$sw = $obj->validarAsistencia($hora,$estadoNolab,$tipoturno,$fechaIngreso,$fechaSalida,$estadoasistencia,$registroAnteriorHora,$totalreg);
		}
		

		$codGrupo = $codGrupo; // envia el codigoGrupo
		$idTipoTurno = $tipoturno; // envia el codigoGrupo
		$pagina = $pagina;
		include_once("../formularios/tabla_asistenciaDiaria.php"); // carga el archivo de la tabla asistencia
		?>
		<div id="sw" class="respuestaMsg"><?php echo $sw; ?></div>
		<?php

	} // hasta aqui es ejecutar asistencia


	elseif ($accion == "ejecutar_asistenciaCB") 
	{
		$codigoBarra = $_POST["codigoBarra"];
		$hora = $_POST["hora"];
		$codGrupo = $_POST["codGrupo"];
		$tipoturno= $_POST["tipoturno"];//Ingreso-> 1 Salida-> 2
		$pagina = $_POST["pagina"];
		$por_pagina = $_POST["NumeroFilas"];

		$query= $obj->consultar("select codigoEmpleado from persona where DNIempleado='$codigoBarra'");//verifica que existe personal
		$filasEmpleado = sqlsrv_num_rows($query);
		$row = sqlsrv_fetch_array($query,SQLSRV_FETCH_ASSOC);
		$codigoEmpleado = $row["codigoEmpleado"];

		$ejeCodigo = $obj->consultar("SELECT top 1 d.codDetalle,d.nolaboral,CONVERT (char(5), d.fechaIngreso, 108) as inciolaboral,
		CONVERT (char(5), d.fechaSalida, 108) as fimlaboral,d.asistencia
		FROM DetalleCabRegistro d
		inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
		inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
		where d.codigogrupo='$codGrupo' and d.codigoEmpleado='$codigoEmpleado' and t.estado=0 and d.estado=1 ORDER BY d.codDetalle DESC");


		$filas = sqlsrv_num_rows($ejeCodigo);
		$rows = sqlsrv_fetch_array($ejeCodigo,SQLSRV_FETCH_ASSOC);

		$ejeCodigo2 = $obj->consultar("SELECT top 1 d.codDetalle,d.nolaboral,CONVERT (char(5), d.fechaIngreso, 108) as inciolaboral,
		CONVERT (char(5), d.fechaSalida, 108) as fimlaboral,d.asistencia,d.codigogrupo
		FROM DetalleCabRegistro d
		inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
		inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
		where d.codigoEmpleado='$codigoEmpleado' and t.estado=0 and d.estado=1
		ORDER BY d.codDetalle DESC");

		$filas2 = sqlsrv_num_rows($ejeCodigo2);
		$rows2 = sqlsrv_fetch_array($ejeCodigo2,SQLSRV_FETCH_ASSOC);

		$codigo= $rows['codDetalle'];
		$estadoNolab = $rows["nolaboral"];
		$fechaIngreso = $rows["inciolaboral"];
		$fechaSalida = $rows["fimlaboral"];
		$estadoasistencia = $rows["asistencia"];

		//
		$CodigoGru2 = $rows2["codigogrupo"];

		if(($obj->validarAsistenciaCB($hora,$codigoBarra,$filasEmpleado,$estadoasistencia,$tipoturno,$filas,$CodigoGru2,$codGrupo,$fechaIngreso)==1))
		{
			$horaarray = explode(":", $hora); // separa la hora en dos dentro de un array
			$NroHoras = (int) $horaarray[0];
			$NroMinut = (int) $horaarray[1];
			$query = "{call actualizar_asistencia(?,?,?,0,0,0,?)}";

			$parametros = array(
			array(&$codigo,SQLSRV_PARAM_IN),
			array(&$NroHoras,SQLSRV_PARAM_IN),
			array(&$NroMinut,SQLSRV_PARAM_IN),
			array(&$tipoturno,SQLSRV_PARAM_IN),);
			$ejecutar = $obj->ejecutar_PA($query,$parametros);
			if ($ejecutar===false)
			{
			echo "Ocurrio un error";
			die( print_r( sqlsrv_errors(), true));
			$sw = 2;
			}
			else{
			$sw = 1; // exito	
			}
		}
		else
		{
			$sw = $obj->validarAsistenciaCB($hora,$codigoBarra,$filasEmpleado,$estadoasistencia,$tipoturno,$filas,$CodigoGru2,$codGrupo,$fechaIngreso);
		}
			
		?>
		<div id="sw" class="respuestaMsg"><?php echo $sw; ?></div>
		<?php
		$por_pagina = $por_pagina;
		$codGrupo = $codGrupo; // envia el codigoGrupo
		$idTipoTurno = $tipoturno; 
		$pagina = $pagina;
		include_once("../formularios/tabla_asistenciaDiaria.php"); // carga el archivo de la tabla asistencia
	} // aqui termina ejecutar asistencias por codigo de barraas


	elseif ($accion = "ejecutar_agregarpersonaAsistencia") 
	{
		$codigoBarra = $_POST["codigoBarra"];
		$codGrupo = $_POST["codGrupo"];
		$idaccion = $_POST["idaccion"];
		$tipoturno= $_POST["tipoturno"];//Ingreso-> 1 Salida-> 2
		$idOcupacion = $_POST["idOcupacion"];
		$hora= $_POST["hora"];
		$pagina = $_POST["pagina"];

		$ejeCodigo1 = $obj->consultar("select  distinct c.codigoRegistro from CabRegistroLab c
		inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
		inner join Ocupacion o on (o.codigoOcupacion=c.codigoOcupacion)
		inner join GrupoTrabajo g on (c.codigoOcupacion=g.codigoOcupacion)
		inner join DetalleCabRegistro d on (d.codigoRegistro=c.codigoRegistro)
		where t.estado=0 and c.codigoOcupacion='$idOcupacion' and d.codigogrupo='$codGrupo'");//obtengo codigo de registro
		$rows1 = sqlsrv_fetch_array($ejeCodigo1,SQLSRV_FETCH_ASSOC);
		$codigoRegistro = $rows1["codigoRegistro"];


		$ejeCodigo = $obj->consultar("select codigoEmpleado from persona where DNIempleado='$codigoBarra'");//verifica que existe personal
		$filas = sqlsrv_num_rows($ejeCodigo);
		$rows = sqlsrv_fetch_array($ejeCodigo,SQLSRV_FETCH_ASSOC);
		$codigoEmpleado = $rows["codigoEmpleado"];

		$ejeCodigo2 = $obj->consultar("select top 1 d.asistencia,CONVERT (char(5), d.fechaSalida, 108) as fimlaboral from DetalleCabRegistro d
			inner join CabRegistroLab  c on (c.codigoRegistro=d.codigoRegistro)
			inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
			where t.estado=0 and d.codigoEmpleado='$codigoEmpleado' and d.codigogrupo='$codGrupo' and d.codigoRegistro='$codigoRegistro'
			ORDER BY d.codDetalle DESC");//verifica que existe personal en el grupo de trabajo actual 
		$filas2 = sqlsrv_num_rows($ejeCodigo2);
		$rows2 = sqlsrv_fetch_array($ejeCodigo2,SQLSRV_FETCH_ASSOC);
		$asifila2 = $rows2['asistencia'];
		$fechaSalida = $rows2['fimlaboral'];

		$ejeCodigo4 = $obj->consultar("Select top 1 d.asistencia,CONVERT (char(5), d.fechaSalida, 108) as fimlaboral 
		from DetalleCabRegistro d
		inner join CabRegistroLab  c on (c.codigoRegistro=d.codigoRegistro)
		inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
		where t.estado=0 and d.codigoEmpleado='$codigoEmpleado'
		ORDER BY d.codDetalle DESC");
		$row4 = sqlsrv_fetch_array($ejeCodigo4,SQLSRV_FETCH_ASSOC);
		echo $ultimaHoraSalida = $row4['fimlaboral'];
		echo $estadoAsistencia=$row4["asistencia"];
		
		if($idaccion==1){ // agrega persona sin definir hora
		$tipoOperacion=3; 
		$hora = "00:00";
		}
		elseif ($idaccion==2) 
		{ // agrega la persona definienda la hora entrada
		$tipoOperacion=4;
		}	

		
		if(($obj->validarAgregarPersona($codigoBarra,$filas,$filas2,$hora,$tipoOperacion,$estadoAsistencia,$asifila2,$fechaSalida,$ultimaHoraSalida,$tipoturno)==1))
		{
			$horaarray = explode(":", $hora); // separa la hora en dos dentro de un array
						$NroHoras = (int) $horaarray[0];
						$NroMinut = (int) $horaarray[1];
						$query = "{call actualizar_asistencia (0,?,?,?,?,?,?)}";
						$parametros = array(
						array(&$NroHoras,SQLSRV_PARAM_IN),
						array(&$NroMinut,SQLSRV_PARAM_IN),
						array(&$codigoRegistro,SQLSRV_PARAM_IN),
						array(&$codGrupo,SQLSRV_PARAM_IN),
						array(&$codigoEmpleado,SQLSRV_PARAM_IN),  
						array(&$tipoOperacion,SQLSRV_PARAM_IN), 
						);
						$ejecutar = $obj->ejecutar_PA($query,$parametros);
						if ($ejecutar===false){
						echo "Ocurrio un error";
						die( print_r( sqlsrv_errors(), true));
						$sw = 2;
						}
						else
						{

						$sw = 7;	// se agrego con exito

						}
		}
		else
		{
			$sw = $obj->validarAgregarPersona($codigoBarra,$filas,$filas2,$hora,$tipoOperacion,$estadoAsistencia,$asifila2,$fechaSalida,$ultimaHoraSalida,$tipoturno);
		}


		$codGrupo = $codGrupo; // envia el codigoGrupo
		$idTipoTurno = $tipoturno; // envia el codigoGrupo
		$pagina = $pagina;
		include_once("../formularios/tabla_asistenciaDiaria.php"); // carga el archivo de la tabla asistencia
		?>
		<div id="sw"><?php echo $sw; ?></div>
	
		<?php

	}// aqui termina la opcion de ejecutar las dos acciones restantes (agregar persona o agregar persona y hora.)

}


?>

