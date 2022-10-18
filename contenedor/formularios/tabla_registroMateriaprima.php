
<?php 
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
$obj = new CFunciones;
$query="select e.NombreEspecie,CONVERT (char(5), r.fecha_recepcion, 108) as fechaIngreso,CONCAT(r.cantidad,' KG') as cantidad,p.parametro_text as tipo,pa.parametro_text as turno
from reg_Recepcion r
inner join parametro_sys p on (p.id=r.IdtipoRecepcion)
inner join parametro_sys pa on (pa.id=r.idTruno)
inner join tipoEspecie e on (e.codigoEspecie=r.codigoEspecie)
where CONVERT (char(10), r.fecha_recepcion, 120) >=(select CONVERT (char(10), SYSDATEtime(), 120))";
$smtv=$obj->consultar($query);
?>

<div class="table-responsive">
<div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"> 


<div class="row">
	<div class="col-sm-12">
		<table class="table table-hover">
			<thead>
			<tr>
			<th scope="col">#</th>
			<th scope="col" style="text-align: center;">Especie</th>
			<th scope="col" style="text-align: center;">Tipo Recepción</th>
			<th scope="col" style="text-align: center;">Turno</th>
			<th scope="col" style="text-align: center;">Hora</th>
			<th scope="col" style="text-align: center;">Cantidad</th>
		
			</tr>
			</thead>
			<?php
			$count = 0;
			while($row2 = sqlsrv_fetch_array($smtv,SQLSRV_FETCH_ASSOC)) 
			{ $count=$count+1;?>
			<tbody>
			<tr>
			<td><?php echo $count; ?></td>
			<td style="text-align: center;"><?php  echo $row2["NombreEspecie"]; ?></td>
			<td style="text-align: center;"><?php  echo $row2["tipo"]; ?></td>
			<td style="text-align: center;"><?php  echo $row2["turno"]; ?></td>
			<td style="text-align: center;"><?php  echo $row2["fechaIngreso"]; ?></td>
			<td style="text-align: center;"><?php  echo $row2["cantidad"]; ?></td>
			</tr>
			</tbody>
			<?php }?>
		
		</table>
	</div>
</div>
</div><!-- div fin tdataTables_wrapper -->
</div><!-- div fin table-responsive -->