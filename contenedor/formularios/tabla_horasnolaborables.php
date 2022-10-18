<?php 
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
$obj = new CFunciones;
if (isset($_POST["dato"])) 
{
	$codigo = $_POST["dato"];
	$pagina = $_POST["pagina"];	

}
else
{	
	$codigo = $id_Grupo;
	$pagina = $pagina;
	
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
$querpaginador = "select count(*)as total from reghorasNolaborables r
inner join DetalleCabRegistro d on (d.codDetalle=r.codigodetallelaboral)
inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
inner join GrupoTrabajo g on (g.codGrupoTrabajo=d.codigogrupo)
inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
inner join persona p on (p.codigoEmpleado=d.codigoEmpleado)
where g.codGrupoTrabajo='$codigo' and t.Estado=0 and d.Estado=1";
$smtvres=$obj->consultar($querpaginador);
$row2 = sqlsrv_fetch_array($smtvres,SQLSRV_FETCH_ASSOC);
$total_registro = $row2["total"];
$desde = ($pagina-1) * $por_pagina;
$total_paginas = ceil($total_registro / $por_pagina);

$query = "select r.id,r.tipo,d.codigogrupo,d.codDetalle,d.nolaboral,a.NombreTipo,concat(p.APEPATempleado,' ',p.APEMATempleado,' ',p.NombresEmpleado)as nomEnpleado ,CONVERT (char(5), r.inicio, 108)as horainicio,CONVERT (char(5), r.fim, 108)as horafim from DetalleCabRegistro d
		inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
		inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno) 
		inner join reghorasNolaborables r on (d.codDetalle=r.codigodetallelaboral)
		inner join persona p on (p.codigoEmpleado=d.codigoEmpleado)
		inner join TipoSalida a on (a.codigotipo=r.codigoTipoSalida)
		where t.estado=0  and d.codigogrupo='$codigo' and t.Estado=0 and d.Estado=1 order by r.id $ordenar OFFSET $desde ROWS FETCH NEXT $por_pagina ROWS ONLY";
$smtv=$obj->consultar($query);
$numeroFilas = sqlsrv_num_rows($smtv);
$hasta = $desde+$numeroFilas;
//sleep(1);
 ?>

<div id="resultado">
<div class="table-responsive">
<div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"> 

<div class="row">
	<div class="col-sm-12 col-md-6">
		<div class="dataTables_length" id="cantFilas">
		<label>Mostrar 
		<select name="cantFilas" id="cantFilas" class="custom-select custom-select-sm form-control form-control-sm" onchange="cargarAsistenciaConLimitet(this.value,'resultadoPrincipal','<?php echo $ordenar;?>',2);">
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
		<table class="table table-hover">
			<thead>
			<tr>
			<th scope="col">#</th>
			<th scope="col" style="text-align: center;">Apellidos / Nombres
			<?php
			if ($ordenar=='asc') {?>
				<i class="desc" onclick="ordenar(2,'resultadoPrincipal',1,<?php echo $por_pagina; ?>);"></i>
			<?php }

			elseif ($ordenar='desc') {?>
				<i class="asc" onclick="ordenar(1,'resultadoPrincipal',1,<?php echo $por_pagina; ?>);"></i>
			<?php }?>
			
			</th>
			<th scope="col">Incio</th>
			<th scope="col">Fin</th>
			<th scope="col" style="text-align: center;">Tipo</th>
			</tr>
			</thead>
		<?php
		$count = $desde;
		while($row2 = sqlsrv_fetch_array($smtv,SQLSRV_FETCH_ASSOC)) 
		{ $count=$count+1 ;?>
			<tbody>
			<tr>
			<td><?php  echo $count; ?></td>
			<td><?php  echo $row2["nomEnpleado"]; ?></td>
			<td><?php echo $row2["horainicio"];?></td>
			<td><?php echo $row2["horafim"];?></td>
			<td style="text-align: center;"><p class="text-danger"><?php echo $row2["NombreTipo"];?></p></td>
			<td>

			<?php if(($row2["tipo"]==1)) {?> 
			<a href="#" onclick="eliminarHoranoLaboral(<?php echo $row2["codDetalle"]; ?>,<?php echo $pagina; ?>,<?php echo $por_pagina; ?>,<?php echo $row2["codigogrupo"]; ?>,<?php echo $row2["id"]; ?>,<?php echo $row2["nolaboral"]; ?>,'<?php echo $ordenar; ?>',<?php echo $por_pagina; ?>)">
			<i class="fas fa-user-times" style="color:red;"></i> 
			</a>
			<?php } ?>  

			</td>
			</tr>
			</tbody>
		<?php }?>
		</table>
	</div>
</div>

<div class="row">
    <div class="col-lg-4 col-sm-12 d-flex justify-content-sm-center justify-content-md-center">
	    <div class="dataTables_info" id="example_info" role="status" aria-live="polite">Registros del <?php echo $desde+1;?> al <?php echo $hasta;?> de un total de <?php echo $total_registro;?> registros</div>
	</div>
	<div class="col-lg-8 d-flex col-sm-12 justify-content-sm-center justify-content-md-center justify-content-lg-end ">
		<nav aria-label="Page navigation example">
			<ul class="pagination justify-content-sm-center flex-wrap">
			<li class="page-item <?php if($pagina <= 1){echo "disabled";} ?>">
			<a class="page-link" href="#" onclick="enviar_paginador2(<?php echo $pagina-1;?>,<?php echo $codigo;?>,<?php echo $por_pagina; ?>,'<?php echo $ordenar; ?>');">Anterior</a>
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
			?><li class="page-item"><a class="page-link" onclick="enviar_paginador2(<?php echo $i;?>,<?php echo $codigo;?>,<?php echo $por_pagina; ?>,'<?php echo $ordenar;?>');"><?php echo $i;?></a></li>


			<?php } }?>
			<li class="page-item <?php if($pagina >= $total_paginas){ echo "disabled";}?>">

			<a class="page-link" href="#" onclick="enviar_paginador2(<?php echo $pagina+1;?>,<?php echo $codigo;?>,<?php echo $por_pagina; ?>,'<?php echo $ordenar; ?>');">Siguiente</a>
			</li>
			</ul>
		</nav>
	</div>
</div>


</div>
</div>
</div>