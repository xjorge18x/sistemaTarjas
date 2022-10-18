<?php
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
$obj = new Cfunciones;
?>
<script type="text/javascript">
    $('#codigoBarras').keypress(function(e) {
    var keycode = (e.keyCode ? e.keyCode : e.which);
    if (keycode == '13') {
        enviar_asitenciasCB();
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
<div class="title">Registro de Cuadrilla</div>
<div class="chart">	
        <div class="container">
                		
        <form action="" method="POST" name="registroAsistenciaPersonal" id="RegistroAsistenciaPersonal" onsubmit="">

        <div class="form-row">
                <div class="form-group col-md-5">
                <label for="turno" >Selecione Turno</label>
                <select  name="T_turno" id="T_turno" class="form-control" onchange="cargarSelectv1(1,this.value,'divGrupo');" required>
                        <OPTION value="" selected>SELECCIONAR...</OPTION>
                                <?php   
                                $query="select distinct c.codigoOcupacion as codOcupacion,o.NombreOcupacion as nomOcupacion from CabRegistroLab c
                                inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
                                inner join Ocupacion o on (o.codigoOcupacion=c.codigoOcupacion)
                                inner join GrupoTrabajo g on (c.codigoOcupacion=g.codigoOcupacion)
                                where t.estado=0";
                                $ejecutar=$obj->consultar($query);
                                while($row_p = sqlsrv_fetch_array($ejecutar,SQLSRV_FETCH_ASSOC)){
                                ?>
                        <OPTION value="<?php  echo $row_p["codOcupacion"]?>"><?php echo $row_p["nomOcupacion"]; ?></OPTION>
                                <?php
                                }
                                ?>
                 </select>
                </div>
                <div class="form-group col-md-5">
                <div id="divGrupo">
                <label for="id_Grupo">Selecione Grupo</label>
                <select id="id_Grupo" name="id_Grupo" class="form-control">
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
                <div class="form-group col-md-2">
                <label for="idTipoProceso">TIPO</label>
                <select id="idTipoProceso" name="idTipoProceso" class="form-control"   onchange="cargarAsistencia('divResultado');" disabled>
                     <OPTION value="1" >INGRESO</OPTION>
                      <OPTION value="2">SALIDA</OPTION>
                </select>
                </div> 

        </div>


        <div class="form-row">
        <div class="form-group col-md-12">              
                <div id="divResultado2">
                        <!-- Carga lista empleados Turno -->
                </div>
        </div>	
        </div>
         </form> 
         
          </div>
         	
</div>										
</div>			
</div>

        