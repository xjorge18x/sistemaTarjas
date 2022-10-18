<?php
	
	require 'conexion.php';
	
	$sql = "SELECT codigo_barras FROM productos";
	$resultado = $mysqli->query($sql);
	
	while ($row = $resultado->fetch_assoc()){
		
	?>
	
	<img src="barcode.php?text=<?php echo $row['codigo_barras']; ?>&size=50&orientation=horizontal&codetype=Code39&print=true&sizefactor=1" />
	
	<br/>
	
<?php } ?>
