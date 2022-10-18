<!-- Llena Caja con Ocupaciones -->
<?php
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
$obj = new Cfunciones;
if(isset($_POST["tipo"])){
$tipo =$_POST["tipo"];


if ($tipo == 1) {
$div = 1; 	
$onchange= "cargarAsistencia('divResultado');";	//Asistencia
}
elseif ($tipo == 3) {
	$codato = $_POST["dato"];
	if ($codato=='Full') {
		$div = 3;
	}
else{
	$div = 1;
	$onchange= "cargarHorasnolaborables('resultadoPrincipal');";//No laboral
	}

}
elseif ($tipo == 4) {
$div = 1; 
$onchange= "cargarRegistroProcesos(4,this.value,'divResultadoProcesos');";//		
}
elseif ($tipo == 2) {
$div = 2;  //llena select tipo de salida (horas muertas)
}
elseif($tipo == 5) {
$div = 1; 
$onchange= "cargarRegistroProcesos(1,this.value,'divResultadoRegistros');";//GRUPO
}
elseif($tipo == 6) {
$div = 1; 
$onchange= "cargarRegistroProcesos(2,this.value,'divResultadoRegistros');";//POR PERSONA
}
elseif($tipo == 7) {
$div = 1; 
$onchange= "cargarRegistroProcesos(3,this.value,'divResultadoRegistros');";//GRUPO PRECOCIDO
}
elseif($tipo == 8) {
$div = 1; 
$onchange= "cargarRegistroProcesos(5,this.value,'divResultadoRegistros');";//GRUPO Manual
}

if ($div == 1) {


$codato = $_POST["dato"];
$query="select distinct d.codigogrupo as codGrupo,g.NombreGrupo as nomGrupo from DetalleCabRegistro d
inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
inner join GrupoTrabajo g on (g.codGrupoTrabajo=d.codigogrupo)
inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
where c.codigoOcupacion='$codato' and t.Estado=0";
$smtv=$obj->consultar($query);
$numeroFilas = sqlsrv_num_rows($smtv);

?>
<label for="id_Grupo">Selecione Grupo</label>
		<SELECT class="form-control" name="id_Grupo" id="id_Grupo" onchange="<?php echo $onchange; ?>" required>
			<option value="">SELECCIONAR</option>
		<?php
		while($row2 = sqlsrv_fetch_array($smtv,SQLSRV_FETCH_ASSOC))
		{
		?>
			<option value="<?php echo $row2["codGrupo"]; ?>"><?php echo $row2["nomGrupo"]; ?></option>	
		<?php
		}
		?>
		</select>
<?php		
$query2="select o.CodigoTipotarifa from Ocupacion o
where o.codigoOcupacion='$codato'";
$smtv2=$obj->consultar($query2);
$row3 = sqlsrv_fetch_array($smtv2,SQLSRV_FETCH_ASSOC);
$tarifa = $row3['CodigoTipotarifa'];
?>
		<div id="tarifa" class="respuestaMsg"><?php echo $tarifa; ?></div>	
<?php	
}
else if($div == 2) 
{

$nombre=$_POST["dato"];
	if (trim($nombre)<>"")
	{
		$query = "{call AgregarNuvoTipoSalida (?)}";
		$parametros = array(
		array(&$nombre,SQLSRV_PARAM_IN),
		);
		$ejecutar = $obj->ejecutar_PA($query,$parametros);
		if ($ejecutar===false)
		{
			echo "Ocurrio un error";
			die( print_r( sqlsrv_errors(), true)); 
			$sw = 2;
		}
		else{

			$sw = 1;
			$R_P1=sqlsrv_fetch_array($ejecutar,SQLSRV_FETCH_ASSOC);
			$codActual = $R_P1["CodActual"];
		} 
			
	}
	else
	{
		$sw=3;
	}
	?>
	<div id="sw" class="respuestaMsg"><?php echo $sw; ?></div>
	<div id="codActualSa" class="respuestaMsg"><?php echo $codActual; ?></div>

	<label for="idTipoSalida">TIPO</label>&nbsp;<a onClick="cambiar_estilosV1('contenedor/formularios/frm_nuevotipo.php')" data-toggle="modal" data-target="#Modal"><i class="fas fa-plus-circle"></i></a>
            <select id="idTipoSalida" name="idTipoSalida" class="form-control" required>
                  <?php   
                            $query2="select codigotipo,NombreTipo from TipoSalida where estado=1";
                            $ejecutar2=$obj->consultar($query2);
                            while($row_t = sqlsrv_fetch_array($ejecutar2,SQLSRV_FETCH_ASSOC)){
                            ?>
                    <OPTION value="<?php  echo $row_t["codigotipo"]?>"><?php echo $row_t["NombreTipo"]; ?>
                    </OPTION>

                            <?php

                            }
                            ?>
            </select>

<?php	
}
elseif ($div ==3) {?>
	
	<label for="Boton">.</label>
	<button  type="button" class="form-control btn btn-info btn-xs" onclick="registrarTodoHoraNoLaborable(); return false">Enviar</button>

<?php
}

}
?>
