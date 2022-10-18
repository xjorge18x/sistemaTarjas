<?php
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
$obj = new CFunciones;
$query = "select * from DETALLE where estado_e=0 order by NUBATCH asc";
$smtv=$obj->consultar2($query);
$numeroFilas = sqlsrv_num_rows($smtv);
?>
<div id="Tabla1">
		<table class="table table-hover">
			<thead>
				<tr>
				<th scope="col">N° Batch</th>
				<th scope="col" style="text-align: center;">Tara</th>
				<th scope="col" style="text-align: center;">P. Neto</th>
				<th scope="col" style="text-align: center;">P. Acumulado</th>
				<th scope="col" style="text-align: center;"></th>
				</tr>
			</thead>
			<tbody>
			<?php
			while ($rows = sqlsrv_fetch_array($smtv,SQLSRV_FETCH_ASSOC)) 
				{?>
				<tr>
					<td><?= $rows['NUBATCH'];?></td>
					<td style="text-align: center;"><?php  echo bcdiv($rows['DETARA'], '1', 3); ?></td>
					<td style="text-align: center;"><?php  echo bcdiv($rows['DENETO'], '1', 3); ?></td>
					<td style="text-align: center;"><?php  echo bcdiv($rows['DEACUMULA'], '1', 3); ?></td>
					<td>
						<select id="idaccion" name="idaccion" onchange="RegistrarDistribucionS(this.value,<?= $rows['IDDETALLE']?>);" >
			                <OPTION value="0">SIN ACCION</OPTION>
			                <OPTION value="1">TUBO</OPTION>
			                <OPTION value="2">ALETA</OPTION>
			                <OPTION value="3">CABEZA</OPTION>
			                <OPTION value="4">TENTACULO</OPTION>
			            </select>
			        </td>
				</tr>
		  <?php }?>

			</tbody>
		</table>

<?php
$query2="SELECT S.nombre,SUM(DENETO)AS TOTAL
FROM sesion S
INNER JOIN DETALLE D ON (D.id_sesion=S.id)
WHERE D.estado_e=1 
GROUP BY S.nombre
ORDER BY TOTAL DESC";
$smtv2=$obj->consultar2($query2);

?>

			<table class="table table-hover">
				<thead>
					<tr>
					<th scope="col">#</th>
					<th scope="col" style="text-align: center;">Especie</th>
					<th scope="col" style="text-align: center;">P. Acumulado</th>				
					</tr>
				</thead>
				<tbody>
			<?php
			$count2 = 0;
			while ($rows2 = sqlsrv_fetch_array($smtv2,SQLSRV_FETCH_ASSOC)) {
				$count2 = $count2+1;
				?>
				<tr>
					<td><?= $count2;?></td>
					<td><?= $rows2['nombre'];?></td>
					<td><?= $rows2['TOTAL'];?></td>
				</tr>
				

		<?php	}
			?>

				</tbody>
			</table>

</div>




