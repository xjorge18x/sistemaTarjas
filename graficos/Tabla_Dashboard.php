<?php

require_once("../cont/CFunciones.php");
include("../conectar.php");
include_once("../verificar.php");
$obj = new Cfunciones;

if(isset($_POST["accion"]))
{

	$accion = $_POST["accion"];

	if ($accion=='Dash') {?>


<table class="table">
  <thead>
    <tr>
      <th colspan="2" scope="col" style="text-align: center;">DashBoard</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Cajas Generadas</th>
      <td>2000</td>
    </tr>
    <tr>
      <th scope="row">Palet Generados</th>
      <td>100</td>
    </tr>
    <tr>
      <th scope="row">Rumas Generadas</th>
      <td>100</td>
    </tr>
     <tr>
      <th scope="row">Cajas Eliminadas</th>
      <td>10</td>
    </tr>
    <tr>
      <th scope="row">Palet Eliminadas</th>
      <td>10</td>
    </tr>
     <tr>
      <th scope="row">Traslados Cajas</th>
      <td>10</td>
    </tr>
  </tbody>
</table>










	<?php }
}


?>