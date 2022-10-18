<?php
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
$obj = new CFunciones;
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
