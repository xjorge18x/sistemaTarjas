<div id="resultadoDet"> 
<?php
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
include("../../conectar.php");
$obj = new Cfunciones;
if (isset($_POST["TipoProc"])) 

{
	$pagina = $_POST["pagina"];
	$tipoproc =	$_POST["TipoProc"];
}
else
{	
	$pagina=$pagina;
	$tipoproc =	$tipoproc;
}


$por_pagina=5;
$querpaginador ="Select count(*)as total from Pallet_Generado
where estado NOT IN ('1') and TipoProceso='$tipoproc' and CONVERT (char(10), fecha, 120) >=(select CONVERT (char(10), SYSDATEtime(), 120))";
$smtvres=$obj->consultar($querpaginador);
$row2 = sqlsrv_fetch_array($smtvres,SQLSRV_FETCH_ASSOC);
$total_registro = $row2["total"];
$desde = ($pagina-1) * $por_pagina;
$total_paginas = ceil($total_registro / $por_pagina);

$query="Select IdPallet_Generado,CONVERT (char(5), Fecha, 108) as HoraReg,Estado,EstadoA,Capacidad_Max,dbo.DameEtiqueta(IdPallet_Generado)as etiqueta,isnull(NomPalet,IdPallet_Generado) as NomPalet
	from Pallet_Generado
where TipoProceso='$tipoproc' and estado NOT IN ('1') and CONVERT (char(10), fecha, 120) >=(select CONVERT (char(10), SYSDATEtime(), 120))
ORDER BY IdPallet_Generado asc OFFSET $desde ROWS FETCH NEXT $por_pagina ROWS ONLY";
$smtv=$obj->consultar($query);
$numeroFilas = sqlsrv_num_rows($smtv);
?>
<div id="NumeroPaginaId" class="respuestaMsg"><?php echo $pagina; ?></div>
<div id="tipoproc" class="respuestaMsg"><?php echo $tipoproc; ?></div>
<?php if ($numeroFilas<>0) {?>

<div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
<div class="row">
<div class="col-12 col-lg-12 col-sm-12 movil"> 

		<table class="table table-hover table-sm ">
			<thead>
			<tr>
			<th scope="col">#</th>
			<th scope="col" style="text-align: center;">Palet</th>
			<th scope="col" style="text-align: center;">Estado</th>
			<th scope="col" style="text-align: center;">Cjs</th>
			<th colspan="2" scope="col" style="text-align: center;"></th>
			</tr>
			</thead>
			<?php
			$count = $desde;
			while($row2 = sqlsrv_fetch_array($smtv,SQLSRV_FETCH_ASSOC)) 
			{ $count=$count+1;
			$codPalet=$row2["IdPallet_Generado"];
			$query_r1="select dbo.damenrocajas($codPalet) as nmracjas";
			$stmt = sqlsrv_query( $conectar, $query_r1, array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
    		$row_R1 = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC);
			?>
			<tbody>
			<tr class=" <?php echo ($row2['EstadoA']==1)?'color-verde':'sin-color' ?>">
			<th scope="row">
				<div class="div3"><a> <?php echo $count; ?>
				<span> <?php  echo $row2["IdPallet_Generado"]; ?> </span></a>
				</div>

				</th>
			<td style="text-align: center;"><a onclick="MostrarDetalle('<?php echo $codPalet;?>','<?php echo $row_R1["nmracjas"];?>');"><?php  echo $row2["NomPalet"]; ?></a></td>
			<td><?php if(($row2["Estado"]==0) or ($row2["Estado"]==3))
			{
			echo "<div class='alert alert-success' role='alert' style='text-align: center;margin-top: 8px;margin-bottom: 8px'>ON</div>";
			} else{echo "<div class='alert alert-danger' role='alert' style='text-align: center;margin-top: 8px;margin-bottom: 8px ;'>OFF</div>";}   ?>
				
			</td>
			<td style="text-align: center;"><?php echo $row_R1["nmracjas"];?></td>
			<td>
			<?php if(($row2["EstadoA"]==0)){?>
			<a onclick="cambiar_estilosV1('contenedor/etiquetado/frm_agregarCajasPalet.php?idPalet=<?php echo $row2["IdPallet_Generado"]; ?>&frm=1&pagina=<?php echo $pagina; ?>&TipoProc=<?php echo $tipoproc;?>')" data-toggle="modal" data-target="#myModal">
			<i class="fas fa-plus-circle fa-2x" style="color:#af2d2d"></i></a>
			<?php }?>
			</td>
			<td>
			<?php

			if (($row_R1["nmracjas"]==0) and ($row2["Estado"]<>2)) {
				?>
				<a onclick="RegistrarPalets(1,<?php  echo $row2["IdPallet_Generado"]; ?>);">
				<i class="fas fa-times-circle fa-2x"></i></a>
			<?php }

			else if (($row_R1["nmracjas"]<>0)) {?>
			<a onclick="writeToSelectedPrinter('<?php echo $row2["etiqueta"]; ?>')">
			<i class="fas fa-print fa-2x" style="color:#43658b"></i></a>
			<?php }
				
			?>
			</td>

			</tr>
			</tbody>
			<?php }?>

		</table>

</div>
</div>


	<div class="row">
	<div class="col-lg-12 col-12 d-flex col-sm-12 justify-content-sm-center justify-content-md-center justify-content-lg-end  justify-content-center ">

	<nav aria-label="Page navigation example">
	  <ul class="pagination justify-content-sm-center flex-wrap">
	    <li class="page-item <?php if($pagina <= 1){echo "disabled";} ?>">
	     <a class="page-link" href="#" aria-label="Previous" onclick="enviar_paginadorE('<?php echo $pagina-1;?>','<?php echo $tipoproc;?>')">
	        <span aria-hidden="true">&laquo;</span>
	      </a>
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
				?><li class="page-item"><a class="page-link" onclick="enviar_paginadorE('<?php echo $i;?>','<?php echo $tipoproc;?>');"><?php echo $i;?></a></li>

				<?php } }?>
	    <li class="page-item <?php if($pagina >= $total_paginas){ echo "disabled";}?>">
	       <a class="page-link" href="#" aria-label="Next" onclick="enviar_paginadorE('<?php echo $pagina+1;?>',<?php echo $tipoproc;?>);">
	        <span aria-hidden="true">&raquo;</span>
	      </a>
	    </li>
	  </ul>
	</nav>
	</div>

	</div>

	<div>
		
		<div id="ResDetalle">
			
		</div>

	</div>

</div>
<?php }?>
</div>



