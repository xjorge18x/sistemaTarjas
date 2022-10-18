<div id="divResultadoRegistros">
<?php
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
$obj = new CFunciones;
if (isset($_POST["dato"])) 
{
	$codato = $_POST["dato"];
	$pagina = $_POST["pagina"];	
}
else
{	
	$codato = $id_Grupo;
	$pagina=$pagina;
}
if(isset($_POST["NumeroFilas"])){
    $por_pagina = $_POST["NumeroFilas"];
}
else{
    $por_pagina=10;
}

$querypaginador = $obj->consultar("select count(*)as total from DetalleCabRegistro d
inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
inner join GrupoTrabajo g on (g.codGrupoTrabajo=d.codigogrupo)
inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
inner join persona p on (p.codigoEmpleado=d.codigoEmpleado)
where g.codGrupoTrabajo='$codato' and d.Estado=1 and t.Estado=0 and (d.asistencia=1 or d.asistencia=2)");
$rows = sqlsrv_fetch_array($querypaginador,SQLSRV_FETCH_ASSOC);
$total_registro = $rows["total"];
$desde = ($pagina-1) * $por_pagina;
$total_paginas = ceil($total_registro / $por_pagina);

$query = "select d.CantidaKG,d.CantidaUnd,d.nolaboral,d.asistencia,concat(p.APEPATempleado,' ',p.APEMATempleado,' ',p.NombresEmpleado) as nomEnpleado,d.ImpTarifa,d.ImpTotal from DetalleCabRegistro d
inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
inner join GrupoTrabajo g on (g.codGrupoTrabajo=d.codigogrupo)
inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
inner join persona p on (p.codigoEmpleado=d.codigoEmpleado)
where g.codGrupoTrabajo='$codato' and d.Estado=1 and t.Estado=0 and (d.asistencia=1 or d.asistencia=2) ORDER BY d.codDetalle OFFSET $desde ROWS
FETCH NEXT $por_pagina ROWS ONLY";
$smtv=$obj->consultar($query);
$numeroFilas = sqlsrv_num_rows($smtv);
$hasta = $desde+$numeroFilas;

?>

<div class="table-responsive">
<div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"> 

	<div class="row">
	<div class="col-sm-12">
		<table class="table table-hover">
			<thead>
			<tr>
			<th scope="col">#</th>
			<th scope="col" style="text-align: center;">Apellidos / Nombres P</th>
			<th scope="col" style="text-align: center;">Cantidad (kg)</th>
			<th scope="col" style="text-align: center;">Imp. Total</th>
		
			</tr>
			</thead>
		<?php
		$count = $desde;
		while($row2 = sqlsrv_fetch_array($smtv,SQLSRV_FETCH_ASSOC)) 
		{ $count=$count+1;?>
			<tbody>
			<tr <?php  if($row2["asistencia"]==2){  ?> class="marcadorOff2" <?php }  elseif(($row2["nolaboral"]==1) or ($row2["nolaboral"]==3)) { ?>  class="marcadorOff3" <?php }   ?>      >
			<td><?php echo $count; ?></td>
			<td><?php  echo $row2["nomEnpleado"]; ?></td>
			<td style="text-align: center;"><?php  echo bcdiv($row2['CantidaKG'], '1', 3); ?></td>
			<td style="text-align: center;"><?php  if($row2['ImpTotal']>0){ echo bcdiv($row2['ImpTotal'], '1', 5); }else { echo '0.00';} ?></td>
			</tr>
			</tbody>
		<?php }?>
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
		      <a class="page-link" href="#" onclick="enviar_paginador4(<?php echo $pagina-1;?>,<?php echo $codato;?>,<?php echo $por_pagina; ?>);">Anterior</a>
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
		            ?><li class="page-item"><a class="page-link" onclick="enviar_paginador4(<?php echo $i;?>,<?php echo $codato;?>,<?php echo $por_pagina; ?>);"><?php echo $i;?></a></li>
		       
		       
		        <?php } }?>
		    <li class="page-item <?php if($pagina >= $total_paginas){ echo "disabled";}?>">

		      <a class="page-link" href="#" onclick="enviar_paginador4(<?php echo $pagina+1;?>,<?php echo $codato;?>,<?php echo $por_pagina; ?>);">Siguiente</a>
		    </li>
		  </ul>
		</nav>
		</div>

	</div>

<div class="row">
	<div class="alert alert-danger" role="alert"></div>&nbsp;Cerro asistencia&nbsp;
	<div class="alert alert-success" role="alert"></div>&nbsp;Registra Hora no Laborable
</div>

</div>
</div>
</div>