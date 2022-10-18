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


$query="SELECT distinct c.TipoProceso as proceso
,a.IdPalet_Generado AS PALET,c.Capacidad_Max AS CAPACIDAD,CONVERT(CHAR(10),c.Fecha ,105)AS FECHACRE,c.Estado AS ESTADO
,dbo.DameEtiqueta(a.IdPalet_Generado)as etiqueta,
dbo.damenrocajas($codigoBarras) as totalcajs,
c.EstadoA AS ESTADOA
FROM Pallet_Generado c 
INNER join DetalleProject a on c.IdPallet_Generado=a.IdPalet_Generado
WHERE c.IdPallet_Generado='$codigoBarras'
";
$smtv=$obj->consultar($query);
$rows = sqlsrv_fetch_array($smtv,SQLSRV_FETCH_ASSOC);
$numeroFilas = sqlsrv_num_rows($smtv);

$querydetalle = "{call DetallePaletV1 (?)}";

$parametros = array(
        array(&$codigoBarras,SQLSRV_PARAM_IN));

$ejecutar_ControlP1= $obj->ejecutar_PA($querydetalle,$parametros);
?>

<div class="row">
<div class="col-12 col-lg-12 col-sm-12"> 

<?php if ($numeroFilas<>0){ ?>
	<table class="table table-bordered">


		<tr>
				 <th colspan="3" style='text-align: center;'><div class="contenedor">Acción</div></th> 
			</tr>

			<tr>
				<td colspan="3">
				
				<div class="container">
				  <div class="row">
				    <div class="col" style='text-align: center;'>
				     <a onclick="writeToSelectedPrinter('<?php echo $rows["etiqueta"]; ?>')">

					<i class="fas fa-print fa-2x" style="color:#43658b"></i></a>
				    </div>

				    <div class="col" style='text-align: center;'>

				    <a 
				    <?php if($rows['ESTADOA']==0){ ?> 
				    onclick="cambiar_estilosV1('contenedor/etiquetado/frm_agregarCajasPalet.php?idPalet=<?php echo $rows["PALET"]; ?>&frm=2&pagina=1&TipoProc=<?php echo $rows["proceso"]; ?>')" data-toggle="modal" data-target="#myModal"<?php  }?> >
					<i class="fas fa-plus-circle fa-2x" 
					style="color:<?php if($rows['ESTADOA']==1){ echo "#E4EEF7"; } 
					 else{echo " #af2d2d?"; }?>"></i></a>
				    </div>

				  </div>
				</div>

				</td>
			</tr>
	
			<tr>
			<th><?php if($rows["proceso"]==0){echo "Palet";}ELSE{ ECHO "Ruma";}?></th>
			<td colspan="2"><?php echo $codpalet = $rows['PALET'];?></th>
			</tr>

			<tr>
			<th>Capacidad</th>
			<td colspan="2"><?php echo $codpalet = $rows['CAPACIDAD'];?></th>
			</tr>

			<tr>
			<th>F. Creación</th>
			<td colspan="2"><?php echo $codpalet = $rows['FECHACRE'];?></th>
			</tr>

			<tr>
			<th >Estado</th>
			<td colspan="2">
				<?php
			
				if ($rows['ESTADOA']==1){
				
				echo "<span class='badge badge-danger'>Cerrado</span>";
					
				}
				else
				{
				echo "<span class='badge badge-success'>Abierto</span>";
				}
				?>
			</th>
			</tr>

			<tr>
			<th>N° Cajas</th>
			<td colspan="2" ><?php echo $codpalet = $rows['totalcajs'];?></th>
			</tr>

			<tr>
				 <th colspan="3" style='text-align: center;'><div class="contenedor">Detalle</div></th> 
			</tr>
			<tr>
				<td><div class="contenedor">Codigo</div></td>
				<td><div class="contenedor">Lote</div></td>
				<td><div class="contenedor">Total</div></td>
			</tr>
			<?php 
				if( $ejecutar_ControlP1 === false )
				    {        
				        echo "Ocurrio un error.\n";
				        die( print_r( sqlsrv_errors(), true));
				    }
				else
				    {

				     while($row2 = sqlsrv_fetch_array($ejecutar_ControlP1,SQLSRV_FETCH_ASSOC)) 

	       					{?>
							<tr>
								<td>
								<div class="div2"><a> <?php  echo $row2["Codpro"]; ?>
									<span> <?php  echo $row2["NomPro"]; ?> </span>
								</div>
								</td>
								<td><?php echo $row2['lote']?></td>
								<td><?php echo $row2['total']?></td>

							</tr>
							 <?php }
				    }
							?>

	</table>
<?php }
else
{
	echo "<div class='alert alert-warning' style='text-align: center;' role='alert'>
 Verifcar no hay datos del palet!</div>";
}

?>
</div>
</div>
