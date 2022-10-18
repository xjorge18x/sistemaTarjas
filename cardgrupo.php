<?php 

require_once("cont/CFunciones.php");
include_once("verificar.php");
$obj = new CFunciones;

$codigoGrupo= $_GET["grupo"];
$numcolumnas = 2;

$i = 1;

$query = "select p.codigoEmpleado,p.DNIempleado,CONCAT(p.APEPATempleado,' ',p.APEMATempleado,' ',P.NombresEmpleado)as nombre,P.NombresEmpleado,CONCAT(p.APEPATempleado,' ',p.APEMATempleado)as apellido,
g.NombreGrupo,o.NombreOcupacion,l.NombreLinea from detalleOcupacionEmpleado d
inner join persona p on(p.codigoEmpleado=d.codigoEmpleado)
inner join GrupoTrabajo g on(g.codGrupoTrabajo=d.codGrupoTrabajo)
inner join Ocupacion o on (o.codigoOcupacion=g.codigoOcupacion)
inner join linea l on (l.codigoLinea=o.codigoLinea)
where d.codGrupoTrabajo='$codigoGrupo' ";
$smtv = $obj->consultar1($query);
$total_resultados = sqlsrv_num_rows($smtv);
	
  require_once('librerias/tcpdf/tcpdf.php');
 
	
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	
	$pdf->SetTitle('TCPDF Example 027');//Titulo de PDF
  $pdf->setPrintHeader(false); // No se Imprime Cabecera
  $pdf->setPrintFooter(false); // No se Imprime pie de Pagina
  $pdf->SetMargins(10, 10, 10, false); // Se define Margenes izquierdo, alto, deracho
  $pdf->SetAutoPageBreak(true, 20);  // Se define un salto de pagina con un limite de pie de pagina
	$pdf->AddPage();

// define barcode style
$style = array(
    'position' => 'C',
    'border' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'fgcolor' => array(0,0,0),
    'bgcolor' => array(255,255,255),
    'text' => true
);
$html = '<table>';

while($row2 = sqlsrv_fetch_array($smtv,SQLSRV_FETCH_ASSOC))
{
  $barcode = $row2["DNIempleado"];
  $barcode = $pdf->serializeTCPDFtagParameters(array($barcode, 'C128', '', '', 50, 15, 0.9,$style , 'N'));

    $resto = ($i % $numcolumnas); 
    if($resto == 1)
    { 
      $html .= '<tr>';/*si es el primer elemento creamos una nueva fila*/ 
    }
  $html .= '<td><table  cellpadding="8.8" cellspacing="0" width="200px" border="1">
      <tr>
          <td width="80">Apellidos </td>
           <td width="180">:<b> '.$row2["apellido"].'</b></td>
          </tr>
          <tr>
          <td>Nombres </td>
          <td width="180">: <b>'.$row2["NombresEmpleado"].'</b></td>
          </tr>
          <tr>
          <td Colspan="2"><tcpdf method="write1DBarcode" params="'.$barcode.'" /></td>
          </tr>
          </table></td>';

  if($resto == 0)
    {
      
   $html .= '</tr>'; /*cerramos la fila*/
    }
     $i++; 

}

if($resto != 0){
    /*Si en la última fila sobran columnas, creamos celdas vacías*/
     for ($j = 0; $j < ($numcolumnas - $resto); $j++)
     {
      $html .= '<td></td>'; 
     }
      $html .= '</tr>';
  } 

	$pdf->SetFont('Helvetica','',8);
	$pdf->writeHTML($html, true, 0, true, 0);

	$pdf->lastPage();
	$pdf->output('Reporte.pdf', 'I');


?>
		 
          
        
