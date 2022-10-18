
<?php
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
$obj = new Cfunciones;
?>
<script type="text/javascript">
    $('#codigoBarras').keypress(function(e) {
    var keycode = (e.keyCode ? e.keyCode : e.which);
    if (keycode == '13') {
        RegHorasNoLab();
        e.preventDefault();
        return false;
    }
});

</script>
<div class="title">
Personal
</div>
<div class="main1">
<div class="widget">
<div class="title">Registro de Horas no Laborables</div>
<div class="chart">
	<div class="container-fluid" id="mycontainer">

    <div class="form-row ">
        <div class="form-group col-md-3 col-sm-3">
        <div id="resultado">
          <label for="idTipoSalida">Motivo</label>&nbsp;<a onclick="cambiar_estilosV1('contenedor/formularios/frm_nuevotipo.php')" data-toggle="modal" data-target="#Modal"><i class="fas fa-plus-circle"></i></a>
          <select id="idTipoSalida" name="idTipoSalida" class="form-control form-control-sm" >
          <OPTION value="" selected>SELECCIONAR...</OPTION>
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
        </div> 
        </div>
        <div class="form-group col-md-5 col-sm-4">
          <label for="id_ocupacion" >Selecione Ocupación</label>
          <select  name="id_ocupacion" id="id_ocupacion" class="form-control form-control-sm" onchange="cargarSelectv1(3,this.value,'divGrupo');" required>
          <OPTION value="" selected>SELECCIONAR...</OPTION>
          <OPTION value="Full" >ENVIAR TODO</OPTION>
          <?php   
          $query="select distinct c.codigoRegistro, c.codigoOcupacion as codOcupacion,o.NombreOcupacion as nomOcupacion from CabRegistroLab c
          inner join DetalleCabRegistro d on (d.codigoRegistro=c.codigoRegistro)
          inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
          inner join Ocupacion o on (o.codigoOcupacion=c.codigoOcupacion)
          inner join GrupoTrabajo g on (c.codigoOcupacion=g.codigoOcupacion)
          where t.estado=0 and d.asistencia=1";
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

        <div class="form-group col-md-4 col-sm-5">
        <div id="divGrupo">
          <label for="id_Grupo">Selecione Grupo</label>
          <select id="id_Grupo" name="id_Grupo" class="form-control form-control-sm" required>
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
    </div>

    <div class="form-row">
      

      <div class="form-group col-md-3 col-sm-3"> 
        <div class="input-group mb-2">
        <div class="input-group-prepend">
        <div class="input-group-text"><i class="fas fa-clock"></i></div>
        </div>
        <input type="time" class="form-control form-control-sm" name="horaid" id="horaid">
        </div>
      </div>

      <div class="form-group col-md-5 col-sm-4"> 
        <div class="input-group mb-2">
        <div class="input-group-prepend">
        <div class="input-group-text"><i class="fas fa-scanner"></i></div>
        </div>
        <input type="text" class="form-control form-control-sm" placeholder="Buscar Codigo de Barras" name="codigoBarras" id="codigoBarras" disabled>
        </div>
      </div>



      <div class="form-group col-md-2 col-sm-2">
        <select id="idTipoProceso" name="idTipoProceso" class="form-control form-control-sm" disabled="">
        <OPTION value="1" >INICIO</OPTION>
        <OPTION value="2">FIM</OPTION>
        </select>
      </div> 

      <div class="form-group col-md-2 col-sm-3">

       <input type="submit" class="form-control btn-dark btn-sm" name="enviar" id="enviar" value="Cargar Grupo" 
       onclick="registrarGrupoHoraNoLaborable(); return false" disabled="" style="display:none">
      </div>
    </div>
	    
	</div>
  <div class="container-fluid">
	  <div class="row">
        <div class="col-lg-12">
        <div id="mensaje" align="center"></div>
        <div id="resultadoPrincipal"></div>
        </div>
    </div>
  </div>  
 
</div>
</div>
</div>


<!-- Modal -->

<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="contenedor-prow">
     
    </div>
  </div>
</div>




