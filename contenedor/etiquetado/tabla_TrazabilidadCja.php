<?php
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
$obj = new Cfunciones;
if (isset($_POST["codigoBarras"])) 
{
	$codigoBarras = $_POST["codigoBarras"];	
}
else
{	
	$codigoBarras=$codigoBarras;
}

$query ="select CONVERT(CHAR(10),p.FechaProject ,105)AS FECHACRE,p.CodigoLote,p.Peso,d.Estado from Project_Prod p
inner join Caja_Project d on d.IdProject_Prod=p.IdProject_Pro
where d.IdCaja_Project='$codigoBarras'
";
$smtv=$obj->consultar($query);
$rows = sqlsrv_fetch_array($smtv,SQLSRV_FETCH_ASSOC);
$numeroFilas = sqlsrv_num_rows($smtv);


$query2 ="select CONVERT( VARCHAR, d.FechaIngreso, 105 )AS FECHACRE,ISNULL( CONVERT( VARCHAR, d.FechaSalida, 105 ) , 'SIN MOV.' ) as Fechamod,(CASE WHEN p.TipoProceso = 0 THEN CONCAT('PALET',' - ',P.IdPallet_Generado) ELSE CONCAT('RUMA',' - ',P.IdPallet_Generado) END) AS PALET,
(CASE d.Estado WHEN '0' THEN 'ELIMINADO' WHEN '1' THEN 'ASIGNADO' WHEN '2' THEN 'TRASLADO' ELSE 'NO DEFINIDO' END)AS ESTADO
from Pallet_Generado p
inner join DetalleProject d on d.IdPalet_Generado=p.IdPallet_Generado
where d.IdCaja_Project='$codigoBarras' ";
$smtv2=$obj->consultar($query2);
$numeroFilas2 = sqlsrv_num_rows($smtv2);


?>

<div class="row">
<div class="col-12 col-lg-12 col-sm-12 "> 
<?php if ($numeroFilas<>0){ ?>
<div class="table-responsive">
	<table class="table table-bordered">
		<tr >
			<th colspan="2" >Lote</th>
			<td colspan="2"><?php echo $rows['CodigoLote'];?> </th>
		</tr>
		<tr>
			<th colspan="2">Peso</th>
			<td colspan="2"><?php echo $rows['Peso'];?> </th>
		</tr>
		<tr>
			<th colspan="2">Fecha Creación</th>
			<td colspan="2"> <?php echo $rows['FECHACRE'];?></th>
		</tr>
		
		<tr>
			<th colspan="2">Estado</th>
			<td colspan="2"><?php if ($rows['Estado']==1){
				
				echo "<span class='badge badge-danger'>OFF</span>";
					
				}
				else
				{
				echo "<span class='badge badge-success'>ON</span>";
				}?> </td>
		</tr>
		<tr>
			<th colspan="4">Detalle</th>
		</tr>
		<?php if($numeroFilas2<>0){?>
		<tr>
			<th>F.REGISTRO</th>
			<th>F.MODIFICA</th>
			<th >UBICACIÓN</th>
			<th>ESTADO</th>
		</tr>
	
			<?php
			while($row2 = sqlsrv_fetch_array($smtv2,SQLSRV_FETCH_ASSOC)) 
			{?>
		<tr>
			<td><?php echo $row2['FECHACRE']?></td>

			<td><?php echo $row2['Fechamod']?></td>

			<td><?php echo $row2['PALET']?></td>

			<td><?php echo $row2['ESTADO']?></td>
		</tr>



	<?php   }}else { echo "<tr>
			<td colspan='4' style='text-align: center;'>Sin Movimiento</td></tr>";}?>
		
	</table>
</td>
<?php }
else
{
	echo " <div class='alert alert-warning' id='Exito' role='alert' style='display:none;text-align: center;' >No Existe Caja</div>";
}

?>
</div>
</div>