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
elseif($tipo == 9) {
$div = 4; 
$onchange= "cargarSelectv1M(8,this.value,'divGrupo');";//PERSONA Manual KG Y HORAS
}
elseif($tipo == 10) {
$div = 5; 
$onchange= "cargarSelectv1(8,this.value,'divGrupo');";//GRUPO Manual
}
elseif($tipo == 11) {
$div = 6; 
}
elseif($tipo == 12) {
$Tarifa = " and o.CodigoTipotarifa in(2)";	
$div = 5; 
$onchange= "cargarSelectv1(6,this.value,'divGrupo');";//POR PERSONA CON ESPECIE REGISTRO PRODUCTIVO KG
}
elseif($tipo == 14) {
$Tarifa = " and o.CodigoTipotarifa in(2)";
$div = 5; 
$onchange= "cargarSelectv1(5,this.value,'divGrupo');";//POR GRUPO CON ESPECIE REGISTRO PRODUCTIVO KG
}
elseif($tipo == 13) {
$div = 5; 
$Tarifa = " and o.CodigoTipotarifa in(1,2,3)";
$onchange= "cargarSelectv1(1,this.value,'divGrupo');";//ASISTENCIA PERSONAL CON ESPECIE REGISTRO PRODUCTIVO
}
elseif($tipo == 15) { //SubGrupo -  Carga ocupaciones
$div = 5; //ocupaciones
$Tarifa = " and o.CodigoTipotarifa in(2)";//Solo ocupaciones pago por kG
$onchange= "cargarSelectv1(16,this.value,'divGrupo');";
}
elseif($tipo == 16) {//SubGrupo - Carga Select Grupos 
$div = 1; //Grupos
$onchange= "cargarRegistroProcesos(6,this.value,'divResultadoRegistros');";//Carga Tabla SubGrupos
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
		<SELECT class="form-control form-control-sm" name="id_Grupo" id="id_Grupo" onchange="<?php echo $onchange; ?>" required>
			<option value="0">SELECCIONAR</option>
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
$query2="select o.CodigoTipotarifa,c.codigoRegistro
from Ocupacion o
inner join CabRegistroLab c on c.codigoOcupacion=o.codigoOcupacion
inner join TurnoGenerado t on t.codigoturno=c.codigoTurno
where o.codigoOcupacion='$codato' and t.estado=0";
$smtv2=$obj->consultar($query2);
$row3 = sqlsrv_fetch_array($smtv2,SQLSRV_FETCH_ASSOC);
$tarifa = $row3['CodigoTipotarifa'];
?>
<div id="tarifa" class="respuestaMsg"><?php echo $tarifa; ?></div>
<?php

$query3="SELECT Distinct p.CodigoProducto,p.NombreProducto
FROM Ocupacion o 
INNER JOIN Detalle_Ocupacion do on do.codOcupacion=o.codigoOcupacion
INNER JOIN MaestroProducto p on p.CodigoProducto=do.codProducto
WHERE o.codigoOcupacion='$codato' and do.estado=1 ORDER BY NombreProducto";
$smtv3=$obj->consultar($query3);
$numeroFilas3 = sqlsrv_num_rows($smtv3);

?>
	<div id="swProCount" class="respuestaMsg"><?php echo $numeroFilas3; ?></div>	
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

elseif ($div ==4) {
	
$codato = $_POST["dato"];
$query="select distinct c.codigoRegistro, c.codigoOcupacion as 	codOcupacion,o.CodigoTipotarifa,o.NombreOcupacion as nomOcupacion FROM DetalleCabRegistro d
				inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
				inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
				inner join Ocupacion o on (o.codigoOcupacion=c.codigoOcupacion)
				inner join tipoEspecie e on (e.codigoEspecie=o.codigoEspecie)
				where e.codigoEspecie='$codato' and t.estado=0 order by o.NombreOcupacion asc";
$smtv=$obj->consultar($query);
$numeroFilas = sqlsrv_num_rows($smtv);

?>
<label for="id_ocupacion">Selecione Ocupación</label>
		<SELECT class="form-control form-control-sm" name="id_ocupacion" id="id_ocupacion" onchange="<?php echo $onchange; ?>" required>
			<option value="">SELECCIONAR</option>
		<?php
		while($row2 = sqlsrv_fetch_array($smtv,SQLSRV_FETCH_ASSOC))
		{
		?>
			<option value="<?php echo $row2["codOcupacion"]; ?>"><?php echo $row2["nomOcupacion"]; ?></option>	
		<?php
		}
		?>
		</select>

<?php
}

elseif ($div == 5) {

$codato = $_POST["dato"];
$query="select distinct c.codigoRegistro, c.codigoOcupacion as 	codOcupacion,o.CodigoTipotarifa,o.NombreOcupacion as nomOcupacion FROM DetalleCabRegistro d
				inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
				inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
				inner join Ocupacion o on (o.codigoOcupacion=c.codigoOcupacion)
				inner join tipoEspecie e on (e.codigoEspecie=o.codigoEspecie)
				where e.codigoEspecie='$codato' and t.estado=0 $Tarifa order by o.NombreOcupacion asc";
$smtv=$obj->consultar($query);
$numeroFilas = sqlsrv_num_rows($smtv);

?>
<label for="id_ocupacion">Selecione Ocupación</label>
		<SELECT class="form-control form-control-sm" name="id_ocupacion" id="id_ocupacion" onchange="<?php echo $onchange;?>" required>
			<option value="">SELECCIONAR</option>
		<?php
		while($row2 = sqlsrv_fetch_array($smtv,SQLSRV_FETCH_ASSOC))
		{
		?>
			<option value="<?php echo $row2["codOcupacion"]; ?>"><?php echo $row2["nomOcupacion"]; ?></option>	
		<?php
		}
		?>
		</select>
<?php
}
elseif ($div == 6) {
$codato = $_POST["dato"];
$query="SELECT Distinct p.CodigoProducto,p.NombreProducto
FROM Ocupacion o 
INNER JOIN detalle_Ocupacion do on do.codOcupacion=o.codigoOcupacion
INNER JOIN MaestroProducto p on p.CodigoProducto=do.codProducto
WHERE o.codigoOcupacion='$codato' and do.estado=1 ORDER BY NombreProducto";
$smtv=$obj->consultar($query);
$numeroFilas = sqlsrv_num_rows($smtv);
?>
<label for="id_Producto">Selecione Producto</label>
		<SELECT class="form-control form-control-sm" name="id_Producto" id="id_Producto">
			<option value="">SELECCIONAR</option>
		<?php
		while($row2 = sqlsrv_fetch_array($smtv,SQLSRV_FETCH_ASSOC))
		{
		?>
			<option value="<?php echo $row2["CodigoProducto"]; ?>"><?php echo $row2["NombreProducto"]; ?></option>	
		<?php
		}
		?>
		</select>
<?php



	}

}
?>
