<?php
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
include("../../conectar.php");
$obj =  new CFunciones();

if ($tipo==1) {
	$query = $obj->consultar("SELECT G.NomSubGrupo,G.id_subgrupo FROM Sub_grupoLaboral G WHERE codigoRegistro=$CodRegistro AND
(SELECT COUNT(*) FROM Detalle_subGrupoLab D
WHERE D.id_subgrupo=G.id_subgrupo AND d.estado=1)>0");?>

	<table class="table table-hover">
		<?php
		while ($row = sqlsrv_fetch_array($query,SQLSRV_FETCH_ASSOC)) {
			?>
		<thead><th scope="col"><?= $row['NomSubGrupo'];?></th></thead>
<?php
$query2 = "SELECT D.id_subgrupo,D.id_empleado ,concat(P.APEPATempleado,' ',P.APEMATempleado,' ',P.NombresEmpleado) as nomEnpleado
FROM Detalle_subGrupoLab D 
INNER JOIN persona P ON P.codigoEmpleado=D.id_empleado WHERE d.estado =1 and D.id_subgrupo='".$row['id_subgrupo']."'";
$stmt2 = sqlsrv_query($conectar,$query2,array(),array("Scrollable"=>SQLSRV_CURSOR_KEYSET));
while ($row2 = sqlsrv_fetch_array($stmt2,SQLSRV_FETCH_ASSOC)) {?>

	<tbody>
		<td><?= $row2['nomEnpleado']?></td>
		<td><a onclick="EjecutarProcesoSubGrupo(<?= $CodigoRegistro?>,<?= $row2['id_subgrupo']?>,<?= $row2['id_empleado']?>)"><i class="fa fa-times" aria-hidden="true" style="color:#C21010"></i></a></td>
	</tbody>
<?php }
?>
		

	<?php }?>
</table>
<?php 
}
elseif($tipo==2){

$query = $obj->consultar("SELECT G.NomSubGrupo,G.id_subgrupo FROM Sub_grupoLaboral G WHERE codigoRegistro=$CodRegistro");?>
<table class="table table-hover">
<thead>
	<th scope="col">Nombre del Grupo</th>
	<th scope="col"></th>
</thead>
<tbody class="Grupo-options">
<?php
$count = 0;
while ($row = sqlsrv_fetch_array($query,SQLSRV_FETCH_ASSOC)) {
	$count=$count+1;
	?>
	<tr>
		<td><?= $row['NomSubGrupo']?></td>
		<td><input type="radio"  class="form-control form-control-sm" name="Grupos" id="CodigoGrupo<?=$count;?>" value="<?= $row['id_subgrupo']?>"></input>
		</td>
	</tr>
<?php }?>
</tbody>
</table>
<?php }?>
