<?php
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
$obj = new Cfunciones;
?>
<div class="title">
        Inicio
</div>
<div class="main1">
<div class="widget">
      <div class="title">Lista de Personal</div>
            
<div class="chart">
<div class="container-fluid" id="mycontainer"> 
  <div class="form-row">
      <div class="form-group col-lg-12 col-md-12 col-sm-12">
        <label for="id_linea" >Selecione Grupo</label>
        <select  name="id_linea" id="id_linea" class="form-control" onchange="mostrarPersonal('divPersonal');" required>
        <OPTION value="" selected>SELECCIONAR...</OPTION>
        <?php $query = "select codGrupoTrabajo,NombreGrupo from GrupoTrabajo where Estado=1";
        $ejecutar=$obj->consultar($query);
              while($row_p = sqlsrv_fetch_array($ejecutar,SQLSRV_FETCH_ASSOC)){
              ?>
              <OPTION value="<?php  echo $row_p["codGrupoTrabajo"]?>"><?php echo $row_p["NombreGrupo"]; ?>
              </OPTION>

              <?php

              }
              ?>
        </select>

      </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-12 col-sm-12">              
        <div id="divPersonal">
        
        <!-- Carga lista empleados Turno -->
        </div>
        </div>  
    </div>
</div>  <!-- cierre div container -->   
</div>
</div>
</div>
 