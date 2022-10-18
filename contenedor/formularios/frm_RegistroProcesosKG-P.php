<?php
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
$obj = new Cfunciones;
?>
<script type="text/javascript">
    $('#codigoBarras').keypress(function(e) {
    var keycode = (e.keyCode ? e.keyCode : e.which);
    if (keycode == '13') {
        EnviarProcesoKG();
        e.preventDefault();
        return false;
    }
});

</script>
<div class="main1">
<div class="widget">
<div class="title">Registro de Proceso por Persona(Kg)</div>
<div class="chart">

<div class="container-fluid" id="mycontainer">

	<div class="form-row justify-content-center">

			<div class="form-group col-md-3 col-sm-3">
	            <label for="id_Especie" >Selecione Especie</label>
	            <select  name="id_Especie" id="id_Especie" class="form-control form-control-sm" onchange="cargarSelectv1(12,this.value,'divOcupacion');" required>
	            <OPTION value="" selected>SELECCIONAR...</OPTION>
	            <?php   
				$queryE="select distinct e.NombreEspecie,e.codigoEspecie FROM DetalleCabRegistro d
				inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
				inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
				inner join Ocupacion o on (o.codigoOcupacion=c.codigoOcupacion)
				inner join tipoEspecie e on (e.codigoEspecie=o.codigoEspecie)
				where t.estado=0 and o.CodigoTipotarifa=2 order by e.NombreEspecie asc";
				$ejecutarE=$obj->consultar($queryE);
	            while($row_E = sqlsrv_fetch_array($ejecutarE,SQLSRV_FETCH_ASSOC)){
	            ?>
	            <OPTION value="<?php  echo $row_E["codigoEspecie"]?>"><?php echo $row_E["NombreEspecie"]; ?></OPTION>

	            <?php } ?>

	            </select>
	        </div>

		 <div class="form-group col-md-3 col-sm-3">
		 	<div id="divOcupacion" >
	            <label for="id_ocupacion" >Selecione Ocupación</label>
	            <select  name="id_ocupacion" id="id_ocupacion" class="form-control form-control-sm" onchange="cargarSelectv1(6,this.value,'divGrupo');" required>
	            <OPTION value="" selected>SELECCIONAR...</OPTION>
	            <?php   
				$queryO="select distinct c.codigoRegistro, c.codigoOcupacion as codOcupacion,o.CodigoTipotarifa,o.NombreOcupacion as nomOcupacion FROM DetalleCabRegistro d
				inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
				inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
				inner join Ocupacion o on (o.codigoOcupacion=c.codigoOcupacion)
				inner join tipoEspecie e on (e.codigoEspecie=o.codigoEspecie)
				where e.codigoEspecie=".$row_E["codigoEspecie"]." and o.CodigoTipotarifa=2 and t.estado=0 order by o.NombreOcupacion asc";
				$ejecutarO=$obj->consultar($queryO);
	            while($row_O = sqlsrv_fetch_array($ejecutarO,SQLSRV_FETCH_ASSOC)){
	            ?>
	            <OPTION value="<?php  echo $row_O["codOcupacion"]?>"><?php echo $row_O["nomOcupacion"]; ?></OPTION>

	            <?php } ?>

	            </select>
	        </div>
	    </div>


	
		<div id="CabProducto" style="display: none;">
		 	<div id="divProducto">
	            <label for="id_Producto" >Selecione Producto</label>
	            <select  name="id_Producto" id="id_Producto" class="form-control form-control-sm">
	            <OPTION value="" selected>SELECCIONAR...</OPTION>
	            <?php   
				$queryP="SELECT Distinct p.CodigoProducto,p.NombreProducto
FROM Ocupacion o 
INNER JOIN detalle_Ocupacion do on do.codOcupacion=o.codigoOcupacion
INNER JOIN MaestroProducto p on p.CodigoProducto=do.codProducto
WHERE o.codigoOcupacion=".$row_O["codOcupacion"]."  and do.estado=1 ORDER BY NombreProducto";
				$ejecutarP=$obj->consultar($queryP);
	            while($row_P = sqlsrv_fetch_array($ejecutarP,SQLSRV_FETCH_ASSOC)){
	            ?>
	            <OPTION value="<?php  echo $row_P["CodigoProducto"]?>"><?php echo $row_P["NombreProducto"]; ?></OPTION>

	            <?php } ?>

	            </select>
	        </div>
	    </div>




	    <div class="form-group col-md-3 col-sm-3">
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
	            $smtvG=$obj->consultar($queryG);
	            while($row_G = sqlsrv_fetch_array($smtvG,SQLSRV_FETCH_ASSOC)){
	            ?>
	            <OPTION value="<?php  echo $row_G["codGrupo"]?>"><?php echo $row_G["nomGrupo"]; ?></OPTION>
	            <?php
	            }
	            ?> 
	            </select>
	        	</div>
        	</div>
		</div> 
	
	<div class="form-row justify-content-center">
			<div class="form-group col-md-5 col-sm-6">
				<input class="form-control" type="number" name="id_cantidad" id="id_cantidad" min="1" onkeypress="return isNumberKeyPunto(this);" required="">
			</div>

			 <div class="form-group col-md-5 col-sm-6"> 
                <div class="input-group mb-2">
                <div class="input-group-prepend">
                <div class="input-group-text"><i class="fas fa-scanner"></i></div>
                </div>
                <input type="hidden" name="accion" id="accion" value="2">
                <input type="text" class="form-control" placeholder="Buscar Codigo de Barras" name="codigoBarras" id="codigoBarras"  disabled>
                </div>
        	</div>
	</div> 

</div><!-- cierre div mycontainer-->



<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-sm-12">
        <div id="Exito" role="alert" style="display:none;text-align: center;" ></div>              
        <div id="divResultadoRegistros">
        
        <!-- Carga tabla -->
        </div>
        </div>  
    </div>
</div>  <!-- cierre div container tabla--> 	

</div><!-- cierre div chart-->
</div><!-- cierre divwidget-->
</div><!-- cierre div main1-->