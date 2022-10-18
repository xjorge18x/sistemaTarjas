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
		Registro Grupal Manual (Kg) 
	</div>
	<div class="col-6 text-right">

		<div class="btn-group">
		  <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" data-display="static" aria-expanded="false">
		    Acciones
		  </button>
		  <div class="dropdown-menu dropdown-menu-right">
		    <button class="dropdown-item" type="button" data-toggle="collapse" href="#collapseExample" onclick="Onclick()">Agregar Persona</button>
		  </div>
		</div>

	</div>
</div>
	

</div>
<div class="chart">

	<div class="container-fluid" id="mycontainer"> 
	<div class="form-row justify-content-center">

			<div class="form-group col-md-4 col-sm-4" style="margin-bottom: 0px;">
	            <label for="ocupacion" >Selecione Ocupación</label>
	            <select  name="id_ocupacion" id="id_ocupacion" class="form-control" onchange="cargarSelectv1M(8,this.value,'divGrupo',);" required>
	            <OPTION value="" selected>SELECCIONAR...</OPTION>
	            <?php   
				$query="select distinct c.codigoRegistro, c.codigoOcupacion as codOcupacion,o.CodigoTipotarifa,o.NombreOcupacion as nomOcupacion FROM DetalleCabRegistro d
				inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
				inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
				inner join Ocupacion o on (o.codigoOcupacion=c.codigoOcupacion)
				where t.estado=0 order by o.NombreOcupacion asc";
				$ejecutar=$obj->consultar($query);
	            while($row_p = sqlsrv_fetch_array($ejecutar,SQLSRV_FETCH_ASSOC)){
	            ?>
	            <OPTION value="<?php  echo $row_p["codOcupacion"]?>"><?php echo $row_p["nomOcupacion"]; ?></OPTION>

	            <?php } ?>

	            </select>
	        </div>

	        <div class="form-group col-md-4 col-sm-4 " style="margin-bottom: 0px;">
	        	<div id="divGrupo">
	            <label for="id_Grupo">Selecione Grupo</label>
	            <select id="id_Grupo" name="id_Grupo" class="form-control" required>
	            <OPTION value="" selected>SELECCIONAR...</OPTION>
	            <?php
	            $query="select distinct d.codigogrupo as codGrupo,g.NombreGrupo as nomGrupo from DetalleCabRegistro d
	            inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
	            inner join GrupoTrabajo g on (g.codGrupoTrabajo=d.codigogrupo)
	            inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
	            where c.codigoOcupacion=".$row_p["codOcupacion"]." and t.Estado=0";
	            $smtv=$obj->consultar($query);
	            while($row_2 = sqlsrv_fetch_array($smtv,SQLSRV_FETCH_ASSOC)){
	            ?>
	            <OPTION value="<?php  echo $row_2["codGrupo"]?>"><?php echo $row_2["nomGrupo"]; ?></OPTION>
	            <?php
	            }
	            ?> 
	            </select>
	        	</div>
        	</div>

        	<div class="form-group col-md-4 col-sm-4">
        		<label for="Cantidad">Cantidad</label>
				<input class="form-control" type="number" name="id_cantidad" id="id_cantidad" min="1" onkeypress="return isNumberKeyPunto(this);" required="">
			</div>


		
			<div class="form-group col-12" id="DatoDni" style="display:none">
				<div class="input-group mb-3">
				<input type="hidden" name="accion" id="accion" value="0">
		 		<input type="text" class="form-control" placeholder="Ingresar DNI" name="dniPersonal" id="dniPersonal">
				  <div class="input-group-append" >
				    <span class="input-group-text" id="basic-addon2"><a onclick="Onclick()"><i class="fa fa-times" aria-hidden="true"></i></a></span>
				  </div>
				</div>
			</div>


        <div class="form-group col-md-4 col-sm-4"> 
            <div class="input-group mb-2">
            <div class="input-group-prepend">
            <div class="input-group-text">Ini&nbsp;<i class="fas fa-clock"></i></div>
            </div>
            <input type="datetime-local" class="form-control" name="horaInicio" id="horaInicio">
            </div>
        </div>

         <div class="form-group col-md-4 col-sm-4"> 
            <div class="input-group mb-2">
            <div class="input-group-prepend">
            <div class="input-group-text">Fin&nbsp;<i class="fas fa-clock"></i></div>
            </div>
            <input type="datetime-local" class="form-control" name="horaFin" id="horaFin">
            </div>
        </div>

         <div class="form-group col-md-3 col-sm-4">
                <select id="idaccion" name="idaccion" class="form-control">
                <OPTION value="3" >SIN ACCION</OPTION>
                <OPTION value="1" >AGREGAR PERSONA</OPTION>
                </select>
        </div> 

<!--         <div class="form-group col-md-4 col-sm-4">
			<input type="submit" name="guardar" id="guardar" value="Enviar" class="form-control btn-dark" onclick="EnviarProcesoKGmanual();">
		</div> -->

	</div>
	</div>  <!-- cierre div mycontainer-->

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

<!--  -->