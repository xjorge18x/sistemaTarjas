 <?php
require_once("Pfuncion.php");
include_once("verificar.php");
$obj = new Pfunciones;
if(isset($_POST["accion"])){

	$accion = $_POST["accion"];
	if($accion=="canbiarpass")
	{
$cod_usuario = $_POST["cod_usuario"];
$pass_actual = $_POST["pass_actual"];
$pass_new = $_POST["pass_new"];
$pass_confirmar = $_POST["pass_confirmar"];
$query1 = "SELECT password_2,id_usuario FROM usuario_sistema WHERE id_usuario='".$cod_usuario."'";
$ejecutar1 = $obj->consultar_P($query1);
$row1 = sqlsrv_fetch_array($ejecutar1,SQLSRV_FETCH_ASSOC);
$pass_a=md5($pass_actual);

if(strcmp($row1['password_2'],$pass_a)==0)
{
	if(strcmp($pass_new,$pass_confirmar)==0){
		$longi = strlen(trim($pass_new));
		if($longi >= 5){
			$passNew = md5($pass_new);

			$query = "{call manUsuario(?,?,?)}";

			$parametros = array(
			array(&$cod_usuario,SQLSRV_PARAM_IN),
			array(&$pass_new,SQLSRV_PARAM_IN),
			array(&$passNew,SQLSRV_PARAM_IN),);
			$ejecutar = $obj->ejecutar_PA($query,$parametros);

			if($ejecutar == false){
				echo "<b>Ocurrio un error :</b> <br>";
				die( print_r( sqlsrv_errors(), true));
				$sw = 2; // error
			}
			else{
				$sw = 1; // "ok cambio";
			}
		}
		else{
			$sw = 3 ; //echo "debe ser minimo 5 caracteres";
		}
		
	}
	else{
		$sw = 4 ; //echo "pass no ok_2 no igual";
	}
}
else{
	$sw = 5 ; // echo "clave no ok";
}
?>
<div id="sw" class="respuestaMsg"><?php echo $sw; ?></div>
<?php
	}
	elseif ($accion=="canbiarpassexp") 
	{
		echo "string";
	}

}
?>