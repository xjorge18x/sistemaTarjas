
<?php
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
$obj = new CFunciones;

$CodDetalle =$_GET['idDetalle'];
$idGrupo =$_GET['idGrupo']; 
$idOcupacion =$_GET['idOcupacion']; 


$query = "select CONVERT(varchar(16),d.fechaIngreso,120) as inicio,CONVERT(varchar(16),d.fechaSalida,120) as fin,d.codDetalle,d.CantidaKG,d.CantidaUnd,d.nolaboral,d.asistencia,p.DNIempleado,concat(p.APEPATempleado,' ',p.APEMATempleado,' ',p.NombresEmpleado) as nomEnpleado,d.ImpTarifa,d.ImpTotal from DetalleCabRegistro d
inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
inner join GrupoTrabajo g on (g.codGrupoTrabajo=d.codigogrupo)
inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
inner join persona p on (p.codigoEmpleado=d.codigoEmpleado)
inner join Ocupacion o on (o.codigoOcupacion=c.codigoOcupacion)
where d.codDetalle='$CodDetalle' and g.codGrupoTrabajo='$idGrupo' and o.codigoOcupacion='$idOcupacion '";
$smtv=$obj->consultar($query);
$numeroFilas = sqlsrv_num_rows($smtv);
$row = sqlsrv_fetch_array($smtv,SQLSRV_FETCH_ASSOC);
?>



<!-- MODAL PARA NUEVO TIPO DE SALIDA -->
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Actualizar Datos</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true" style="font-size: 2.5rem;">&times;</span>
</button>
</div>
    <div class="modal-body">
      <div class="container-fluid">
        
    <form method="POST" name="ResitrarAccionesManuales" id="ResitrarAccionesManuales">
       <div class="form-group row">
           <div class="col">
                <label for="colFormLabel" class="col-form-label">Nombre :</label>
            </div>
            <div class="col">
              <label for="colFormLabel" class="col-form-label"><?= $row['nomEnpleado']?></label>
            </div>
      </div>
        <div class="form-group row">
           <div class="col">
                <label for="colFormLabel" class="col-form-label">Dni :</label>
            </div>
            <div class="col">
              <label for="colFormLabel" class="col-form-label"><?= $row['DNIempleado']?></label>
            </div>
      </div>
      <hr class="solid">
        <div class="form-group row ">
           
            <div class="col">            
                <div class="form-group"> 
                    <div class="input-group mb-2">
                    <div class="input-group-prepend">
                    <div class="input-group-text">Inicio&nbsp;<i class="fas fa-clock"></i></div>
                    </div>
                    <input value="<?= $row['inicio']?>" type="datetime-local" class="form-control" name="horaInicioEdit" id="horaInicioEdit" pattern="[0-9]{2}:[0-9]{2}">
                    </div>
                </div>
            </div>
            <div class="col">   
                <div class="form-group"> 
                    <div class="input-group mb-2">
                    <div class="input-group-prepend">
                    <div class="input-group-text">Fin&nbsp;<i class="fas fa-clock"></i></div>
                    </div>
                    <input value="<?= $row['fin']?>" type="datetime-local" class="form-control" name="horaFinEdit" id="horaFinEdit">
                 </div>
                </div>
            </div>
        </div>
    <input type="hidden" name="idOcupacionUPDATE" id="idOcupacionUPDATE" value="<?= $idOcupacion; ?>">
     <input type="hidden" name="CodDetalleUPDATE" id="CodDetalleUPDATE" value="<?= $CodDetalle; ?>">
     <input type="hidden" name="idGrupoUPDATE" id="idGrupoUPDATE" value="<?= $idGrupo; ?>">
    </form> 
    </div>
     
    </div>
<div class="modal-footer">
<button type="button" class="btn btn-primary" onclick="RegistrarAcionesManuales(1); return false">Eliminar</button>
<button type="button" class="btn btn-primary" onclick="RegistrarAcionesManuales(0); return false">Actualizar</button>
</div>




