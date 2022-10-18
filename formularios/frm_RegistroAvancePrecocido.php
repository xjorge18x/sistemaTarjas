<?php
/*=============================================
 FORMULARIO REGISTO AVANCE PRECOCIDO
=============================================*/
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
$obj = new Cfunciones;
?>
<div class="title">
Procesos
</div>
<div class="main1">
<div class="widget">
<div class="title">Registro Proceso Precocido</div>
<div class="chart">
 	<div class="container-fluid" id="mycontainer">  
		<div class="form-row">
			<div class="form-group col-md-5 col-sm-4">
	            <label for="id_ocupacion" >Selecione Ocupación</label>
	            <select  name="id_ocupacion" id="id_ocupacion" class="form-control" onchange="cargarSelectv1(7,this.value,'divGrupo');" required>
	            <OPTION value="" selected>SELECCIONAR...</OPTION>
	            <?php   
				$query="select distinct c.codigoRegistro, c.codigoOcupacion as codOcupacion,o.NombreOcupacion as nomOcupacion from CabRegistroLab c
				inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
				inner join Ocupacion o on (o.codigoOcupacion=c.codigoOcupacion)
				inner join GrupoTrabajo g on (c.codigoOcupacion=g.codigoOcupacion)
				inner join linea l on (l.codigoLinea=o.codigoLinea)
				where t.estado=0 and c.codigoTipoTarifa=2 and l.codigoLinea=30 and c.estado=1";
	            $ejecutar=$obj->consultar($query);
	            while($row_p = sqlsrv_fetch_array($ejecutar,SQLSRV_FETCH_ASSOC)){
	            ?>
	            <OPTION value="<?php  echo $row_p["codOcupacion"]?>"><?php echo $row_p["nomOcupacion"]; ?>
	            </OPTION>

	            <?php

	            }
	            ?>

	            </select>

	        </div>
	       	<div class="form-group col-md-5 col-sm-4">
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

			
			<div class="form-group col-md-2 col-sm-4">
				<label for="id_cantidad">Cantidad</label>
					<input class="form-control" type="number" name="id_cantidad" id="id_cantidad" min="1" onkeypress="return isNumberKey(this);" required="" >
			</div>

		</div><!-- cierre fila-->

		<div class="form-row">
			<div class="form-group col-md-12 col-sm-12">
			<input type="submit" name="guardar" id="guardar" value="Enviar" class="form-control btn-dark" onclick="EnviarProcesoPrecocido(); return false" disabled="">
			</div>
		</div>


	</div><!-- cierre div mycontainer-->

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
</div><!-- cierre div main1-->|