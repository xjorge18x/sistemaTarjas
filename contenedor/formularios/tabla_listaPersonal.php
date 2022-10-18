<?php 
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
$obj = new CFunciones;

$codigoGrupo = $_POST["dato"];

$query = "select p.codigoEmpleado,p.DNIempleado,CONCAT(p.APEPATempleado,' ',p.APEMATempleado,' ',P.NombresEmpleado)as nombre,P.NombresEmpleado,CONCAT(p.APEPATempleado,' ',p.APEMATempleado)as apellido,
g.NombreGrupo,o.NombreOcupacion,l.NombreLinea from detalleOcupacionEmpleado d
inner join persona p on(p.codigoEmpleado=d.codigoEmpleado)
inner join GrupoTrabajo g on(g.codGrupoTrabajo=d.codGrupoTrabajo)
inner join Ocupacion o on (o.codigoOcupacion=g.codigoOcupacion)
inner join linea l on (l.codigoLinea=o.codigoLinea)
where d.codGrupoTrabajo='$codigoGrupo' ";
$smtv = $obj->consultar($query);

?>


<div class="table-responsive">
<div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"> 
<!-- 	<div class="row">
		<div class="form-group col-md-4 col-sm-4">
			 <label for="id_linea" ></label>
	       <a class="form-control" href="pagina1.php?grupo=<?php  echo $codigoGrupo = $_POST["dato"];?>" target="blank"><i class="far fa-id-card fa-lg"></i>
	       </a>
      </div>
	</div>
 -->

	<div class="form-check" style="text-align: center;">
		<a href="pagina1.php?grupo=<?php  echo $codigoGrupo = $_POST["dato"];?>" target="blank"><i class="far fa-id-card fa-lg"></i></a>
		<label class="form-check-label" for="defaultCheck1"> Imprime Grupo</label>
	</div><br>


	<div class="row">
	<div class="col-sm-12">
		<table class="table table-hover">
			<thead>
			<tr>
			<th scope="col">#</th>
			<th scope="col" style="text-align: center;">Apellidos / Nombres</th>
			<th scope="col"></th>
			</tr>
			</thead><?PHP 
			$count = 0;
			while($row2 = sqlsrv_fetch_array($smtv,SQLSRV_FETCH_ASSOC)) 
			{$count=$count+1 ;?>
			<tbody>
			<tr>
			<td ><?php  echo $count; ?></td>
			<td><?php  echo $row2["nombre"]; ?></td>
			<td style="text-align: center;"><a href="cardPersonal.php?codigo=<?php  echo $row2["DNIempleado"]; ?>&Apellidos=<?php  echo $row2["apellido"]; ?>&nombre=<?php  echo $row2["NombresEmpleado"]; ?>&ocupacion=<?php  echo $row2["NombreOcupacion"]; ?>" target="blank"><i class="far fa-id-card fa-lg"></i></a></td>
			</tr>
			</tbody>
		<?php }?>
		</table>
	</div>
	</div>
</div>
</div>