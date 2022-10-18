
<?php
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
$obj = new CFunciones;
if (isset($_POST["dato"])) 
{
	$codato = $_POST["dato"];

}
else
{	
	$codato = $id_Grupo; 
}


$query = "select o.codigoOcupacion,o.CodigoTipotarifa,d.codigogrupo,CONVERT(varchar(16),d.fechaIngreso,120) as inicio,CONVERT(varchar(16),d.fechaSalida,120) as fin,d.codDetalle,d.CantidaKG,d.CantidaUnd,d.nolaboral,d.asistencia,p.DNIempleado,concat(p.APEPATempleado,' ',p.APEMATempleado,' ',p.NombresEmpleado) as nomEnpleado,d.ImpTarifa,d.ImpTotal from DetalleCabRegistro d
inner join CabRegistroLab c on (c.codigoRegistro=d.codigoRegistro)
inner join GrupoTrabajo g on (g.codGrupoTrabajo=d.codigogrupo)
inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
inner join persona p on (p.codigoEmpleado=d.codigoEmpleado)
inner join Ocupacion o on (o.codigoOcupacion=c.codigoOcupacion)
where g.codGrupoTrabajo='$codato' and d.Estado=1 and t.Estado=0 and (d.asistencia=0 or d.asistencia=3) ORDER BY p.APEPATempleado,p.APEMATempleado,p.NombresEmpleado";
$smtv=$obj->consultar($query);
$numeroFilas = sqlsrv_num_rows($smtv);

?>

<div id="divResultadoRegistrosTab">
	<div class="table-responsive">
	<div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"> 

		<div class="row">
		<div class="col-sm-12">
			<table class="table table-hover">
				<thead>
				<tr>
				<th scope="col">#</th>
				<th></th>
				<th scope="col" style="text-align: center;">Apellidos / Nombres </th>
				<th scope="col" style="text-align: center;">Hora Inicio /Fin</th>
				<th scope="col" style="text-align: center;">Cantidad (kg)</th>
				<th scope="col" style="text-align: center;"></th>
			
				</tr>
				</thead>
				<tbody>
			<?php
			$count = 0;
			$sumaUnd = 0;
			$checkboxId = 0;
			while($row2 = sqlsrv_fetch_array($smtv,SQLSRV_FETCH_ASSOC)) 
			{ 	$count=$count+1;
				$checkboxId =  $checkboxId + 1;
				$sumaUnd = $sumaUnd+$row2['CantidaKG'] ;?>
				<tr>
				<td><?php echo $count; ?></td>
				<td>
					<input type="checkbox"  
					 <?php if($row2["asistencia"]<>0){ echo "checked"; } ?> 
						name="<?php echo "CheckName".$checkboxId; ?>" id="<?php echo "CheckName".$checkboxId; ?>"  class="form-control  " 
                onclick="EnviarProcesoKGmanualCheck('<?php echo $row2["codDetalle"]; ?>');"> 
				</td>
				<td><?php  echo $row2["DNIempleado"]." - ".$row2["nomEnpleado"]; ?></td>
				<td style="cursor: pointer;" onclick="cambiar_estilosV1('contenedor/formularios/Frm_Acciones_Manual.php?idDetalle=<?= $row2["codDetalle"]?>&idGrupo=<?= $row2["codigogrupo"]?>&idOcupacion=<?= $row2["codigoOcupacion"]?>')" data-toggle="modal" data-target="#Modal">
					
						<?php  echo $row2["inicio"]." - ".$row2["fin"]; ?>
				
				</td>
				<td style="text-align: center;"><?php  echo bcdiv($row2['CantidaKG'], '1', 3); ?></td>
				<td>
					<div class="btn-group " role="group" aria-label="Basic example">
					<button style="font-weight:bold; " type="button" class="btn btn-secondary"
					 onclick="EditarCantidadManual(
	                '<?php echo $row2["codDetalle"]; ?>',
	                '<?php echo $row2["codigogrupo"] ?>',1,1,'MANU');"
	                 <?PHP if($row2["CodigoTipotarifa"]==1){echo "disabled";}?>
	                >+</button>
					<button style="font-weight:bold; " type="button" class="btn btn-secondary"
					 onclick="EditarCantidadManual(
	                '<?php echo $row2["codDetalle"]; ?>',
	                '<?php echo $row2["codigogrupo"] ?>',1,2,'MANU');"
	                 <?PHP if($row2["CodigoTipotarifa"]==1){echo "disabled";}?>
	                >-</button>
	            	</div>
            	</td>
				</tr>
				
			<?php }?>
			<tr>
				<td colspan="2"></td>
				<td>&#8512; =&nbsp;<?php echo number_format($sumaUnd,3); ?></td>
				<td></td>
			</tr>
			</tbody>
			</table>
		</div>
		</div>


	</div>
	</div>


	<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content" id="contenedor-prow">
	     
	    </div>
	  </div>
	</div>

</div>

<!-- Modal -->



