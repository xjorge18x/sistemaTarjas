
<div id="resultadoDet"> 
<?php
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
$obj = new Cfunciones;
if(isset($_POST["dato"]) and isset($_POST["idTipoTurno"]) )
{
    $codato = $_POST["dato"];
    $idTipoTurno = $_POST["idTipoTurno"];
    $pagina = $_POST["pagina"];
    
}
else
{ 
    $codato = $codGrupo; 
    $idTipoTurno=$idTipoTurno;
    $pagina=$pagina;
}

if(isset($_POST["NumeroFilas"])){
    $por_pagina = $_POST["NumeroFilas"];
}
else{
    $por_pagina=5;
}

if(isset($_POST["OrdenarTabla"])){
   $ordenar = $_POST["OrdenarTabla"];

   if ($ordenar==1) {
    $ordenar='asc';
   }
   elseif($ordenar==2){
    $ordenar='desc';
   }

}
else{
    $ordenar='asc';
}
?>
<div id="NumeroPaginaId" class="respuestaMsg"><?php echo $pagina; ?></div>
<div id="NumeroFilas" class="respuestaMsg"><?php echo $por_pagina; ?></div>
<div id="OrdenarTabla" class="respuestaMsg"><?php echo $ordenar; ?></div>
<?php
/*Paginador*/
$queryPag=$obj->consultar("select count(*)as total from DetalleCabRegistro d
inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
inner join GrupoTrabajo g on (g.codGrupoTrabajo=d.codigogrupo)
inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
inner join persona p on (p.codigoEmpleado=d.codigoEmpleado)
where g.codGrupoTrabajo='$codato' and d.Estado=1 and t.Estado=0 ;");
$rows = sqlsrv_fetch_array($queryPag,SQLSRV_FETCH_ASSOC);
$total_registro = $rows["total"];
$desde = ($pagina-1) * $por_pagina;
$total_paginas = ceil($total_registro / $por_pagina);
/*Fin Paginador*/
$codetalle = 'codDetalle';
$query="select d.nolaboral,p.DNIempleado,p.foto,d.codigoRegistro,d.codDetalle,d.codigogrupo,g.NombreGrupo,d.codigoEmpleado,concat(p.APEPATempleado,' ',p.APEMATempleado,' ',p.NombresEmpleado) as nomEnpleado,CONVERT (char(5), d.fechaIngreso, 108) as fechaIngreso,CONVERT (char(5), d.fechaSalida, 108) as fechaSalida,d.asistencia from DetalleCabRegistro d
inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
inner join GrupoTrabajo g on (g.codGrupoTrabajo=d.codigogrupo)
inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
inner join persona p on (p.codigoEmpleado=d.codigoEmpleado)
where g.codGrupoTrabajo='$codato' and t.Estado=0 and d.Estado=1 ORDER BY codDetalle $ordenar OFFSET $desde ROWS
FETCH NEXT $por_pagina ROWS ONLY";
$smtv=$obj->consultar($query);
$numeroFilas = sqlsrv_num_rows($smtv);
$hasta = $desde+$numeroFilas;
?>


<div class="table-responsive">
<div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="dataTables_length" id="cantFilas">
            <label>Mostrar 
                <select name="cantFilas" id="cantFilas" class="custom-select custom-select-sm form-control form-control-sm" onchange="cargarAsistenciaConLimitet(this.value,'divResultado','<?php echo $ordenar;?>',1);">
                    <option value="5" <?php if($por_pagina==5){ echo "selected"; } ?> >5</option>
                    <option value="10" <?php if($por_pagina==10){ echo "selected"; } ?>>10</option>
                    <option value="25" <?php if($por_pagina==25){ echo "selected"; } ?>>25</option>
                    <option value="50" <?php if($por_pagina==50) { echo "selected"; }?>>50</option>

                </select> registros
            </label>
        </div>
    </div>
</div>

    <div class="row">
    <div class="col-sm-12">
<table class="table table-hover" style="width:100%" id="myTable1">
<thead>
    <tr>
        <th>#</th>
        <th style="text-align: center;" onclick="sortTable(0)">Apellidos / Nombres 

        <?php
            if ($ordenar=='asc') {?>
                <i class="desc" onclick="ordenar(2,'divResultado',2,<?php echo $por_pagina; ?>);"></i>
            <?php }

            elseif ($ordenar='desc') {?>
                <i class="asc" onclick="ordenar(1,'divResultado',2,<?php echo $por_pagina; ?>);"></i>
        <?php }?>

        </th>
        <th style="text-align: center;">Registro </th>
        <th style="text-align: center;"> Inicio</th>
        <th style="text-align: center;"> Fin</th>
    </tr>
</thead>
<tbody>
    <?php 
    $count = $desde;
    $checkboxId = 0;
    while($row2 = sqlsrv_fetch_array($smtv,SQLSRV_FETCH_ASSOC))
    {
        $count=$count+1;
        $checkboxId =  $checkboxId + 1;
        ?>
        
            <tr  <?php  if($row2["asistencia"]<>0){  ?> class="marcadorOff" <?php } ?>>
                <td scope="row"><?php echo $count; ?></td>
                <td><div class="div1"><a> <?php  echo $row2["nomEnpleado"]; ?>
                <!-- <img data-toggle="modal" data-target="#Modal" onerror="this.onerror=null;this.src='img/obrero/nofount.jpg';" src="<?php echo $row2['foto']; ?>" alt="imagen" onclick="image('<?php echo $row2['foto']; ?>','<?php echo $row2['codigoEmpleado']; ?>')"/> </a> --></div>
                </td>
                <td>
                <?php
                if ($idTipoTurno==1) // ingreso
                {

                ?>
                <input type="checkbox" <?php if($row2["asistencia"]<>0){ echo "checked"; } ?>  name="<?php echo "CheckName".$checkboxId; ?>" id="<?php echo "CheckName".$checkboxId; ?>"  class="form-control  " 
                onclick="enviar_asistencia('<?php echo $row2["codDetalle"]; ?>', '<?php echo $idTipoTurno; ?>', '<?php echo $codato ?>', '<?php echo $row2["asistencia"]; ?>','<?php echo $pagina ?>','<?php echo $por_pagina?>');"> 
                <?php
                }
                else
                { // salida

                ?>
                <input type="checkbox"   <?php if($row2["asistencia"]==0){ echo "disabled"; } ?> <?php if($row2["asistencia"]==2){ echo "checked"; } ?>  name="<?php echo "CheckName".$checkboxId; ?>" id="<?php echo "CheckName".$checkboxId; ?>"  class="form-control " 
                onclick="enviar_asistencia('<?php echo $row2["codDetalle"]; ?>', '<?php echo $idTipoTurno; ?>', '<?php echo $codato ?>', '<?php echo $row2["asistencia"]; ?>','<?php echo $pagina ?>','<?php echo $por_pagina?>');"> 
                <?php
                }
                ?>

                </td>

                <td><?php echo $row2["fechaIngreso"];?></td>
                <td><?php echo $row2["fechaSalida"]?></td>
                <?php if(($_SESSION['u_perfil']==1) and ($row2["asistencia"]<>2) and ($row2["asistencia"]<>1)  and ($row2["nolaboral"]!=1) and ($row2["nolaboral"]!=2) and ($row2["nolaboral"]!=3) and ($row2["nolaboral"]!=4)){?>
                <td><a href="#" onclick="eliminarRegistroAsistencia(<?php echo $row2["codDetalle"]; ?>,<?php echo $idTipoTurno; ?>,<?php echo $pagina ?>,<?php echo $por_pagina?>,<?php echo $row2["codigogrupo"]?>,'<?php echo $ordenar;?>');"><i class="far fa-trash-alt fa-lg" style="color:red;"></i></a></td>
                 <?php }?>
            </tr>
        
        <?php
    }
     ?>
    </tbody>
</table>
    </div>
    </div>

<div class="row">
    <div class="col-lg-4 col-sm-12 d-flex justify-content-sm-center justify-content-md-center justify-content-lg-start justify-content-center">
    <div class="dataTables_info" id="example_info" role="status" aria-live="polite">Registros del <?php echo $desde+1;?> al <?php echo $hasta;?> de un total de <?php echo $total_registro;?> registros</div>
    </div>
<div class="col-lg-8 d-flex col-sm-12 justify-content-sm-center justify-content-md-center justify-content-lg-end justify-content-center">

<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-sm-center flex-wrap">
    <li class="page-item <?php if($pagina <= 1){echo "disabled";} ?>">
      <a class="page-link" href="#" onclick="enviar_paginador(<?php echo $pagina-1;?>,<?php echo $codato;?>,<?php echo $idTipoTurno?>,<?php echo $por_pagina; ?>,'<?php echo $ordenar?>');">Anterior</a>
    </li>

    <?php
    for ($i=1; $i <= $total_paginas; $i++) { 
        if($i == $pagina)
					{
    ?>
            <li class="page-item active"><a class="page-link"><?php echo $i;?></a></li>
         <?php }
         else
         {
            ?><li class="page-item"><a class="page-link" onclick="enviar_paginador(<?php echo $i;?>,<?php echo $codato;?>,<?php echo $idTipoTurno?>,<?php echo $por_pagina; ?>,'<?php echo $ordenar?>');"><?php echo $i;?></a></li>
       
       
        <?php } }?>
    <li class="page-item <?php if($pagina >= $total_paginas){ echo "disabled";}?>">

      <a class="page-link" href="#" onclick="enviar_paginador(<?php echo $pagina+1;?>,<?php echo $codato;?>,<?php echo $idTipoTurno?>,<?php echo $por_pagina; ?>,'<?php echo $ordenar?>');">Siguiente</a>
    </li>
  </ul>
</nav>
</div>

</div>


</div>
</div>
</div>



<!-- Modal -->

<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content " id="contenedor-prow">

        <div class="modal1">
          <span class="close" data-dismiss="modal">&times;</span>
            <div id="resultadoImg">
            
          </div>
          <div id="caption"></div>
        </div>
        
    </div>
  </div>
</div>
