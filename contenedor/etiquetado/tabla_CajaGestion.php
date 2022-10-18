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

$query ="SELECT TOP 1 C.IdCaja_Project AS IDCAJA,P.CodigoOOFF AS OOFF,P.CodigoLote AS LOTE,
(SELECT NombreEspecie FROM tipoEspecie WHERE codigoEspecie=P.CodigoEspecie) AS ESPECIE,
(CASE WHEN P.Turno = 1 THEN 'DÍA' ELSE 'NOCHE' END) AS TURNO,
(SELECT NombreProducto FROM MaestroProducto WHERE CodigoProducto=P.CodigoProducto) AS NOMBREPRODUCTO,
CONCAT(P.Peso,' ',P.UnidaMedidad) AS PESO,C.Estado
FROM Caja_Project C
LEFT JOIN Project_Prod P ON C.IdProject_Prod=P.IdProject_Pro
WHERE C.IdCaja_Project='$codigoBarras'
";
$smtv=$obj->consultar($query);
$rows = sqlsrv_fetch_array($smtv,SQLSRV_FETCH_ASSOC);
$numeroFilas = sqlsrv_num_rows($smtv);

$quey2 ="SELECT D.IdPalet_Generado as PALET,p.TipoProceso+1 as TIPO,P.EstadoA as ESTADOPALET FROM DetalleProject D 
INNER JOIN Pallet_Generado P ON P.IdPallet_Generado= D.IdPalet_Generado
where D.IdCaja_Project='$codigoBarras' AND D.Estado=1";
$smtv2=$obj->consultar($quey2);
$rows2 = sqlsrv_fetch_array($smtv2,SQLSRV_FETCH_ASSOC);
$numeroFilas2 = sqlsrv_num_rows($smtv2);

?>

<div class="row">
<div class="col-12 col-lg-12 col-sm-12"> 
<?php if ($numeroFilas<>0){ ?>
	<table class="table table-bordered">
		<tr>
			<th>Caja</th>
			<td><?php echo $rows['IDCAJA'];?> </th>
		</tr>
		<tr>
			<th>Lote</th>
			<td><?php echo $rows['LOTE'];?> </th>
		</tr>
		<tr>
			<th>OOFF</th>
			<td><?php echo $rows['OOFF'];?> </th>
		</tr>
		<tr>
			<th>Especie</th>
			<td><?php echo $rows['ESPECIE'];?> </th>
		</tr>
		<tr>
			<th>Producto</th>
			<td><?php echo $rows['NOMBREPRODUCTO'];?> </th>
		</tr>
		<tr>
			<th>Peso</th>
			<td><?php echo $rows['PESO'];?> </th>
		</tr>
		
		<tr>
			<th>Turno</th>
			<td><?php echo $rows['TURNO'];?> </th>
		</tr>
		<tr>
			<th><?php if ($rows2['TIPO']==0){echo "Estado";} elseif ($rows2['TIPO']==1){echo "Palet";}else{echo "Ruma";} ?></th>
			<td><?php if ($rows['Estado']==1){
				
				?>
				 <a href="javascript:cargarArchivo('contenido','contenedor/etiquetado/frm_GestinarPalet.php?codigoBarras=<?php echo $rows2['PALET'];?>')"><span class='badge badge-danger'>Asignada a <?php echo $rows2['PALET'];?></span></a>
				<?php
					
				}
				else
				{
				echo "<span class='badge badge-success'>Disponible</span>";
				}?> </td>
		</tr>
	</table>
<?php }
else
{
	echo " <div class='alert alert-warning' id='Exito' role='alert' style='display:none;text-align: center;' >No Existe Caja</div>";
}

?>
</div>
</div>