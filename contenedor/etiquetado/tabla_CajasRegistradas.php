
<?php
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
$obj = new Cfunciones;

if (isset($_POST["idPalet"])) 
{
	$idPalet = $_POST["idPalet"];
}
else
{	
	$idPalet = $idPalet;
}

$query="Select ISNULL(IdCaja_Project, 0) as caja,ISNULL(IdRuma, 0) as ruma,CONVERT (char(5), FechaIngreso, 108) as HoraReg from DetalleProject
where IdPalet_Generado='$idPalet' and estado=1";
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
			<th scope="col" style="text-align: center;">Item</th>
			<th scope="col" style="text-align: center;">Tipo</th>
			</tr>
			</thead>
			<?php
			$count = 0;
			while($row2 = sqlsrv_fetch_array($smtv,SQLSRV_FETCH_ASSOC)) 
			{ $count=$count+1;?>
			<tbody>
			<tr>
			<td><?php echo $count; ?></td>
			<td style="text-align: center;"><?php 
			if(($row2["caja"]<>'0'))
			{
				echo $row2["caja"];

			}
			else
			{
				echo $row2["ruma"];
			}
			 ?></td>
			<td style="text-align: center;">
				<?php 
			if(($row2["caja"]<>'0'))
			{
				echo "Caja";

			}
			else
			{
				echo "Ruma";
			}
			 ?>
			</td>
			</tbody>
			<?php }?>

		</table>


	</div>
</div>


</div>
</div>

