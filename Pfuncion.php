<?php
 class Pfunciones {
 	 function consultar_P($query){
      include("conectar.php");
      global $con;
      $con = $conectar;
      if($con == true){
      $stmt = sqlsrv_query( $con, $query, array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
      if (!$stmt) 
      return false;
      else
      return $stmt;
    }       
 }

 function ejecutar_PA($query,$parametros){
  include("conectar.php");
  global $con;
  $con = $conectar;
  if($con == true){
  $stmt = sqlsrv_query($con,$query, $parametros);
  if (!$stmt) 
  return false;
  else
  return $stmt;
}       
}

function validarDatosExp($filas,$password_2,$pass_a,$pass_new,$pass_confirmar,$longi,$clave_s){
  if($filas==0){
        $sw = 3; // no se encuentra el personal en el grupo
  }
  elseif (strcmp($password_2,$pass_a)!==0) {
  $sw = 4;
  }
  elseif (strcmp($pass_new,$pass_confirmar)!==0) {
  $sw = 5;
  }
  elseif ($longi <= 5) {
  $sw = 6;
  }
  elseif (strcmp($pass_new,$clave_s)==0) {
  $sw = 7;
  }
  else
  {
    $sw=1;
  }
  return $sw;

}

}

?>