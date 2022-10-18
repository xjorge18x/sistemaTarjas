<?php
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
$obj = new CFunciones;
$count = 0;
if (isset($_POST["dato"])) 
{
	$codato = $_POST["dato"];
}
else
{	
	$codato = $id_Grupo;
}

$query ="select o.NombreOcupacion,sum(dp.munBachadas)as total from DetalleAvancePrecocido dp
inner join CabRegistroLab c on (c.codigoRegistro=dp.codigoRegistro)
inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
inner join GrupoTrabajo g on (g.codGrupoTrabajo=dp.codigoGrupo)
inner join Ocupacion o on (o.codigoOcupacion=g.codigoOcupacion)
where t.estado=0 and c.estado=1 and  g.codGrupoTrabajo='$codato' group by o.NombreOcupacion";

$smtv = $obj->consultar($query);


?>
<div id="divResultadoRegistros">

<div class="table-responsive">

<div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"> 

	<div class="row">

	<div class="col-sm-12">

	<table class="table table-hover">

		<thead>

			<th>#</th>
			<th scope="col" style="text-align: center;">Grupo</th>
			<th scope="col" style="text-align: center;">Cantidad</th>

		</thead>
<?php while($row = sqlsrv_fetch_array($smtv,SQLSRV_FETCH_ASSOC)){ $count=$count+1;?>
		<tbody>

			<tr>
				<td><?php echo $count; ?></td>
				<td><?php echo $row["NombreOcupacion"]; ?></td>
				<td style="text-align: center;"><?php echo $row["total"]; ?></td>
			</tr>

		</tbody>
<?php }?>
	</table>

	</div>

	</div>

</div>

</div>

</div>