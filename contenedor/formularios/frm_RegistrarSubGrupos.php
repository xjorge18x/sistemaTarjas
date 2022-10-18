<?php
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
$obj = new Cfunciones;
?>
<div class="main1">
<div class="widget">
	<div class="title">Registro SubGrupos</div>

	<div class="chart">

		<div class="sticky-top">
		<div class="card card-border">
		<div class="container-fluid" >
		<div class="form-row justify-content-center">

			<div class="form-group col-md-4 col-sm-4">
	            <label for="id_Especie" >Selecione Especie</label>
	            <select  name="id_Especie" id="id_Especie" class="form-control form-control-sm" onchange="cargarSelectv1(15,this.value,'divOcupacion');" required>
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

	        <div class="form-group col-md-4 col-sm-4">
			 	<div id="divOcupacion" >
		            <label for="id_ocupacion" >Selecione Ocupación</label>
		            <select  name="id_ocupacion" id="id_ocupacion" class="form-control form-control-sm" onchange="cargarSelectv1(16,this.value,'divGrupo');" required>
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

		    <div class="form-group col-md-4 col-sm-4">
		        <div id="divGrupo">
		            <label for="id_Grupo">Selecione Grupo</label>
		            <select id="id_Grupo" name="id_Grupo" class="form-control form-control-sm" required>
		            <OPTION value="0" selected>SELECCIONAR...</OPTION>
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

	    	<div class="form-group col-md-4 col-sm-4">
	        	<input type="submit" class="form-control btn-dark btn-sm" name="BtnGuardar" id="BtnGuardar" value="Guardar" data-toggle="modal"data-target="#ModalSubGrupo"  onclick="cambiar_estilosV2(2)" disabled>
	        </div>

	    	<div class="form-group col-md-4 col-sm-4">
	        	<input type="submit" class="form-control btn-secondary btn-sm" name="BtnVer" id="BtnVer" value="Consultar" data-toggle="modal"data-target="#ModalSubGrupo" onclick="cambiar_estilosV2(1)" disabled>
	        </div>

	    </div>
	 </div>
	</div>
	</div>

    <div class="row">
        <div class="col-lg-12 col-sm-12">   

	        <div id="divResultadoRegistros">
	        
	        <!-- Carga tabla -->
	        </div>

        </div>  
    </div>
<div id="DivRpstPop"></div>
	</div><!--Chart --->

</div>
</div>

<!-- cierre div Modal --> 
<div class="modal fade" id="ModalSubGrupo" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog modal-dialog-scrollable">
      <div class="modal-content" id="contenedor-prow">
        
      </div>
    </div>
</div>