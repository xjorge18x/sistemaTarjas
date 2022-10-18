<?php

if (isset($_REQUEST['Codigo'])) {
	$CodigoRegistro = $_REQUEST['Codigo'];
	$CodGrupo = $_REQUEST['Grupo'];
	$CodOcupacion = $_REQUEST['Ocupacion'];
}else{
	$CodigoRegistro=$CodigoRegistro;
}
?>
<div class="modal-header headermodal" style="padding-top: 10px;padding-bottom: 10px;">
	<h6 class="modal-title">Registros SubGrupos<span class="NumCheck"></span></h6>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="
	padding-top: 10px;right: 10px;top: 5px;" onclick="javascript:cargarArchivo('divResultadoRegistrosTabSubGrupos','contenedor/formularios/tabla_SubGrupos.php?dato=<?= $CodGrupo?>&dato2=<?= $CodOcupacion?>')">
	<span aria-hidden="true" style="font-size: 2.5rem;">&times;</span>
</div>

<div class="modal-body bodymodal" >
<div id="DivResultadoSubGrupo">
<?php
	$CodRegistro=$CodigoRegistro;
	$tipo=1;
	include_once("../formularios/tabla_ListaSubGrupo.php");
?>
</div>
</div>