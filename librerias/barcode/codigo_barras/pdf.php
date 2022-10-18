<?php
	require 'fpdf/fpdf.php';
	require 'conexion.php';
	include 'barcode.php';
	
	$sql = "SELECT codigo_barras FROM productos";
	$resultado = $mysqli->query($sql);
	
	$pdf = new FPDF();
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(true, 20);
	$y = $pdf->GetY();
	
	while ($row = $resultado->fetch_assoc()){
		
		$code = $row['codigo_barras'];
		
		barcode('codigos/'.$code.'.png', $code, 20, 'horizontal', 'code128', true);
		
		$pdf->Image('codigos/'.$code.'.png',10,$y,50,0,'PNG');
		
		$y = $y+15;
	}
	$pdf->Output();	
	
?>

