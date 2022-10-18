<?php

if (isset($_REQUEST['Codigo'])) {
	$CodigoRegistro = $_REQUEST['Codigo'];
	$CodGrupo = $_REQUEST['Grupo'];
	$CodOcupacion = $_REQUEST['Ocupacion'];
}else{
	$CodigoRegistro=$CodigoRegistro;
}
?>
<div class="modal-header headermodal">
			<h6 class="modal-title">Registrar SubGrupo<span class="NumCheck"></span></h6>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="
			padding-top: 10px;right: 10px;top: 5px;">
			<span aria-hidden="true" style="font-size: 2.5rem;">&times;</span>
</div>

<div class="modal-body bodymodal" >

		  <form action="" method="POST" id="R_Palets" class="form"  name="R_Palets">
		    
<!-- 		    <div class="form-group row" style="padding-bottom: 5px">
		        <div class="col-12 col-md-6" style="padding-bottom: 5px">
		        <input type="text" class="form-control" id="NomSubGrupo" name="NomSubGrupo" placeholder="Nombre SubGrupo" autocomplete="off">
		    	</div>
		        <div class="col-auto">
		    	<input type="submit" class="form-control btn btn-secondary" id="BtnEnviar" value="Enviar">
		    	<input type="submit" class="form-control btn btn-secondary" id="BtnEnviar" value="Enviar">
		      </div>
		   </div>
 -->


  <div class="input-group is-invalid" style="padding-bottom: 5px">
    <div class="custom-file">
      <input type="text" class="form-control" id="NomSubGrupo" name="NomSubGrupo" placeholder="Nombre SubGrupo" autocomplete="off" required>
    </div>
    <div class="input-group-append">
       <button class="btn btn-outline-secondary" type="button"><i class="fa fa-plus-circle" aria-hidden="true" onclick="RegistrarSubGrupo(2); return false;"></i></button>
    </div>
  </div>

  <input type="submit" class="form-control btn btn-secondary" id="BtnEnviar" value="Enviar" onclick="RegistrarSubGrupo(1); return false;">

		  </form>

<div id="DivSubGrupos">
<?php
	$CodRegistro=$CodigoRegistro;
	$tipo=2;
	include_once("../formularios/tabla_ListaSubGrupo.php");
?>
</div>		  

</div>
<script type="text/javascript">
	$('.Grupo-options tr').click(function() {
 $(this).children('td').children('input').prop('checked', true);
  
  $('.Grupo-options tr').removeClass('selected');
  $(this).toggleClass('selected');

});
</script>