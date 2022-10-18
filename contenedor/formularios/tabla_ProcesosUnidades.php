<div id="divResultadoProcesos">
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

$querypaginador = $obj->consultar("select count(*)as total from DetalleUnidades du
inner join CabRegistroLab cb on cb.codigoRegistro=du.CodigoRegistro
inner join TurnoGenerado tg on tg.codigoturno=cb.codigoTurno
inner join GrupoTrabajo gr on gr.codGrupoTrabajo=du.CodGrupo
where tg.estado=0 and  gr.codGrupoTrabajo='$codato' ");
$rows = sqlsrv_fetch_array($querypaginador,SQLSRV_FETCH_ASSOC);
$total_registro = $rows["total"];
$desde = ($pagina-1) * $por_pagina;
$total_paginas = ceil($total_registro / $por_pagina);

$query = "Select gr.NombreGrupo,du.NumDino  from DetalleUnidades du
inner join CabRegistroLab cb on cb.codigoRegistro=du.CodigoRegistro
inner join TurnoGenerado tg on tg.codigoturno=cb.codigoTurno
inner join GrupoTrabajo gr on gr.codGrupoTrabajo=du.CodGrupo
where tg.estado=0 and  gr.codGrupoTrabajo='$codato' order by du.idDetalle OFFSET $desde ROWS
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
			<th scope="col" style="text-align: center;">Nombre De Grupo</th>
			<th scope="col" style="text-align: center;">Dino Asig.</th>
			
		
			</tr>
			</thead>
			<tbody>
		<?php
		$count = $desde;
		$sumaUnd = 0;
		$sumaImp = 0;

		while($row2 = sqlsrv_fetch_array($smtv,SQLSRV_FETCH_ASSOC)) 
		{ $count=$count+1;
			
			?>
		
			<tr>
			<td><?php echo $count; ?></td>
			<td><?php  echo $row2["NombreGrupo"]; ?></td>
			<td style="text-align: center;"><?php  echo $row2["NumDino"]; ?></td>
			
			
		<?php }?>
		
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
      <a class="page-link" href="#" onclick="enviar_paginador3(<?php echo $pagina-1;?>,<?php echo $codato;?>,<?php echo $por_pagina; ?>);">Anterior</a>
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
            ?><li class="page-item"><a class="page-link" onclick="enviar_paginador3(<?php echo $i;?>,<?php echo $codato;?>,<?php echo $por_pagina; ?>);"><?php echo $i;?></a></li>
       
       
        <?php } }?>
    <li class="page-item <?php if($pagina >= $total_paginas){ echo "disabled";}?>">

      <a class="page-link" href="#" onclick="enviar_paginador3(<?php echo $pagina+1;?>,<?php echo $codato;?>,<?php echo $por_pagina; ?>);">Siguiente</a>
    </li>
  </ul>
</nav>
</div>

</div>

<!-- <div class="row">
	<div class="alert alert-danger" role="alert"></div>&nbsp;Cerro asistencia&nbsp;
	<div class="alert alert-success" role="alert"></div>&nbsp;Registra Hora no Laborable 
</div> -->


</div>
</div>
</div>