
<?php
	require_once("../../cont/CFunciones.php");
	include_once("../../verificar.php");
$obj = new CFunciones();

$codato = ((isset($_REQUEST["dato"])) ) ? $_REQUEST["dato"] : $id_Grupo; 
$codOcupacion = ((isset($_REQUEST["dato2"])) ) ? $_REQUEST["dato2"] : $id_Ocupacion; 


$query1="select o.CodigoTipotarifa,c.codigoRegistro
from Ocupacion o
inner join CabRegistroLab c on c.codigoOcupacion=o.codigoOcupacion
inner join TurnoGenerado t on t.codigoturno=c.codigoTurno
where o.codigoOcupacion='$codOcupacion' and t.estado=0";
$smtv1=$obj->consultar($query1);
$row1 = sqlsrv_fetch_array($smtv1,SQLSRV_FETCH_ASSOC);
$CodRegistro = $row1['codigoRegistro'];

$query = "select 
isnull((SELECT Sg.NomSubGrupo FROM Sub_grupoLaboral sg 
inner join Detalle_subGrupoLab dg on (dg.id_subgrupo=sg.id_subgrupo)
WHERE sg.codigoRegistro=c.codigoRegistro and dg.id_empleado=d.codigoEmpleado and dg.estado=1),'NA') as Subgrupo,
isnull((SELECT Sg.id_subgrupo FROM Sub_grupoLaboral sg 
inner join Detalle_subGrupoLab dg on (dg.id_subgrupo=sg.id_subgrupo)
WHERE sg.codigoRegistro=c.codigoRegistro and dg.id_empleado=d.codigoEmpleado and dg.estado=1),0) as CodSubGrupo,
d.codigoEmpleado,o.codigoOcupacion,o.CodigoTipotarifa,d.codigogrupo,CONVERT(varchar(16),d.fechaIngreso,120) as inicio,CONVERT(varchar(16),d.fechaSalida,120) as fin,d.codDetalle,d.CantidaKG,d.CantidaUnd,d.nolaboral,d.asistencia,p.DNIempleado,concat(p.APEPATempleado,' ',p.APEMATempleado,' ',p.NombresEmpleado) as nomEnpleado,d.ImpTarifa,d.ImpTotal 
From DetalleCabRegistro d
inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
inner join GrupoTrabajo g on (g.codGrupoTrabajo=d.codigogrupo)
inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
inner join persona p on (p.codigoEmpleado=d.codigoEmpleado)
inner join Ocupacion o on (o.codigoOcupacion=c.codigoOcupacion)
where g.codGrupoTrabajo='$codato' and d.Estado=1 and t.Estado=0 and
(d.asistencia=1 or d.asistencia=2)
ORDER BY p.APEPATempleado,p.APEMATempleado,p.NombresEmpleado";
$smtv = $obj -> consultar($query);
?>

<div id="CodRegistro" class="respuestaMsg"><?php echo $CodRegistro; ?></div>

<div id="divResultadoRegistrosTabSubGrupos">
	<div class="row">
		<div class="col-sm-12">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th scope="col">Apellidos / Nombres</th>
						<th></th>
					</tr>
				</thead>
				<?php
					$Count=0;
					while ($row = sqlsrv_fetch_array($smtv,SQLSRV_FETCH_ASSOC) ) {
					$Count=$Count+1;?>
					<tr>
						<td><?= $Count?></td>
						<td style="cursor:pointer"><?= $row['nomEnpleado']." - ".$row["Subgrupo"];?></td>
						<td>
						<input type="checkbox" class="form-control form-control-sm CheckedSubG" id="<?= $row['codDetalle'];?>" name="CodDetalleEmpleado" value="<?= $row['codigoEmpleado'];?>" 
						<?php if ($row['Subgrupo']<>'NA') {echo "disabled"." ". "checked";}?>>
						</td>
					</tr>

				<?php }
				?>
				<tbody>
					
				</tbody>
			</table>
		</div>
	</div>

</div>