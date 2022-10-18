<?php
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
$obj = new Cfunciones;
?>

<script type="text/javascript">
    $('#dniPersonal').keypress(function(e) {
    var keycode = (e.keyCode ? e.keyCode : e.which);
    if (keycode == '13') {
        EnviarProcesoKGmanual();
        e.preventDefault();
        return false;
    }
});
</script>
<div class="main1">
<div class="widget">
<div class="title">	

<div class="row">
	<div class=col-6>
		Registro Manual
	</div>

</div>
	

</div>
<div class="chart">

	<div class="sticky-top">
		<div class="card card-border">
			<div class="container-fluid" > 
	<div class="form-row justify-content-center">

			<div class="form-group col-md-3 col-sm-3">
	            <label for="id_Especie" >Selecione Especie</label>
	            <select  name="id_Especie" id="id_Especie" class="form-control form-control-sm" onchange="cargarSelectv1M(9,this.value,'divOcupacion');" required>
	            <OPTION value="" selected>SELECCIONAR...</OPTION>
	            <?php   
				$queryE="select distinct e.NombreEspecie,e.codigoEspecie FROM DetalleCabRegistro d
				inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
				inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
				inner join Ocupacion o on (o.codigoOcupacion=c.codigoOcupacion)
				inner join tipoEspecie e on (e.codigoEspecie=o.codigoEspecie)
				where t.estado=0 order by e.NombreEspecie asc";
				$ejecutarE=$obj->consultar($queryE);
	            while($row_E = sqlsrv_fetch_array($ejecutarE,SQLSRV_FETCH_ASSOC)){
	            ?>
	            <OPTION value="<?php  echo $row_E["codigoEspecie"]?>"><?php echo $row_E["NombreEspecie"]; ?></OPTION>

	            <?php } ?>

	            </select>
	        </div>

			<div class="form-group col-md-3 col-sm-3" >
			 <div id="divOcupacion">
	            <label for="id_ocupacion" >Selecione Ocupación</label>
	            <select  name="id_ocupacion" id="id_ocupacion" class="form-control form-control-sm" onchange="cargarSelectv1M(8,this.value,'divGrupo');" required>
	            <OPTION value="" selected>SELECCIONAR...</OPTION>
	            <?php   
				$queryO="select distinct c.codigoRegistro, c.codigoOcupacion as codOcupacion,o.CodigoTipotarifa,o.NombreOcupacion as nomOcupacion FROM DetalleCabRegistro d
				inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
				inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
				inner join Ocupacion o on (o.codigoOcupacion=c.codigoOcupacion)
				inner join tipoEspecie e on (e.codigoEspecie=o.codigoEspecie)
				where e.codigoEspecie=".$row_E["codigoEspecie"]." and t.estado=0 order by o.NombreOcupacion asc";
				$ejecutarO=$obj->consultar($queryO);
	            while($row_O = sqlsrv_fetch_array($ejecutarO,SQLSRV_FETCH_ASSOC)){
	            ?>
	            <OPTION value="<?php  echo $row_O["codOcupacion"]?>"><?php echo $row_O["nomOcupacion"]; ?></OPTION>

	            <?php } ?>

	            </select>
	          </div>
	        </div>

	        <div class="form-group col-md-3 col-sm-3" >
	        	<div id="divGrupo">
	            <label for="id_Grupo">Selecione Grupo</label>
	            <select id="id_Grupo" name="id_Grupo" class="form-control form-control-sm" required>
	            <OPTION value="" selected>SELECCIONAR...</OPTION>
	            <?php
	            $queryG="select distinct d.codigogrupo as codGrupo,g.NombreGrupo as nomGrupo from DetalleCabRegistro d
	            inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
	            inner join GrupoTrabajo g on (g.codGrupoTrabajo=d.codigogrupo)
	            inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
	            where c.codigoOcupacion=".$row_O["codOcupacion"]." and t.Estado=0";
	           	$ejecutarG=$obj->consultar($queryG);
	            while($row_G = sqlsrv_fetch_array($ejecutarG,SQLSRV_FETCH_ASSOC)){
	            ?>
	            <OPTION value="<?php  echo $row_G["codGrupo"]?>"><?php echo $row_G["nomGrupo"]; ?></OPTION>
	            <?php
	            }
	            ?> 
	            </select>
	        	</div>
        	</div>

       	<div class="form-group col-md-3 col-sm-3">
       		 	<label for="id_Grupo">Selecione Acción</label>
                <select id="idaccion" name="idaccion" class="form-control form-control-sm">
                <OPTION value="3" >SIN ACCION</OPTION>
                <OPTION value="1" >AGREGAR PERSONA</OPTION>
                </select>
        </div> 


	        <div class="form-group col-md-3 col-sm-3"> 
	            <div class="input-group mb-2">
	            <div class="input-group-prepend">
	            <div class="input-group-text"><span style="font-size: 10px;">Inicio&nbsp;</span><i class="fas fa-clock"></i></div>
	            </div>
	            <input type="datetime-local" class="form-control form-control-sm" name="horaInicio" id="horaInicio" pattern="[0-9]{2}:[0-9]{2}">
	            </div>
	        </div>

	         <div class="form-group col-md-3 col-sm-3"> 
	            <div class="input-group mb-2">
	            <div class="input-group-prepend">
	            <div class="input-group-text"><span style="font-size: 10px;">Fin&nbsp;</span><i class="fas fa-clock"></i></div>
	            </div>
	            <input type="datetime-local" class="form-control form-control-sm" name="horaFin" id="horaFin">
           	 </div>
        	</div>


            <div class="form-group  col-md-3 col-sm-3"> 
                <div class="input-group mb-2 ">
                <div class="input-group-prepend ">
                <div class="input-group-text"><i class="fas fa-scanner"></i></div>
                </div>
                <input type="text" class="form-control form-control-sm" placeholder="Buscar Codigo de Barras" name="dniPersonal" id="dniPersonal">
                </div>
        	</div>

			<div class="form-group col-md-3 col-sm-3">
				<input class="form-control form-control-sm" type="number" name="id_cantidad" id="id_cantidad" min="1" onkeypress="return isNumberKeyPunto(this);" required="" placeholder="Cantidad" style="font-weight: bold;">
			</div>


<!-- 			<div class="form-group col-md-3 col-sm-5">
			<input type="hidden" name="accion" id="accion" value="3">
			<input type="submit" name="guardar" id="guardar" value="Enviar" class="form-control btn-dark" onclick="EnviarProcesoKGmanual();">
			</div> -->
	
	</div>
	</div>  <!-- cierre div mycontainer-->
	</div>
</div>

	<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-sm-12">   

	        <div id="divResultadoRegistros">
	        
	        <!-- Carga tabla -->
	        </div>

        </div>  
    </div>
	</div>  <!-- cierre div container tabla--> 	

</div><!-- cierre div chart-->
</div><!-- cierre divwidget-->
</div><!-- cierre div main1-->
