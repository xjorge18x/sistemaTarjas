<?php 
session_start();
include("conectar.php");
//datos capturados del formulario
$user_name=htmlspecialchars(trim($_POST['user_name']),ENT_QUOTES);
$pass=md5($_POST['password']);

//comparando datos en la bd
$sql="SELECT p.NombresEmpleado,p.foto,u.id_persona,u.id_usuario, u.login_user, u.password_2, u.cargo_perfil,u.estado,u.foto,convert(varchar(10), u.fecha_exp, 120)as expire 
FROM usuario_sistema u
INNER JOIN persona p on (u.id_persona=p.codigoEmpleado)
WHERE login_user='$user_name' and u.estado=1";
$stmt = sqlsrv_query( $conectar, $sql, array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
$row= sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC);

$hoy = date("Y-m-d");
$expire = $row['expire'];

//if username exists

if ($conectar) // prueba si la conexion es correcta
{
	if(sqlsrv_num_rows($stmt)>0)
	{
		//compare the password
		if(strcmp($row['password_2'],$pass)==0)
		{
			if ($hoy < $expire) 
			{
			
			echo "yes";
			//now set the session from here if needed
			$_SESSION['u_codigo']=$row['id_usuario']; 
			$_SESSION['u_name']=$row['login_user']; 
			$_SESSION['u_perfil']=$row['cargo_perfil'];
			$_SESSION['u_estado']=$row['estado'];
			$_SESSION['u_nombre']=$row['NombresEmpleado'];
			$_SESSION['u_foto']=$row['foto'];
			}
			else
				echo "exp"; // fecha expiro

		}
		else
			echo "no"; // contraseña incorrecto
	}
	else
	{
		echo "no"; //incorrecto  Login
	}
}
	else
{
    echo "No hay Conexion"; // no hay conexion con la base de datos
  
}



?>