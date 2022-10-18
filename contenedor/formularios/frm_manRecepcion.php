
<?php
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
$obj = new Cfunciones;

date_default_timezone_set('America/Lima');
$now_date = date("Y-m-d");
$now_date1 = date("d-m-Y"); 
?>
<div class="title">
        Recepción
      </div>
  <div class="main1">
    <div class="widget">
      <div class="title">Registro de Recepción de Materia Prima</div>
            
      <div class="chart">
<div class="container-fluid" id="mycontainer">

<div class="form-row">

	<div class="form-group col-lg-5 col-md-4 offset-md-4 col-sm-4 offset-sm-4">

    	 <div class="form-group col-md-5 "> 
            <div class="input-group mb-2">
            <div class="input-group-prepend">
            <div class="input-group-text"><i class="fas fa-clock"></i></div>
            </div>
            <input type="time" class="form-control" name="horaid" id="horaid">
            </div>
        </div>
    </div>
	

</div>


<div class="form-row">

		<div class="form-group col-md-3 col-sm-2">
		<label for="id_cantidad">Cantidad </label>
    
    	<input class="form-control" type="number" name="id_cantidad" id="id_cantidad" min="1" step="0.01" required>

		</div>
		<div class="form-group col-md-3 col-sm-3">
		<label for="turno"> Turno</label>
		<select name="turno" id="turno" class="form-control">
 			<?php   
            $query="select id,parametro_text from parametro_sys where tipo=4 and estado=1";
            $ejecutar=$obj->consultar($query);
            while($row_p = sqlsrv_fetch_array($ejecutar,SQLSRV_FETCH_ASSOC)){
            ?>
            <OPTION value="<?php  echo $row_p["id"]?>"><?php echo $row_p["parametro_text"]; ?>
            </OPTION>

            <?php

            }
            ?>

		</select>
		</div>

		<div class="form-group col-md-3 col-sm-4">
		<label for="id_Especie"> Especie </label>
		<select name="id_Especie" id="id_Especie" class="form-control" required>
			<OPTION value="" selected>SELECCIONAR...</OPTION>
		 <?php   
            $query="select codigoEspecie,NombreEspecie from tipoEspecie where Estado=1";
            $ejecutar=$obj->consultar($query);
            while($row_p = sqlsrv_fetch_array($ejecutar,SQLSRV_FETCH_ASSOC)){
            ?>
            <OPTION value="<?php  echo $row_p["codigoEspecie"]?>"><?php echo $row_p["NombreEspecie"]; ?>
            </OPTION>

            <?php

            }
            ?>

		</select>
		</div>

		<div class="form-group col-md-3 col-sm-3">
		<label for="id_tiporecep"> Tipo Recepción </label>
		<select name="id_tiporecep" id="id_tiporecep" class="form-control" required>
			<OPTION value="" selected>SELECCIONAR...</OPTION>
			<?php   
            $query="select id,parametro_text from parametro_sys where tipo=3 and estado=1";
            $ejecutar=$obj->consultar($query);
            while($row_p = sqlsrv_fetch_array($ejecutar,SQLSRV_FETCH_ASSOC)){
            ?>
            <OPTION value="<?php  echo $row_p["id"]?>"><?php echo $row_p["parametro_text"]; ?>
            </OPTION>

            <?php

            }
            ?>
		</select>

		</select>
		</div>


</div>



<div class="form-row">
    <div class="form-group col-lg-6 col-md-6" style="
    margin-bottom: 0px;">
        <div class="input_container">
        <label for="id_cantidad">Embarcación</label>
        <input type="text" id="buscarEmbar" name="buscarEmbar" class="form-control" onkeyup="buscadorEmbarcaciones()">
        <input type="hidden" name="id_embarcacion" id="id_embarcacion" value="">
        </div>
    </div>

    <div class="col-lg-6 col-md-6">
        <div class="input_container">
        <ul id="demo" class="list"></ul> 
        </div>
    </div>
</div>


<div class="form-row">
	<div class="form-group col-md-12">
		 <label for="Obs">Observación</label>
    	<textarea class="form-control" id="Obs" name="Obs" rows="3">
    	</textarea>
	</div>
	
</div>


<div class="form-row d-flex justify-content-end">
    

	<div class="form-group col-md-5 col-sm-4">
		<input type="submit" name="guardar" id="guardar" value="Enviar" class="form-control btn-dark" onclick="registrarcantidadMP(); return false">
	</div>
	
</div>

</div><!-- FIN CONTAINER FORMULARIO -->

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-sm-12">              
        <div id="divResultadoRecepcion">
        <?php include_once("../formularios/tabla_registroMateriaprima.php");?>
        <!-- Carga Datos -->
        </div>
        </div>  
    </div>
</div>  <!-- cierre div container tabla--> 	


</div>
</div>
</div>