<?php
require_once("../../cont/CFunciones.php");
include("../../conectar.php");
include_once("../../verificar.php");
$obj = new Cfunciones;

if (isset($_POST['accion'])) {
	$accion = $_POST['accion'];

	if ($accion == 'RegistroDistribucion') {

		$CodDetalle = $_POST['idDetalle'];
		$IdSesion = $_POST['datoSelec'];

		$ejecutar = $obj->consultar2("Update DETALLE set id_sesion='$IdSesion', estado_e=1 where IDDETALLE='$CodDetalle'");

	      if ($ejecutar  === false)
		    {   $sw = 2;
		        echo "Ocurrio un error.\n";
		        die(print_r(sqlsrv_errors(), true));
		    }
		    else
		    {
		    	$sw = 1;
		    }
		 ?>
		 <div id="sw" class="respuestaMsg"><?php echo $sw; ?></div>
		 <?php
		include_once("../formularios/tabla_ListaBatch.php");
	}
	elseif ($accion == 'Dash') {
		include_once("../formularios/tabla_ListaBatch.php");
	}
	elseif ($accion == "RegistrarSubGrupo") {

		$IdGrupo = $_POST['idGrupo'];
		$IdOcupacion = $_POST['idOcupacion'];
		$DatosCheck = $_POST['ArrayDatos'];
		$NomSubGrupo = $_POST['NomSubGrupo'];
		$IdSubGrupo = $_POST['IdSubGrupo'];
		$Tipo = $_POST['Tipo'];

		$query = $obj->consultar("select distinct c.codigoRegistro from CabRegistroLab c
		inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
		inner join Ocupacion o on (o.codigoOcupacion=c.codigoOcupacion)
		inner join GrupoTrabajo g on (c.codigoOcupacion=g.codigoOcupacion)
		inner join DetalleCabRegistro d on (d.codigoRegistro=c.codigoRegistro)
		where t.estado=0 and c.codigoOcupacion='$IdOcupacion' and d.codigogrupo='$IdGrupo'");//obtengo codigo de registro
		$rows = sqlsrv_fetch_array($query,SQLSRV_FETCH_ASSOC);
		$codigoRegistro = $rows["codigoRegistro"];

if(($obj->ValidarRegistroSubGrupos($DatosCheck,$NomSubGrupo,$Tipo,$IdSubGrupo)==1)){
	$retVal = ($IdSubGrupo=='undefined') ? "" : $IdSubGrupo;

	$query = "{call SP_RegistrarSubgGrupo(?,?,?,?,?)}";
        $parametros = array(
                array(&$DatosCheck,SQLSRV_PARAM_IN),
                array(&$codigoRegistro,SQLSRV_PARAM_IN),
                array(&$NomSubGrupo ,SQLSRV_PARAM_IN),
        	array(&$Tipo ,SQLSRV_PARAM_IN),
        	array(&$retVal ,SQLSRV_PARAM_IN));
        $ejecutar = $obj->ejecutar_PA($query,$parametros);
        if($ejecutar===false)
                    {
                    echo "Ocurrio un error";
                    die( print_r( sqlsrv_errors(), true));
                    $sw = 2;
                    }
                    else
                    {
                    $sw = 1;}
	
}
		else
		{
			$sw = $obj->ValidarRegistroSubGrupos($DatosCheck,$NomSubGrupo,$Tipo,$IdSubGrupo);
		}


 ?>
         <div id="sw" class="respuestaMsg"><?php echo $sw; ?></div>
        <?php 

        $id_Grupo=$IdGrupo;
        $id_Ocupacion=$IdOcupacion;
        include_once("../formularios/tabla_SubGrupos.php");
	}
elseif ($accion == "AccionSubGrupo") {
		$CodRegistro = $_POST["CodigoReg"];
		$CodEmpleado = $_POST['CodEmpleado'];
		$CogGrupo = $_POST["CodGrupo"];
		$query = "UPDATE Detalle_subGrupoLab SET estado=0 where id_subgrupo='$CogGrupo' and id_empleado='$CodEmpleado' ";
		$Ejecutar = $obj->consultar($query);
		if ($Ejecutar === false)
	     {
	        echo "Ocurrio un error";
	        die( print_r( sqlsrv_errors(), true));
	        $sw = 2;
	     }
	     else{
	     	 $sw = 1;
	     }
?>
<div id="sw" class="respuestaMsg"><?php echo $sw; ?></div>
<?php
		$tipo=1;
		$CodigoRegistro=$CodRegistro;
		include_once("../formularios/tabla_ListaSubGrupo.php");
	}
}
?>