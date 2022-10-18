<?php
require_once("../../cont/CFunciones.php");
include("../../conectar.php");
include_once("../../verificar.php");
$obj = new Cfunciones;
if(isset($_POST["accion"]))
{
	$accion = $_POST["accion"];

/*=============================================
REGISTRO HORA NO LABORAL PERSONA
=============================================*/

	 if($accion == "registroNoLab")
	 {
	 	$codigoBarra = $_POST["codigoBarra"];
	 	$id_Grupo = $_POST["id_Grupo"];
	 	$id_ocupacion = $_POST["id_ocupacion"];
	 	$idTipoSalida = $_POST["idTipoSalida"];
	 	$idTipoProceso = $_POST["idTipoProceso"];
	 	$hora = $_POST["hora"];
	 	$pagina = $_POST["pagina"];

	 	$DataHistorial = $_SERVER['HTTP_USER_AGENT'];
		$usuario = $_SESSION['u_codigo'];

		$ejeCodigo = $obj->consultar("select d.codDetalle, d.asistencia,CONVERT (char(5), d.fechaIngreso, 108) as inciolaboral from DetalleCabRegistro d
		inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
		inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
		inner join persona p on (d.codigoEmpleado=p.codigoEmpleado)
		where t.estado=0 and d.codigogrupo='$id_Grupo' and p.DNIempleado='$codigoBarra' and (d.asistencia=1 or d.asistencia=0)");
		$filas = sqlsrv_num_rows($ejeCodigo);
		$rows = sqlsrv_fetch_array($ejeCodigo,SQLSRV_FETCH_ASSOC);//VERIFA GRUPO DE TRABAJO

		$ejeCodigo2 = $obj->consultar("select r.id, r.tipo,CONVERT (char(5), r.inicio, 108) as inicio from DetalleCabRegistro d
		inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
		inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno) 
		inner join reghorasNolaborables r on (d.codDetalle=r.codigodetallelaboral)
		inner join persona p on (p.codigoEmpleado=d.codigoEmpleado)
		where t.estado=0  and p.DNIempleado='$codigoBarra' and d.codigogrupo='$id_Grupo' and r.tipo=1 ");
		$rows2 = sqlsrv_fetch_array($ejeCodigo2,SQLSRV_FETCH_ASSOC); // encuentra el id de horas no laborables.

		$ejeCodigo3 = $obj->consultar("select TOP(1) r.id,r.codigoTipoSalida,r.codigodetallelaboral, r.tipo ,CONVERT (char(5), r.inicio, 108) as inicio, CONVERT (char(5), r.fim, 108) as fin
		from DetalleCabRegistro d
		inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
		inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno) 
		inner join reghorasNolaborables r on (d.codDetalle=r.codigodetallelaboral)
		inner join persona p on (p.codigoEmpleado=d.codigoEmpleado)
		where t.estado=0  and p.DNIempleado='$codigoBarra' and d.codigogrupo='$id_Grupo' and r.tipo=2 ORDER BY ID DESC");
		$rows3 = sqlsrv_fetch_array($ejeCodigo3,SQLSRV_FETCH_ASSOC); // encuentra la ultima hora registrada con estado 2.



		$tipoAsistencia = $rows2["tipo"];
		$horaInicio = $rows2["inicio"];
		$estadoAsistencia = $rows["asistencia"];
		$horaInicioLaboral = $rows["inciolaboral"];

		$horainicioEnd = $rows3["inicio"]; // ultima hora de inicio con estado de tipo=2
		$horafinEnd = $rows3["fin"]; // ultima hora de fin con estado de tipo=2
		$tipoSalida = $rows3["codigoTipoSalida"];// tipo de salida
		

		if(($obj->validarDatos($filas,$hora,$tipoAsistencia,$idTipoProceso,$horaInicio,$estadoAsistencia,$horaInicioLaboral,$idTipoSalida,$horafinEnd)==1))
		{

			$Data = 'Horas no Laboral Por Persona/grupo -> '.$id_Grupo.'/ocupacion -> '.$id_ocupacion.'/salida -> '.$idTipoSalida.'/proceso ->'.$idTipoProceso.'/hora ->'.$hora;

			$horaarray = explode(":", $hora); // separa la hora en dos dentro de un array
			$NroHoras = (int) $horaarray[0];
			$NroMinut = (int) $horaarray[1];
		 	$query = "{call regHorasnolaborable(?,?,?,?,?,?)}";
		 	$parametros = array(
		 		array(&$rows2["id"],SQLSRV_PARAM_IN),
		 		array(&$rows["codDetalle"],SQLSRV_PARAM_IN),
				array(&$idTipoSalida,SQLSRV_PARAM_IN),
				array(&$NroHoras,SQLSRV_PARAM_IN),
				array(&$NroMinut,SQLSRV_PARAM_IN),
				array(&$idTipoProceso,SQLSRV_PARAM_IN),);
			$ejecutar = $obj->ejecutar_PA($query,$parametros);

			$query2 = "{call registrarhistorial(?,?,?,?)}";
		 	$parametros2 = array(
		 		array(&$rows["codDetalle"],SQLSRV_PARAM_IN),
		 		array(&$Data,SQLSRV_PARAM_IN),
				array(&$DataHistorial,SQLSRV_PARAM_IN),
				array(&$usuario,SQLSRV_PARAM_IN),);
			$ejecutar2 = $obj->ejecutar_PA($query2,$parametros2);


					if(($ejecutar===false) and ($ejecutar2 ===false))
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
			$sw = $obj->validarDatos($filas,$hora,$tipoAsistencia,$idTipoProceso,$horaInicio,$estadoAsistencia,$horaInicioLaboral,$idTipoSalida,$horafinEnd);
		}
		
		?>
		<div id="sw" class="respuestaMsg"><?php echo $sw; ?></div>
		<?php
		$id_Grupo = $id_Grupo;
		$pagina = $pagina;
		include_once("../formularios/tabla_horasnolaborables.php");


	 }//if guarda registroNoLab por persona

/*=============================================
REGISTRO HORA NO LABORAL GRUPO
=============================================*/

	 elseif ($accion == "enviardatosgrupo") 
	 {
	 	$id_Grupo = $_POST["id_Grupo"];
	 	$idTipoSalida = $_POST["idTipoSalida"];// tipo de salida (ref/permi)
	 	$idTipoProceso = $_POST["idTipoProceso"];//inicio fim
	 	$hora = $_POST["hora"];
	 	$iddetalle = 0;
	 	$pagina = $_POST["pagina"];

	 	$DataHistorial = $_SERVER['HTTP_USER_AGENT'];
		$usuario = $_SESSION['u_codigo'];

	 	$ejeCodigo = $obj->consultar("SELECT sum(d.asistencia)as estado,COUNT(*)as totalfilas,sum(d.nolaboral)as nolab
							FROM DetalleCabRegistro  d
							inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
							inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
							inner join persona p on (d.codigoEmpleado=p.codigoEmpleado)
							WHERE d.codigogrupo='$id_Grupo' and t.estado=0 ");
		$rows = sqlsrv_fetch_array($ejeCodigo,SQLSRV_FETCH_ASSOC);

		$ejeCodigo2 = $obj->consultar("SELECT distinct r.codigoTipoSalida,d.nolaboral,r.tipo,CONVERT (char(5), r.inicio, 108) as inicio from reghorasNolaborables r
							inner join DetalleCabRegistro d on(d.codDetalle=r.codigodetallelaboral)
							inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
							inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
							inner join persona p on (d.codigoEmpleado=p.codigoEmpleado)
							WHERE d.codigogrupo='$id_Grupo'and t.estado=0 and r.tipo=1 and d.nolaboral=3");
		$rows2 = sqlsrv_fetch_array($ejeCodigo2,SQLSRV_FETCH_ASSOC);

		$ejeCodigo3 = $obj->consultar("SELECT distinct CONVERT (char(5), d.fechaIngreso, 108) as inciolaboral
							FROM DetalleCabRegistro  d
							inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
							inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
							inner join persona p on (d.codigoEmpleado=p.codigoEmpleado)
							WHERE d.codigogrupo='$id_Grupo' and t.estado=0 and d.asistencia=1 and d.nolaboral=0");
		$rows3 = sqlsrv_fetch_array($ejeCodigo3,SQLSRV_FETCH_ASSOC);


		$total = $rows["nolab"];
		$estado = $rows["estado"];
		$estdonolab = $rows2["nolaboral"];
		$horaInicio = $rows2["inicio"];
		$horaInicioLaboral = $rows3["inciolaboral"];
		$codigoTipoSalida = $rows2["codigoTipoSalida"];

		if(($obj->validarDatosdeGrupo($hora,$idTipoSalida,$total ,$estado,$estdonolab,$idTipoProceso,$horaInicio,$horaInicioLaboral,$codigoTipoSalida)==1))
		{
			
	// @_codigogrupo int,
	// @_codTipoSalida int,
	// @_tipoAsistencia int,
	// @_hora int,
	// @_min int
	
			$Data = 'Horas no Laborables Grupo/ Grupo ->'.$id_Grupo.'/TipoSalida ->'.$idTipoSalida.'/Proceso ->'.$idTipoProceso.'/ Hora ->'.$hora;

			$horaarray = explode(":", $hora); // separa la hora en dos dentro de un array
			$NroHoras = (int) $horaarray[0];
			$NroMinut = (int) $horaarray[1];

			$query = "{call regGrupoHorasnoLab(?,?,?,?,?,1)}";
				$parametros = array(
			 		array(&$id_Grupo,SQLSRV_PARAM_IN),
			 		array(&$idTipoSalida ,SQLSRV_PARAM_IN),
			 		array(&$idTipoProceso ,SQLSRV_PARAM_IN),
			 		array(&$NroHoras,SQLSRV_PARAM_IN),
			 		array(&$NroMinut,SQLSRV_PARAM_IN),);
					$ejecutarCall = $obj->ejecutar_PA($query,$parametros);

			$query2 = "{call registrarhistorial(?,?,?,?)}";
		 	$parametros2 = array(
		 		array(&$rows["codDetalle"],SQLSRV_PARAM_IN),
		 		array(&$Data,SQLSRV_PARAM_IN),
				array(&$DataHistorial,SQLSRV_PARAM_IN),
				array(&$usuario,SQLSRV_PARAM_IN),);
			$ejecutar2 = $obj->ejecutar_PA($query2,$parametros2);



					if(($ejecutarCall===false) and($ejecutar2===false))
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
			$sw = $obj->validarDatosdeGrupo($hora,$idTipoSalida,$total ,$estado,$estdonolab,$idTipoProceso,$horaInicio,$horaInicioLaboral,$codigoTipoSalida);
		}
		?>
		<div id="sw" class="respuestaMsg"><?php echo $sw; ?></div>
		<?php
		$id_Grupo = $id_Grupo;
		$pagina = $pagina;
		include_once("../formularios/tabla_horasnolaborables.php");

	 }

	 // elseif ($accion == "enviar_paginador")
	 // {
	 // 	$pagina = $_POST["pagina"];
	 // 	$tipoturno= $_POST["tipo"];
		// $codGrupo= $_POST["grupo"];
		// $NumeroFilas = $_POST["NumeroFilas"];

		// $codGrupo = $codGrupo; // envia el codigoGrupo
		// $idTipoTurno = $tipoturno; // envia el codigoGrupo
		// include_once("../formularios/tabla_asistenciaDiaria.php"); // carga el archivo de la tabla
		
	 // }

/*=============================================
REGISTRO DE MATERIA PRIMA
=============================================*/

	elseif ($accion == "RegistraringresoMP"){

		$horaid = $_POST['horaid'];
		$id_cantidad = $_POST['id_cantidad'];
		$turno = $_POST['turno'];
		$id_Especie = $_POST['id_Especie'];
		$id_tiporecep = $_POST['id_tiporecep'];
		$Obs = $_POST['Obs'];
		$id_usuario = $_SESSION['u_codigo'];
		$id_embarcacion = $_POST['id_embarcacion'];
		 if(($obj->validarRecepcionMP($id_cantidad,$id_Especie,$id_tiporecep,$horaid)==1))
		 {

		// @_idtuno int,
		// @_idespecie int,
		// @_idtiporecp int,
		// @_idusuario int,
		// @_hora int,
		// @_min int,
		// @_Cantidadmp decimal(18,3),
		// @_obs varchar(max)
			$horaarray = explode(":", $horaid); // separa la hora en dos dentro de un array
			$NroHoras = (int) $horaarray[0];
			$NroMinut = (int) $horaarray[1];
			$query = "{call RegistrodeMateriaPrima(?,?,?,?,?,?,?,?,?)}";
			$parametros = array(
			 		array(&$turno,SQLSRV_PARAM_IN),
			 		array(&$id_Especie ,SQLSRV_PARAM_IN),
			 		array(&$id_tiporecep,SQLSRV_PARAM_IN),
			 		array(&$id_usuario,SQLSRV_PARAM_IN),
					array(&$NroHoras,SQLSRV_PARAM_IN),
					array(&$NroMinut,SQLSRV_PARAM_IN),
					array(&$id_cantidad,SQLSRV_PARAM_IN),
					array(&$Obs,SQLSRV_PARAM_IN),
					array(&$id_embarcacion,SQLSRV_PARAM_IN),);
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
		 	$sw = $obj->validarRecepcionMP($id_cantidad,$id_Especie,$id_tiporecep,$horaid);
		 }
		  ?>
		<div id="sw" class="respuestaMsg"><?php echo $sw; ?></div>
		<?php
		include_once("../formularios/tabla_registroMateriaprima.php");

	}// fin registro materia prima
	
/*=============================================
BUSCADOR DE EMBARCACIONES
=============================================*/

	elseif ($accion == "buscarEmbarcacion") {
			$dato = $_POST['dato'];
			$output = '';
			if ($dato <> "") {
				$query = $obj->consultar("SELECT top 3 CONCAT(nombre,' / MATRICULA (',matricula,')')as embarcacion,id_em,nombre,nombre2 FROM embarcacion WHERE nombre LIKE '%$dato%' OR matricula LIKE '%$dato%'");
			$numeroFilas = sqlsrv_num_rows($query);
		
			if($numeroFilas>0)
			{
				while($row = sqlsrv_fetch_array($query,SQLSRV_FETCH_ASSOC))
				{ ?>
					<li   onclick="mostrarDatos('<?php echo $row["id_em"]; ?>','<?php echo $row["embarcacion"]; ?>')"><?php echo $row["nombre2"] ?></li>
				<?php }
			} 
			else
			{
				$output .= '<li>Noy hay Datos</li>';  
			}
			
      		
			}
			
			

	}

/*=============================================
ELIMINAR ASISTENCIA 
=============================================*/

	elseif ($accion == "eliminarA") {

		$codigoDetalle = $_POST["codigo"];
		$idTipoTurno = $_POST["idTipoTurno"];
		$por_pagina = $_POST["por_pagina"];
		$pagina = $_POST["pagina"];
		$codGrupo = $_POST["codigogrupo"];
		$OrdenarTabla = $_POST["OrdenarTabla"];

		// if(($obj->EliminarAsistencia()==1))
		// {
			$query = "{call EliminarRegistro(1,?,0)}";
			$parametros = array(
			 		array(&$codigoDetalle,SQLSRV_PARAM_IN),);
					$ejecutarCall = $obj->ejecutar_PA($query,$parametros);

			if(($ejecutarCall === false))
			{
				echo "Ocurrio un error";
				die( print_r( sqlsrv_errors(), true));
				$sw = 2;
			}
			else
			{
				$sw = 1;
			}
		// }

		// else
		// {
		// 	$sw = $obj->validarRecepcionMP();
		// }

		?>
		<div id="sw" class="respuestaMsg"><?php echo $sw; ?></div>

		<?php
		$ordenar = $OrdenarTabla;
		$por_pagina = $por_pagina;
		$idTipoTurno = $idTipoTurno; 
		$pagina = $pagina;
		$codGrupo = $codGrupo;
		include_once("../formularios/tabla_asistenciaDiaria.php"); // carga el archivo de la tabla asistencia
 
	}// termina if elimina asistencia

/*=============================================
ELIMINAR HORA NO LABOARAL
=============================================*/

	elseif ($accion == "eliminarhoranolaboral") {

		$codigodetalle = $_POST["codigodetalle"];
		$pagina = $_POST["pagina"]; 
		$por_pagina = $_POST["por_pagina"];
		$id_Grupo = $_POST["codigogrupo"];
		$id = $_POST["id"]; 
		$nolaboral = $_POST["nolaboral"];//observar

			$query = "{call EliminarRegistro(2,?,?)}";
			$parametros = array(
			 		array(&$codigodetalle,SQLSRV_PARAM_IN),
			 		array(&$id,SQLSRV_PARAM_IN),);
					$ejecutarCall = $obj->ejecutar_PA($query,$parametros);

			if(($ejecutarCall === false))
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
		$por_pagina = $por_pagina;
		$pagina = $pagina;
		$id_Grupo = $id_Grupo;
		include_once("../formularios/tabla_horasnolaborables.php"); // carga el archivo de la tabla asistencia

	}
	elseif ($accion == 'ejecutar') {
		$img = $_POST["foto"];
		$codigoEmpleado = $_POST["codigoEmpleado"];

		$query = $obj->consultar("select foto,DNIempleado,concat(APEPATempleado,' ',APEMATempleado) as apellidos,NombresEmpleado from persona where codigoEmpleado='$codigoEmpleado'");
		$row = sqlsrv_fetch_array($query,SQLSRV_FETCH_ASSOC);

		?>  

	<div class="container-fluid" style="padding-left: 0px; padding-right: 0px;">
		<div class="row">
			<div class="col-xs-12 col-md-12 col-sm-12" style="padding-left: 0px; padding-right: 0px;">
				<div class="img-container">
			<img onerror="this.onerror=null;this.src='img/obrero/nofount.jpg';" src="<?php echo $img; ?>" class="modal-content" />
				</div>
			</div>
		</div>
		<div class="line1"></div>
		<div>
			<div class="row">
				<div class="col-xs-4 col-md-4 col-sm-4" style="text-align: right;">
					<h6>DNI :</h6>
				</div>
				<div class="col-xs-8 col-md-8 col-sm-8">
				<small class="text-muted">	<?php echo $row['DNIempleado'];?></small>
				</div>			
			</div>
			<div class="row">
				<div class="col-xs-4 col-md-4 col-sm-4" style="text-align: right;">
					<h6>Apellidos :</h6>
				</div>
				<div class="col-xs-8 col-md-8 col-sm-8">
					<small class="text-muted"><?php echo $row['apellidos'];?></small>
				</div>			
			</div>
			<div class="row">
				<div class="col-xs-4 col-md-4 col-sm-4" style="text-align: right;">
					<h6>Nombres :</h6>
				</div>
				<div class="col-xs-8 col-md-8 col-sm-8">
					<small class="text-muted"><?php echo $row['NombresEmpleado'];?></small>
				</div>			
			</div>
		</div>
	</div>

		<?php
		
	}


		elseif ($accion=="enviardatostodo") {

		$idTipoSalida = $_POST["idTipoSalida"];// tipo de salida (ref/permi)
	 	$idTipoProceso = $_POST["idTipoProceso"];//inicio fim
	 	$hora = $_POST["hora"];
	 	$iddetalle = 0;
	 	$pagina = $_POST["pagina"];

	 	$ejeCodigo = $obj->consultar("SELECT sum(d.asistencia)as estado,COUNT(*)as totalfilas,sum(d.nolaboral)as nolab
							FROM DetalleCabRegistro  d
							inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
							inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
							inner join persona p on (d.codigoEmpleado=p.codigoEmpleado)
							WHERE t.estado=0 ");
		$rows = sqlsrv_fetch_array($ejeCodigo,SQLSRV_FETCH_ASSOC);


	 	$ejeCodigo2 = $obj->consultar("SELECT distinct r.codigoTipoSalida,d.nolaboral,r.tipo,CONVERT (char(5), r.inicio, 108) as inicio from reghorasNolaborables r
							inner join DetalleCabRegistro d on(d.codDetalle=r.codigodetallelaboral)
							inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
							inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
							inner join persona p on (d.codigoEmpleado=p.codigoEmpleado)
							WHERE t.estado=0 and r.tipo=1 and d.nolaboral=3");
		$rows2 = sqlsrv_fetch_array($ejeCodigo2,SQLSRV_FETCH_ASSOC);

		$ejeCodigo3 = $obj->consultar("SELECT distinct CONVERT (char(5), d.fechaIngreso, 108) as inciolaboral
							FROM DetalleCabRegistro  d
							inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
							inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
							inner join persona p on (d.codigoEmpleado=p.codigoEmpleado)
							WHERE t.estado=0 and d.asistencia=1 and d.nolaboral=0");
		$rows3 = sqlsrv_fetch_array($ejeCodigo3,SQLSRV_FETCH_ASSOC);


		$total = $rows["nolab"];
		$estdonolab = $rows2["nolaboral"];
		$codigoTipoSalida = $rows2["codigoTipoSalida"];
		$horaInicio = $rows2["inicio"];
		$horaInicioLaboral = $rows3["inciolaboral"];


		 if(($obj->ValidaHoranoLaboralTodo($hora,$idTipoSalida,$idTipoProceso,$estdonolab,$total,$codigoTipoSalida,$horaInicio,$horaInicioLaboral)==1))
		 {

		 	$horaarray = explode(":", $hora); // separa la hora en dos dentro de un array
			$NroHoras = (int) $horaarray[0];
			$NroMinut = (int) $horaarray[1];

				$query = "{call regGrupoHorasnoLab(0,?,?,?,?,2)}";
				$parametros = array(
			 		
			 		array(&$idTipoSalida ,SQLSRV_PARAM_IN),
			 		array(&$idTipoProceso ,SQLSRV_PARAM_IN),
			 		array(&$NroHoras,SQLSRV_PARAM_IN),
			 		array(&$NroMinut,SQLSRV_PARAM_IN),);
					$ejecutarCall = $obj->ejecutar_PA($query,$parametros);

			if(($ejecutarCall === false))
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
		 	$sw = $obj->ValidaHoranoLaboralTodo($hora,$idTipoSalida,$idTipoProceso,$estdonolab,$total,$codigoTipoSalida,$horaInicio,$horaInicioLaboral);
		 }
	 		

	 		?>

			<div id="sw" class="respuestaMsg"><?php echo $sw; ?></div>

			<?php
		
	}



}
?>
