<?php
require_once("../../cont/CFunciones.php");
include("../../conectar.php");
include_once("../../verificar.php");
$obj = new Cfunciones;
if(isset($_POST["accion"]))
{
	$accion = $_POST["accion"];

	if ($accion == "EjecutarProcesoFiletero") 
	{

		 $id_ocupacion = $_POST['id_ocupacion'];
		 $id_Grupo = $_POST['id_Grupo'];
		 $id_cantidad = $_POST["id_cantidad"];
		 $pagina = $_POST["pagina"];

		 $DataHistorial = $_SERVER['HTTP_USER_AGENT'];
		 $usuario = $_SESSION['u_codigo'];

		 $ejeCodigo1 = $obj->consultar("select  distinct c.codigoRegistro from CabRegistroLab c
		inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
		inner join Ocupacion o on (o.codigoOcupacion=c.codigoOcupacion)
		inner join GrupoTrabajo g on (c.codigoOcupacion=g.codigoOcupacion)
		inner join DetalleCabRegistro d on (d.codigoRegistro=c.codigoRegistro)
		where t.estado=0 and c.codigoOcupacion='$id_ocupacion' and d.codigogrupo='$id_Grupo'");//obtengo codigo de registro
		$rows1 = sqlsrv_fetch_array($ejeCodigo1,SQLSRV_FETCH_ASSOC);
		$codigoRegistro = $rows1["codigoRegistro"];

		if(($obj->ValidarProcesoUND($id_cantidad)==1))
		{
			$query = "{call RegistoProcesoDinos(?,?,?)}";
				$parametros = array(
				 		array(&$codigoRegistro,SQLSRV_PARAM_IN),
				 		array(&$id_cantidad,SQLSRV_PARAM_IN),
				 		array(&$id_Grupo,SQLSRV_PARAM_IN));
						$ejecutarCall = $obj->ejecutar_PA($query,$parametros);
						if($ejecutarCall===false)
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
			$sw = $obj->ValidarProcesoUND($id_cantidad);
		}

	?>
	<div id="sw" class="respuestaMsg"><?php echo $sw; ?></div>
	<?php
		$id_Grupo = $id_Grupo;
		$pagina = $pagina;
		include_once("../formularios/tabla_ProcesosUnidades.php");		
	}

/*=============================================
EJECUTAR PROCESOS GRUPO KG
=============================================*/

		elseif ($accion == "EjecutarProcesoG") 
			{

			$id_ocupacion  = $_POST['id_ocupacion'];
			$id_Grupo = $_POST['id_Grupo'];
			$id_cantidad = $_POST['id_cantidad'];
			$pagina = $_POST["pagina"];
			$usuario = $_SESSION['u_codigo'];
			$CodProduc = $_POST['CodProducto'];

			$query1 = "select d.codDetalle from DetalleCabRegistro d
			inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
			inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
			inner join Ocupacion o on (o.codigoOcupacion=c.codigoOcupacion)
			where t.estado=0 and d.asistencia=1 and d.codigogrupo='$id_Grupo' and o.codigoOcupacion='$id_ocupacion' and (nolaboral=0 or nolaboral=2 or nolaboral=4)";
			$stmt = sqlsrv_query( $conectar, $query1, array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET )); // ejecutamos la funcion en forma nativa, sin utilizar el Objeto instacioado de la clase Cfunciones.
			
			$ejeCodigo2 = $obj->consultar("select distinct d.nolaboral,max(d.asistencia)as asistencia from DetalleCabRegistro d
			inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
			inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
			where d.codigogrupo='$id_Grupo' and t.estado=0 and (d.asistencia=1 or d.asistencia=2) and (d.nolaboral=3 or d.nolaboral=4 or d.nolaboral=0) group by d.nolaboral");
			$rows2 = sqlsrv_fetch_array($ejeCodigo2,SQLSRV_FETCH_ASSOC); //estados de grupo
			$estdonolabG = $rows2["nolaboral"];
			$asistenciaG = $rows2["asistencia"]; 

			$ejeCodigo3 = $obj->consultar("select distinct d.nolaboral,max(d.asistencia)as asistencia from DetalleCabRegistro d
			inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
			inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
			where d.codigogrupo='$id_Grupo' and t.estado=0 and (d.asistencia=1 or d.asistencia=2) and (d.nolaboral=1 or d.nolaboral=2 or d.nolaboral=0) group by d.nolaboral");
			$rows3 = sqlsrv_fetch_array($ejeCodigo3,SQLSRV_FETCH_ASSOC); // estados personal
			$estdonolabP = $rows3["nolaboral"];
			$asistenciaP = $rows3["asistencia"];
			$error=0;

			if(($obj->validarProcesosG($id_cantidad,$estdonolabG,$estdonolabP,$asistenciaG,$asistenciaP)==1))
			 { 
			 	$CantidaKG = $id_cantidad/sqlsrv_num_rows($stmt);
			 	while ($rows = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)) // llamamos al array $stmt el cual contiene todo lo devuelo por la consulta
				{

					$query = "{call insertar_DetalleporAvance(?,?,1,?,?,1)}";
					$parametros = array(
				 		array(&$CantidaKG,SQLSRV_PARAM_IN),
				 		array(&$rows["codDetalle"],SQLSRV_PARAM_IN),
			 			array(&$usuario,SQLSRV_PARAM_IN),
			 			array(&$CodProduc,SQLSRV_PARAM_IN));
						$ejecutarCall = $obj->ejecutar_PA($query,$parametros);
						if($ejecutarCall===false)
								{
									$error = $error + 1;
								}
				}

				if($error==0){
					$sw=1;
				}
				else{
					$sw=2;
				}
			 }
			 else
			 {
			 	$sw = $obj->validarProcesosG($id_cantidad,$estdonolabG,$estdonolabP,$asistenciaG,$asistenciaP);
			 }

			 ?>

			<div id="sw" class="respuestaMsg"><?php echo $sw; ?></div>
			<?php
			$id_Grupo = $id_Grupo;
			$pagina = $pagina;
			$ope = 1;
			include_once("../formularios/tabla_Registroprocesos.php");	
		}

/*=============================================
EJECUTAR PROCESOS PERSONAL KG 
=============================================*/

		elseif ($accion == "EjecutarProcesoP") 
		{

			$codigoBarras = $_POST['codigoBarras'];
			$id_ocupacion  = $_POST['id_ocupacion'];
			$id_Grupo = $_POST['id_Grupo'];
			$id_cantidad = $_POST['id_cantidad'];
			$pagina = $_POST["pagina"];
			$usuario = $_SESSION['u_codigo'];
			$CodProduc = $_POST['CodProducto'];

			$ejeCodigo = $obj->consultar("SELECT top 1 d.codDetalle,d.nolaboral,d.asistencia  from DetalleCabRegistro d
			inner join persona p on (d.codigoEmpleado=p.codigoEmpleado)
			inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
			inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
			where p.DNIempleado='$codigoBarras' and d.codigogrupo='$id_Grupo' and t.estado=0  and c.estado=1 order by d.codDetalle desc");

			$rows = sqlsrv_fetch_array($ejeCodigo,SQLSRV_FETCH_ASSOC);
			$Cod_Detalle =  $rows['codDetalle'];
			$nolaboral = $rows['nolaboral'];

			$asistencia = $rows['asistencia'];
			if(($obj->validarProcesosP($id_cantidad,$Cod_Detalle,$nolaboral,$asistencia)==1))
			{ 

			$query = "{call insertar_DetalleporAvance(?,?,1,?,?,0)}";
				$parametros = array(
				 		array(&$id_cantidad,SQLSRV_PARAM_IN),
				 		array(&$Cod_Detalle ,SQLSRV_PARAM_IN),
				 		array(&$usuario,SQLSRV_PARAM_IN),
				 		array(&$CodProduc,SQLSRV_PARAM_IN));
						$ejecutarCall = $obj->ejecutar_PA($query,$parametros);
						if($ejecutarCall===false)
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
			 	$sw = $obj->validarProcesosP($id_cantidad,$Cod_Detalle,$nolaboral,$asistencia);
			}
			?>
			<div id="sw" class="respuestaMsg"><?php echo $sw; ?></div>
			<?php
			$id_Grupo = $id_Grupo;
			$pagina = $pagina;
			$ope = 2;
			include_once("../formularios/tabla_Registroprocesos.php");


		
		}

/*=============================================
EJECUTAR PROCESOS PRECOCIDO
=============================================*/
	elseif ($accion == "RegistrarProcesoPrecocido") 
	{
		$id_ocupacion = $_POST["id_ocupacion"];
		$id_Grupo = $_POST["id_Grupo"];
		$id_cantidad = $_POST["id_cantidad"];
		$pagina = $_POST["pagina"];

		$DataHistorial = $_SERVER['HTTP_USER_AGENT'];
		$usuario = $_SESSION['u_codigo'];


		$ejeCodigo = $obj->consultar("select  distinct c.codigoRegistro from CabRegistroLab c
		inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
		inner join DetalleCabRegistro d on (d.codigoRegistro=c.codigoRegistro)
		where t.estado=0 and c.codigoOcupacion='$id_ocupacion' and d.codigogrupo='$id_Grupo' and c.estado=1");//CODIGO DE REGISTRO
		$rows = sqlsrv_fetch_array($ejeCodigo,SQLSRV_FETCH_ASSOC);
		$codigoRegistro = $rows["codigoRegistro"];

		if (($obj->ValidarProcesoPrecocido($id_cantidad)==1)) 
		{
			$query = "{call insertar_DetalleAvancePrecocido(?,?,?,?,?)}";
			$parametros = array(
			 		array(&$codigoRegistro,SQLSRV_PARAM_IN),
			 		array(&$id_Grupo,SQLSRV_PARAM_IN),
			 		array(&$id_cantidad,SQLSRV_PARAM_IN),
			 		array(&$DataHistorial,SQLSRV_PARAM_IN),
				 	array(&$usuario,SQLSRV_PARAM_IN),);
					$ejecutarCall = $obj->ejecutar_PA($query,$parametros);
					if($ejecutarCall===false)
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
			$sw = $obj->ValidarProcesoPrecocido($id_cantidad);
		}
		?>
		<div id="sw" class="respuestaMsg"><?php echo $sw; ?></div>
		<?php
		$id_Grupo = $id_Grupo;
		include_once("../formularios/tabla_procesoAvancePrecocido.php");
	}


	elseif ($accion == "enviarKGporcheck") {

			$_codDetalle = $_POST['codDetalle'];
			$_CantidaKG =$_POST['id_cantidad'];
			$id_Grupo= $_POST["codGrupo"];
			$pagina = $_POST["pagina"];
			$_tipo = $_POST["tipo"];
			$usuario = $_SESSION['u_codigo'];

			$ejeCodigo = $obj->consultar("SELECT CantidaKG FROM DetalleCabRegistro d
			inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
			inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
			WHERE d.codDetalle=$_codDetalle AND d.codigogrupo=$id_Grupo and t.estado=0");
			$rows = sqlsrv_fetch_array($ejeCodigo,SQLSRV_FETCH_ASSOC);

			$_CantidadBD = $rows['CantidaKG'];

		if (($obj->ValidarDatoCheck($_CantidaKG,$_CantidadBD,$_tipo)==1)) 
		{

			$query = "{call insertar_DetalleporAvance(?,?,?,?,NULL,0)}";

			$parametros = array(
			array(&$_CantidaKG,SQLSRV_PARAM_IN),
			array(&$_codDetalle,SQLSRV_PARAM_IN),
			array(&$_tipo,SQLSRV_PARAM_IN),
			array(&$usuario,SQLSRV_PARAM_IN));
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
			$sw = $obj->ValidarDatoCheck($_CantidaKG,$_CantidadBD,$_tipo);
		}

		?>
		<div id="sw" class="respuestaMsg"><?php echo $sw; ?></div>
		<?php
			$id_Grupo = $id_Grupo;
			$pagina = $pagina;
			$ope = 2;
			include_once("../formularios/tabla_Registroprocesos.php");

	}

	elseif ($accion == "EnvioManualGkg") {
		$id_ocupacion = $_POST['id_ocupacion'];
		$id_Grupo = $_POST['id_Grupo'];
		$id_cantidad = $_POST['id_cantidad'];
		$Hora_inicio = $_POST["Hora_inicio"];
		$Hora_Fin = $_POST["Hora_Fin"];
		$usuario = $_SESSION['u_codigo'];

		$query2="select o.CodigoTipotarifa from Ocupacion o
		where o.codigoOcupacion='$id_ocupacion'";
		$smtv2=$obj->consultar($query2);
		$row3 = sqlsrv_fetch_array($smtv2,SQLSRV_FETCH_ASSOC);
		$tarifa = $row3['CodigoTipotarifa'];

		$query1 = "select d.codDetalle from DetalleCabRegistro d
		inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
		inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
		where t.estado=0 and d.codigogrupo='$id_Grupo' and d.Estado=1 and (nolaboral=0 or nolaboral=2 or nolaboral=4 or isnull(nolaboral,0)=0)";//4 INGRESO MANUAK
		$stmt = sqlsrv_query( $conectar, $query1, array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET )); // ejecutamos la funcion en forma nativa, sin utilizar el Objeto instacioado de la clase Cfunciones.
		$error=0;

		if(($obj->ValidarIngresoManual($id_cantidad)==1))
		{ 
			if ($tarifa==1) {
				$CantidaKG = 0;
			}
			elseif ($tarifa==2) {
				$CantidaKG = $id_cantidad/sqlsrv_num_rows($stmt);
			}

			$inicio = date("Ymd H:i:s",strtotime($_POST["Hora_inicio"]));
			$Fin = date("Ymd H:i:s",strtotime($_POST["Hora_Fin"]));

			 	while ($rows = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)) // llamamos al array $stmt el cual contiene todo lo devuelo por la consulta
				{
					$query = "{call insertar_DetalleporAvance_Manual(?,?,?,?,0,0,?)}";
					$parametros = array(
				 		array(&$CantidaKG,SQLSRV_PARAM_IN),
				 		array(&$rows["codDetalle"],SQLSRV_PARAM_IN),
			 			array(&$inicio,SQLSRV_PARAM_IN),
			 			array(&$Fin,SQLSRV_PARAM_IN),
			 			array(&$usuario,SQLSRV_PARAM_IN));
						$ejecutarCall = $obj->ejecutar_PA($query,$parametros);
						if($ejecutarCall===false)
								{
									$error = $error + 1;
								}
				}

				if($error==0){
					$sw=1;
				}
				else{
					$sw=2;
				}
		}else
		{
			$sw = $obj->ValidarIngresoManual($id_cantidad);
		}


	?>
	<div id="sw" class="respuestaMsg"><?php echo $sw; ?></div>
			<?php
			$id_Grupo = $id_Grupo;
			include_once("../formularios/tabla_RegistroprocesosGM.php");
	}

	elseif ($accion == "AgregarPersonaManual") {
		$id_ocupacion = $_POST['id_ocupacion'];
		$id_Grupo = $_POST['id_Grupo'];
		$Hora_inicio = $_POST["Hora_inicio"];
		$Hora_Fin = $_POST["Hora_Fin"];
		$dniPersonal = trim($_POST['dniPersonal']);
		$usuario = $_SESSION['u_codigo'];
		$idaccion = $_POST['idaccion'];

		$ejeCodigo1 = $obj->consultar("select  distinct c.codigoRegistro from CabRegistroLab c
		inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
		inner join Ocupacion o on (o.codigoOcupacion=c.codigoOcupacion)
		inner join GrupoTrabajo g on (c.codigoOcupacion=g.codigoOcupacion)
		inner join DetalleCabRegistro d on (d.codigoRegistro=c.codigoRegistro)
		where t.estado=0 and c.codigoOcupacion='$id_ocupacion' and d.codigogrupo='$id_Grupo'");//obtengo codigo de registro
		$rows1 = sqlsrv_fetch_array($ejeCodigo1,SQLSRV_FETCH_ASSOC);
		$codigoRegistro = $rows1["codigoRegistro"];

		$ejeCodigo = $obj->consultar("select codigoEmpleado from persona where DNIempleado='$dniPersonal'");//verifica que existe personal
		$filas = sqlsrv_num_rows($ejeCodigo);
		$rows = sqlsrv_fetch_array($ejeCodigo,SQLSRV_FETCH_ASSOC);
		// if(isset($rows["codigoEmpleado"])){
		//    $codigoEmpleado = $rows["codigoEmpleado"];
		// }
		 $codigoEmpleado = $rows["codigoEmpleado"];

		$ejeCodigo2 = $obj->consultar("select top 1 d.asistencia,CONVERT (char(5), d.fechaSalida, 108) as fimlaboral from DetalleCabRegistro d
			inner join CabRegistroLab  c on (c.codigoRegistro=d.codigoRegistro)
			inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
			where t.estado=0 and d.codigoEmpleado='$codigoEmpleado' and d.codigogrupo='$id_Grupo' and d.codigoRegistro='$codigoRegistro'
			ORDER BY d.codDetalle DESC");//verifica que existe personal en el grupo de trabajo actual 
		$filas2 = sqlsrv_num_rows($ejeCodigo2);
		$rows2 = sqlsrv_fetch_array($ejeCodigo2,SQLSRV_FETCH_ASSOC);
		
		if(($obj->ValidarIngresoManualADD($filas,$dniPersonal,$filas2,$idaccion)==1)){

			$inicio = date("Ymd H:i:s",strtotime($_POST["Hora_inicio"]));
			$Fin = date("Ymd H:i:s",strtotime($_POST["Hora_Fin"]));

			$query = "{CALL insertar_DetalleporAvance_Manual(0,?,?,?,?,?,?,?)}";
			$parametros = array(
				array(&$codigoEmpleado,SQLSRV_PARAM_IN),
				array(&$inicio,SQLSRV_PARAM_IN),
				array(&$Fin,SQLSRV_PARAM_IN),
				array(&$id_Grupo,SQLSRV_PARAM_IN),
				array(&$idaccion,SQLSRV_PARAM_IN),
				array(&$usuario,SQLSRV_PARAM_IN),
				array(&$id_ocupacion,SQLSRV_PARAM_IN));
			$ejecutarCall = $obj->ejecutar_PA($query,$parametros);
			if ($ejecutarCall===false){
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
			$sw = $obj->ValidarIngresoManualADD($filas,$dniPersonal,$filas2,$idaccion);
		}



	?>
	<div id="sw" class="respuestaMsg"><?php echo $sw; ?></div>
	<?php
			$id_Grupo = $id_Grupo;
			include_once("../formularios/tabla_RegistroprocesosGM.php");
	}

	elseif ($accion == "EnvioManualPkg") {

		$id_ocupacion = $_POST['id_ocupacion'];
		$id_Grupo = $_POST['id_Grupo'];
		$id_cantidad = $_POST['id_cantidad'];
		$Hora_inicio = $_POST["Hora_inicio"];
		$Hora_Fin = $_POST["Hora_Fin"];
		$dniPersonal = trim($_POST['dniPersonal']);
		$usuario = $_SESSION['u_codigo'];
		$idaccion = $_POST['idaccion'];

		$query2="select o.CodigoTipotarifa from Ocupacion o
		where o.codigoOcupacion='$id_ocupacion'";
		$smtv2=$obj->consultar($query2);
		$row2 = sqlsrv_fetch_array($smtv2,SQLSRV_FETCH_ASSOC);
		$tarifa = $row2['CodigoTipotarifa'];

		$ejeCodigo = $obj->consultar("SELECT top 1 d.codDetalle,d.nolaboral,d.asistencia ,CONVERT(varchar(16),d.fechaIngreso,120) as inicio,CONVERT(varchar(16),d.fechaSalida,120) as fin 
		from DetalleCabRegistro d
		inner join persona p on (d.codigoEmpleado=p.codigoEmpleado)
		inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
		inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
		where d.codigogrupo='$id_Grupo' and p.DNIempleado='$dniPersonal' and t.estado=0  and c.estado=1 and d.Estado=1 
		and (d.asistencia=0 or d.asistencia=3) order by d.codDetalle desc");
		$filas = sqlsrv_num_rows($ejeCodigo);
		$rows = sqlsrv_fetch_array($ejeCodigo,SQLSRV_FETCH_ASSOC);
		$Cod_Detalle =  $rows['codDetalle'];
		$Finicio =  $rows['inicio']; 
		$FinFin =  $rows['fin'];
		$asistencia = $rows['asistencia'];


		$query3="SELECT CONVERT(nvarchar(10),fechaturno,120)as fechaturno FROM TurnoGenerado where estado=0";
		$smtv3=$obj->consultar($query3);
		$row3 = sqlsrv_fetch_array($smtv3,SQLSRV_FETCH_ASSOC);
		$FechaTurno =  $row3['fechaturno'];

		if(($obj->ValidarIngresoManualP($dniPersonal,$id_cantidad,$filas,$Finicio,$FinFin,$asistencia,$Hora_inicio,$Hora_Fin,$tarifa,$idaccion,$FechaTurno)==1))
		{
			if ($tarifa==1) {
				$id_cantidad = (double) "0.0";
			}

			$inicio = date("Ymd H:i:s",strtotime($_POST["Hora_inicio"]));
			$Fin = date("Ymd H:i:s",strtotime($_POST["Hora_Fin"]));

			$query = "{call insertar_DetalleporAvance_Manual(?,?,?,?,?,?,?)}";
			$parametros = array(
				array(&$id_cantidad,SQLSRV_PARAM_IN),
				array(&$Cod_Detalle,SQLSRV_PARAM_IN),
				array(&$inicio,SQLSRV_PARAM_IN),
				array(&$Fin,SQLSRV_PARAM_IN),
				array(&$id_Grupo,SQLSRV_PARAM_IN),
				array(&$idaccion,SQLSRV_PARAM_IN),
				array(&$usuario,SQLSRV_PARAM_IN));
			$ejecutarCall = $obj->ejecutar_PA($query,$parametros);
			if ($ejecutarCall===false){
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
			$sw = $obj->ValidarIngresoManualP($dniPersonal,$id_cantidad,$filas,$Finicio,$FinFin,$asistencia,$Hora_inicio,$Hora_Fin,$tarifa,$idaccion,$FechaTurno);
		}

			?>
			<div id="sw" class="respuestaMsg"><?php echo $sw; ?></div>
			<?php
			$id_Grupo = $id_Grupo;
			include_once("../formularios/tabla_RegistroprocesosGM.php");

	}

	elseif ($accion == 'RegistroAcionesManuales') {

		 $idDetalle = trim($_POST['idDetalle']);
		 $id_Grupo = trim($_POST['idGrupo']);
		 $id_Ocupacion = trim($_POST['idOcupacion']);
		 $Hora_inicio = $_POST["Hora_inicio"];
		 $Hora_Fin =$_POST["Hora_Fin"];
		 $IdMov = $_POST['IdMov'];

	 	$ejeCodigo = $obj->consultar("SELECT CantidaKG FROM DetalleCabRegistro d
		inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
		inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
		inner join Ocupacion o on (o.codigoOcupacion=c.codigoOcupacion)
		WHERE d.codDetalle='$idDetalle' AND d.codigogrupo='$id_Grupo' and o.codigoOcupacion='$id_Ocupacion' and t.estado=0 and d.estado=1");
		$rows = sqlsrv_fetch_array($ejeCodigo,SQLSRV_FETCH_ASSOC);
		$_CantidadBD = $rows['CantidaKG'];

		$query2="select o.CodigoTipotarifa from Ocupacion o
		where o.codigoOcupacion='$id_Ocupacion'";
		$smtv2=$obj->consultar($query2);
		$row2 = sqlsrv_fetch_array($smtv2,SQLSRV_FETCH_ASSOC);
		$tarifa = $row2['CodigoTipotarifa'];

		$query3="SELECT CONVERT(nvarchar(10),fechaturno,120)as fechaturno FROM TurnoGenerado where estado=0";
		$smtv3=$obj->consultar($query3);
		$row3 = sqlsrv_fetch_array($smtv3,SQLSRV_FETCH_ASSOC);
		$FechaTurno =  $row3['fechaturno'];

		if (($obj->ValidarAccionesManuales($_CantidadBD,$IdMov,$tarifa,$FechaTurno,$Hora_inicio)==1)) 
		{
			$inicio = date("Ymd H:i:s",strtotime($_POST["Hora_inicio"]));
			$Fin = date("Ymd H:i:s",strtotime($_POST["Hora_Fin"]));

			$query = "{call SP_AccionesManuales(?,?,?,?)}";
			$parametros = array(
				array(&$idDetalle,SQLSRV_PARAM_IN),
				array(&$inicio,SQLSRV_PARAM_IN),
				array(&$Fin,SQLSRV_PARAM_IN),
				array(&$IdMov,SQLSRV_PARAM_IN));
			$ejecutarCall = $obj->ejecutar_PA($query,$parametros);
			if ($ejecutarCall===false){
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
			$sw = $obj->ValidarAccionesManuales($_CantidadBD,$IdMov,$tarifa,$FechaTurno,$Hora_inicio);
		}

		?>
			<div id="sw" class="respuestaMsg"><?php echo $sw; ?></div>
		<?php
			$id_Grupo = $id_Grupo;
			include_once("../formularios/tabla_RegistroprocesosGM.php");


	}
	elseif ($accion == "enviarKGporcheckManual") {

			$_codDetalle = $_POST['codDetalle'];
			$_CantidaKG =$_POST['id_cantidad'];
			$id_Grupo= $_POST["codGrupo"];
			$_tipo = $_POST["tipo"];
			$usuario = $_SESSION['u_codigo'];
			$Frm = $_POST['Frm'];
			$pagina = $_POST['pagina'];
			$CodProduc = $_POST['CodProducto'];

			$ejeCodigo = $obj->consultar("SELECT CantidaKG,DATEPART(YEAR,ISNULL(d.fechaIngreso,''))AS datoFec FROM DetalleCabRegistro d
			inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
			inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
			WHERE d.codDetalle=$_codDetalle AND d.codigogrupo=$id_Grupo and t.estado=0");
			$rows = sqlsrv_fetch_array($ejeCodigo,SQLSRV_FETCH_ASSOC);

			$_CantidadBD = $rows['CantidaKG'];
			$_MinBD = $rows['datoFec'];

		if (($obj->ValidarDatoCheck($_CantidaKG,$_CantidadBD,$_tipo,$_MinBD)==1)) 
		{

			$query = "{call insertar_DetalleporAvance(?,?,?,?,?,0)}";

			$parametros = array(
			array(&$_CantidaKG,SQLSRV_PARAM_IN),
			array(&$_codDetalle,SQLSRV_PARAM_IN),
			array(&$_tipo,SQLSRV_PARAM_IN),
			array(&$usuario,SQLSRV_PARAM_IN),
			array(&$CodProduc,SQLSRV_PARAM_IN));
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
			$sw = $obj->ValidarDatoCheck($_CantidaKG,$_CantidadBD,$_tipo,$_MinBD);
		}

		?>
		<div id="sw" class="respuestaMsg"><?php echo $sw; ?></div>
		<?php
			$id_Grupo = $id_Grupo;
			
			if ($Frm=='PRO'){
			$pagina = $pagina;
			$ope = 2;
			include_once("../formularios/tabla_Registroprocesos.php");}
			else{ include_once("../formularios/tabla_RegistroprocesosGM.php");}

	}
		elseif ($accion == "EnvioManualGkgCheck") {

		$id_ocupacion = $_POST['id_ocupacion'];
		$id_Grupo = $_POST['id_Grupo'];
		$id_cantidad = $_POST['id_cantidad'];
		$Hora_inicio = $_POST["Hora_inicio"];
		$Hora_Fin = $_POST["Hora_Fin"];
		$Cod_Detalle = trim($_POST['idcodigo']);
		$usuario = $_SESSION['u_codigo'];
		$idaccion = $_POST['idaccion'];
		$query2="select o.CodigoTipotarifa from Ocupacion o
		where o.codigoOcupacion='$id_ocupacion'";
		$smtv2=$obj->consultar($query2);
		$row2 = sqlsrv_fetch_array($smtv2,SQLSRV_FETCH_ASSOC);
		$tarifa = $row2['CodigoTipotarifa'];

		$query3="SELECT CONVERT(nvarchar(10),fechaturno,120)as fechaturno FROM TurnoGenerado where estado=0";
		$smtv3=$obj->consultar($query3);
		$row3 = sqlsrv_fetch_array($smtv3,SQLSRV_FETCH_ASSOC);
		$FechaTurno =  $row3['fechaturno'];

		if ($tarifa==1) {
				$id_cantidad = (double) "0.0";
			}

		if (($obj->ValidarIngresoDatoCheck($id_cantidad,$Hora_inicio,$Hora_Fin,$idaccion,$FechaTurno)==1)) 
		{
			$inicio = date("Ymd H:i:s",strtotime($_POST["Hora_inicio"]));
			$Fin = date("Ymd H:i:s",strtotime($_POST["Hora_Fin"]));

			$query = "{call insertar_DetalleporAvance_Manual(?,?,?,?,?,?,?)}";
			$parametros = array(
				array(&$id_cantidad,SQLSRV_PARAM_IN),
				array(&$Cod_Detalle,SQLSRV_PARAM_IN),
				array(&$inicio,SQLSRV_PARAM_IN),
				array(&$Fin,SQLSRV_PARAM_IN),
				array(&$id_Grupo,SQLSRV_PARAM_IN),
				array(&$idaccion,SQLSRV_PARAM_IN),
				array(&$usuario,SQLSRV_PARAM_IN),
				array(&$id_ocupacion,SQLSRV_PARAM_IN));
			$ejecutarCall = $obj->ejecutar_PA($query,$parametros);
			if ($ejecutarCall===false){
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
			$sw = $obj->ValidarIngresoDatoCheck($id_cantidad,$Hora_inicio,$Hora_Fin,$idaccion,$FechaTurno);
		}
		
	

			?>
			<div id="sw" class="respuestaMsg"><?php echo $sw; ?></div>
			<?php
			$id_Grupo = $id_Grupo;
			include_once("../formularios/tabla_RegistroprocesosGM.php");

	}


}
?>