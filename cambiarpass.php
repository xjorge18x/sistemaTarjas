<?php
require_once("Pfuncion.php");
$obj = new Pfunciones;
if(isset($_POST["accion"])){
	$accion = $_POST["accion"];

	if ($accion == "canbiarpassexp") {
		
	$login = $_POST["login2"];
	$pass_actual = $_POST["pass_actual"];
	$pass_new = $_POST["pass_new"];
	$pass_confirmar = $_POST["pass_confirmar"];
	$query1 = "SELECT password_2,login_user,id_usuario,clave_s FROM usuario_sistema WHERE login_user='$login'";
	$ejecutar1 = $obj->consultar_P($query1);
	$filas = sqlsrv_num_rows($ejecutar1);
	$row1 = sqlsrv_fetch_array($ejecutar1,SQLSRV_FETCH_ASSOC);
	$pass_a=md5($pass_actual);
	$password_2=$row1['password_2'];
	$cod_usuario = $row1['id_usuario'];
	$clave_s = $row1['clave_s'];
	$longi = strlen(trim($pass_new));

	if(($obj->validarDatosExp($filas,$password_2,$pass_a,$pass_new,$pass_confirmar,$longi,$clave_s)==1))
	{
			$passNew = md5($pass_new);
			$query = "{call manUsuario(?,?,?,1)}";
			$parametros = array(
			array(&$cod_usuario,SQLSRV_PARAM_IN),
			array(&$pass_new,SQLSRV_PARAM_IN),
			array(&$passNew,SQLSRV_PARAM_IN),);
			$ejecutar = $obj->ejecutar_PA($query,$parametros);
					if($ejecutar===false)
					{
					echo "Ocurrio un error";
					die( print_r( sqlsrv_errors(), true));
					$sw = 2;
					}
					else
					{
					$sw = 1;
					}
	}
	else
	{
		$sw = $obj->validarDatosExp($filas,$password_2,$pass_a,$pass_new,$pass_confirmar,$longi,$clave_s);
	}
	?>
	<div id="sw" class="respuestaMsg"><?php echo $sw; ?></div>
	<?php
	}

	

}

?>