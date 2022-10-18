<?php
 // la clase funciones obtendra las principales funciones del sistema
 class Cfunciones {
   // creamos ela funcion consultar que devuelve el resultado de la consulta
    function consultar($query){
    include("../../conectar.php");
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

    function consultar2($query){
    include("../../conectar.php");
    global $con;
    $con = $conectar2;
    if($con == true){
    $stmt = sqlsrv_query( $con, $query, array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
    if (!$stmt) 
    return false;
    else
    return $stmt;
    }       
    }



    function consultar1($query){
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
    include("../../conectar.php");
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

    function validarDatos($filasGrupo, $hora, $tipoAsistencia,$idTipoProceso, $horaInicio,$estadoAsistencia,$horaInicioLaboral,$idTipoSalida,  $horaFinEnd){
      
      if($filasGrupo==0){
        $sw = 4; // no se encuentra el personal en el grupo
      }
      elseif ((trim($idTipoSalida)=="") and ($idTipoProceso==1)) {
        $sw = 3; // no esta definido tipo asistencia
      }
      elseif (trim($hora)=="") {
        $sw = 5; // no esta definica la hora
      }
      elseif (($tipoAsistencia==1) and ($idTipoProceso==1)) {
        $sw=6;// Ya se registro una hora de inicio
      }
      elseif (($tipoAsistencia<>1) and ($idTipoProceso==2)) {
        $sw=7;// no hay hora de apertura // falta grupo
      }
      elseif (($horaInicio > $hora) and ($idTipoProceso==2)) {
        $sw=8;// la hora de fin es mayor que la hora de inicio
      }
      elseif ($estadoAsistencia==0) {
        $sw=9;// el personal no registro asistencia
      }
      elseif ($horaInicioLaboral > $hora) {
        $sw=10;// la Hora de asistencialaboral es inferior
      }
      elseif (($hora < $horaFinEnd) and ($idTipoProceso==1)) {
        $sw=11;// hora debe ser mayor a hora de marcacion
      }
      else{
        $sw=1;
      }
      return $sw;
    }

    function validarDatosdeGrupo($hora,$idTipoSalida,$total ,$estado,$estdonolab,$idTipoProceso,$horaInicio,$horaInicioLaboral,$codigoTipoSalida){

      if ($estado == 0) {
        $sw = 6;//el grupo no a registrado asistencia 
      }
      elseif (($estdonolab == 3) and ($idTipoProceso==1) and ($total > 3)){
        $sw = 7;// Ya se registro una hora de inicio
      }
      elseif (trim($hora) == ""){
        $sw = 3;// no esta definica la hora
      }
      elseif ((trim($idTipoSalida)=="") and ($idTipoProceso==1)){
        $sw = 4;//no esta definido tipo asistencia
      }
      elseif (($horaInicio > $hora) and ($idTipoProceso==2) ){
        $sw = 8;
      }
      elseif ($horaInicioLaboral>$hora) {
        $sw = 9;// la Hora de asistencialaboral es inferior
      }
      elseif (($estdonolab <> 3) and ($idTipoProceso==2)) {
        $sw = 10;// no hay hora de apertura
      }
      elseif (($codigoTipoSalida <> $idTipoSalida) and ($idTipoProceso==2)) {
        $sw = 11;
      }
       else{
        $sw=1;
      }
      return $sw;
    }

    function validarRecepcionMP($id_cantidad,$id_Especie,$id_tiporecep,$horaid){
      if(trim($id_cantidad)==""){
        $sw = 3;
      }
      elseif (trim($id_Especie)=="") {
        $sw = 4;
      }
      elseif (trim($id_tiporecep)=="") {
        $sw = 5;
      }
      elseif (trim($horaid)=="") {
        $sw = 6;
      }
      else{
        $sw=1;
      }
      return $sw;
    }

    function validarAgregarPersona($codigoBarra,$filas,$filas2,$hora,$tipoOperacion,$estadoAsistencia,$asifila2,$fechaSalida,$ultimaHoraSalida,$tipoturno){
      if ((trim($codigoBarra) == "") and (($tipoOperacion == 4) or ($tipoOperacion == 3))) {
        $sw = 10;//Error código de barras vacío al agregar persona
      }
      elseif($filas==0){
        $sw=5;//No existe codigo en la base personal
      }
      elseif (($filas2 == 1) and ($asifila2==1)) {
        $sw = 6 ;
      }
      elseif ((($estadoAsistencia == 1)) and (($tipoOperacion == 3) or ($tipoOperacion == 4)) ) {
        $sw = 8;
      }
      elseif ((trim($hora)=="") and ($tipoOperacion == 4)) {
        $sw = 3;
      }
      elseif (($fechaSalida>$hora) and ($tipoOperacion == 4)){//para agregar nueva persona la hora inicio debe ser mayor ala anterior
        $sw = 9;
      }
      // elseif (($hora<=$ultimaHoraSalida) and ($tipoturno==1) and ($tipoOperacion==4)){
      //   $sw = 15; despues activar validacion 31-10-2020 no permite agregar persona con una hora menor
      // }
      else{
        $sw=1;
      }
      return $sw;

    }

    function validarAsistencia($hora,$estadoNolab,$tipoturno,$fechaIngreso,$fechaSalida,$estadoasistencia,$registroAnteriorHora,$totalreg){

      if (trim($hora)=="") {
        $sw = 3;// no esta definica la hora
      }
      elseif ((($estadoNolab==1)or($estadoNolab==3)) and($tipoturno=2)){
        $sw = 5;// no ha cerrado hora no laborable
      }

      // elseif (($fechaIngreso>$hora) and($tipoturno=2) and ("00:00"<>$hora)) {
      //   $sw = 6;//valida hora incicio debe ser mayor aqui segundo para canbio turn
      // }

     // elseif (($totalreg>1) and ($tipoturno<>1) and ($registroAnteriorHora>$fechaIngreso)) {
      //  $sw = 7;
     // }
      // elseif ((($registroAnteriorHora>$fechaIngreso) or ($registroAnteriorHora==null)) and ($tipoturno<>1) ) {
      //   $sw = 7;
      // }
      else{
        $sw = 1;
      }
      return $sw;

    }

    function validarAsistenciaCB($hora,$codigoBarra,$filasEmpleado,$estadoasistencia,$tipoturno,$filas,$CodigoGru2,$codGrupo,$fechaIngreso)
    {
      if (trim($hora)=="") {
        $sw = 3;// no esta definica la hora
      }
      elseif (trim($codigoBarra=="")) {
        $sw = 10;
      }
      elseif ($filasEmpleado == 0) {
       $sw = 11;
      }
      elseif(($estadoasistencia==1) and ($tipoturno==1))
      {
        $sw = 12;
      }
      elseif(($estadoasistencia==2) and ($tipoturno==2))
      {
        $sw = 13;
      }
      elseif(($filas==0) and (($tipoturno==1) or ($tipoturno==2)))
      {
        $sw = 14;
      }
      elseif($CodigoGru2<>$codGrupo)
      {
        $sw = 16;
      }
      elseif(($hora<$fechaIngreso) and ($tipoturno==2))
      {
        $sw = 17;
      }
      else{
        $sw = 1;
      }
      return $sw;
    }
/*=============================================
VALIDA PROCESO PRECOCIDO
=============================================*/

   function ValidarProcesoPrecocido($id_cantidad)
    {
      if(trim($id_cantidad)==""){
        $sw = 3;
      }
      else {
        $sw = 1;
      }
      return $sw;
    }

/*=============================================
VALIDA GRUPO POR UND
=============================================*/

    function ValidarProcesoUND($id_cantidad)
    {
     if (trim($id_cantidad)=="") {
      $sw = 3;//no esta definida la cantidad
      }
      else{
        $sw = 1;
      }
      return $sw;
    }

/*=============================================
VALIDA GRUPO POR KG
=============================================*/

      function validarProcesosG($id_cantidad,$estdonolabG,$estdonolabP,$asistenciaG,$asistenciaP){

      // if(($estdonolabG==3) and (($estdonolabP==1) or ($estdonolabP==null))){
      //   $sw = 6;//no culmiba hora no lab
      // }
      // elseif
      // (

      //   (($estdonolabG==0) or ($estdonolabG==4)) and 
      //   ($asistenciaG==2) and
      //   (($estdonolabP==0) or ($estdonolabP==null) or ($estdonolabP==2)) and  
      //   (($asistenciaP==2) or ($estdonolabP==null))   
      // )
      // {
      //   $sw = 7;//el grupo Termino turno
      // }
      // else
      if (trim($id_cantidad)=="") {
      $sw = 4;//no esta definida la cantidad
      }
      else{
      $sw=1;
      }
      return $sw;

    }

/*=============================================
VALIDA PERSONA POR KG
=============================================*/

    function validarProcesosP($id_cantidad,$Cod_Detalle,$nolaboral,$asistencia){

      if (($asistencia == 1) and (($nolaboral == 1) or ($nolaboral == 3))){
      $sw = 9; //El Personal debe culminar la hora no laborable
      }
      elseif (($asistencia == 2) and (($nolaboral == 2) or ($nolaboral == 4) or ($nolaboral == 0))){
      $sw = 10;//El Personal cerro assitencia
      }
      elseif ($Cod_Detalle== "") {
       $sw = 8;//Revisar Codigo de Barras
      }
      elseif (trim($id_cantidad)=="") {
      $sw = 4;//no esta definida la cantidad
      }
      else{
      $sw = 1; 
      }
      return $sw;
    }

/*=============================================
VALIDA ElIMINAR REGISTRO
=============================================*/

    function EliminarAsistencia(){
      
    }


/*=============================================
VALIDA REGISTRAR HORA NO LABORAL TODO
=============================================*/

    function ValidaHoranoLaboralTodo($hora,$idTipoSalida,$idTipoProceso,$estdonolab,$total,$codigoTipoSalida,$horaInicio,$horaInicioLaboral){
      if (trim($hora)=="") {
        $sw = 3;
      }
      elseif ((trim($idTipoSalida)=="") and ($idTipoProceso==1)){
        $sw = 4;//no esta definido tipo asistencia
      }
      elseif (($estdonolab == 3) and ($idTipoProceso==1) and ($total > 3)){
        $sw = 7;// Ya se registro una hora de inicio
      }
      elseif (($codigoTipoSalida <> $idTipoSalida) and ($idTipoProceso==2)) {
        $sw = 11;
      }
      elseif (($horaInicio > $hora) and ($idTipoProceso==2) ){
        $sw = 8;
      }
      elseif ($horaInicioLaboral>$hora) {
        $sw = 9;// la Hora de asistencialaboral es inferior
      }
      else{
        $sw = 1;
      }

      return $sw;
      
    }

  /*=============================================
  VALIDA CAJA
  =============================================*/

 function ValidaCajaReg($filas,$idaccion,$EstadoCaja,$IdPalet_Generado,$idPalet,$filas3,$Capacidad,$totalCjs)
    {
      if (($filas==0) and ($idaccion==0)){
        $sw = 3; // Valida Existe Caja
      }
      elseif (($EstadoCaja==1) and ($IdPalet_Generado==$idPalet) and ($idaccion==0)) {
        $sw = 4;//Caja ya esta registrada en el palet
      }
      elseif (($EstadoCaja==1) and ($IdPalet_Generado<>$idPalet) and ($idaccion==0)) {
        $sw = 5;//traslado
      }
      elseif ((($filas==0) or ($filas==1)) and ($filas3==0) and  ($idaccion==1)) {
        $sw = 6;// no existe caja a eliminar
      }
      elseif (($EstadoCaja==3) and ($idaccion==0) ){
        $sw= 13; //caja cerrada
      }
      // elseif (($Capacidad==$totalCjs)) {
      //   $sw = 7;
      // }
      else{
        $sw = 1;
      }
      return $sw;

    }

    function ValidaRumaReg($filas,$idaccion,$filas2,$IdPalet_Generado,$idPalet,$CajasRuma,$filas4){

      if (($filas==0) and ($idaccion==4)){
        $sw = 8; // Valida Existe ruma
      }
      elseif (($idaccion==4) and ($filas2==1) and ($IdPalet_Generado<>$idPalet)) {
        $sw = 9;//traslado Ruma
      }
      elseif (($idaccion==4) and ($filas2==1) and ($IdPalet_Generado==$idPalet)) {
        $sw = 10;//Ruma ya esta registrada en el palet
        }
      elseif (($CajasRuma == 0) and ($idaccion==4)) {
        $sw = 11;//No hay cajas en la ruma
        }
        elseif (($idaccion==6) and ($filas4==0)) {
          $sw = 12;
        }

      else{
        $sw = 1;
      }
      return $sw;

    }


  /*=============================================
  VALIDA PERSONA POR KG
  =============================================*/
  function ValidaTrasPalet($idPalet,$codigoBarras,$idaccion,$Palet,$Paletdetalle){
      if (($idPalet==$codigoBarras) and ($idaccion==7)) {
       $sw = 14;
      }
      else if (($Palet==0) and ($idaccion ==7)) {
        $sw = 15 ;
      }
      else if (($Palet<>0) and ($idaccion ==7) and ($Paletdetalle ==0)) {
        $sw = 16 ;
      }
      else{
        $sw = 1 ; 
      }
      return $sw;
    }

    function ValidarDatoCheck($_CantidaKG,$_CantidadBD,$_tipo,$_MinBD){
    if (trim($_CantidaKG)=="") {
       $sw = 2 ; 
    }
      else if (($_CantidadBD<$_CantidaKG) and ($_tipo==2))
    {
    $sw = 4 ; 
    }
    elseif ($_MinBD=='1900') {
    $sw = 5 ; 
    }
    else{
        $sw = 1 ; 
      }
       return $sw;
  }

  function ValidarIngresoManualADD($filas,$dniPersonal,$filas2,$idaccion){
    if  (trim($dniPersonal)=="") {
      $sw = 4 ; 
    }
    elseif(($filas==0) and ($idaccion==1)){
      $sw = 7 ; 
    }
    elseif(($filas2==1) and ($idaccion==1)){
      $sw = 8 ; 
    }
    else {
     $sw = 1 ; 
    }
  
    return $sw;
  }

    function ValidarIngresoManual($id_cantidad){
  if (trim($id_cantidad)=="") {
       $sw = 3 ; 
    }
    else {
     $sw = 1 ; 
    }
  
    return $sw;
  }

    function ValidarIngresoManualP($dniPersonal,$id_cantidad,$filas,$Finicio,$FinFin,$asistencia,$Hora_inicio,$Hora_Fin,$tarifa,$idaccion,$FechaTurno){
    if ($filas==0) {
      $sw = 5 ; 
    }
    elseif ((trim($id_cantidad)=="") and  ($tarifa==2) and ($tarifa==3)){
         $sw = 3 ; 
    }
    elseif (trim($dniPersonal)=="") {
      $sw = 4 ; 
    }
    elseif (((trim($Hora_inicio)=="") or (trim($Hora_Fin)=="")) and ($asistencia==0)){
      $sw = 9 ; 
    }
    else if (date("Y-m-d",strtotime($FechaTurno))<>date("Y-m-d",strtotime($Hora_inicio)))
    {
    $sw = 10 ; 
    }
    // elseif($d1>$d2){
    //    $sw = 10 ; 
    // }
    // elseif 
    // (
    //   ((trim($Finicio)=="") or (trim($FinFin)=="")) AND

    //   ((trim($Hora_inicio)=="") or (trim($Hora_Fin)==""))
    // ){
    //   $sw = 6; 
    //  }
    else {
     $sw = 1 ; 
    }
  
    return $sw;
  }


    function ValidarIngresoDatoCheck($_CantidaKG,$Hora_inicio,$Hora_Fin,$idaccion,$FechaTurno){
    if($idaccion<>3) {
       $sw = 4 ; 
    }
    else if (trim($_CantidaKG)=="") {
       $sw = 2 ; 
    }
    else if ($Hora_inicio=="" or $Hora_Fin=="")
    {
    $sw = 3 ; 
    }
    else if (date("Ymd H:i:s",strtotime($Hora_inicio))>date("Ymd H:i:s",strtotime($Hora_Fin)))
    {
    $sw = 5 ; 
    }
    else if (date("Y-m-d",strtotime($FechaTurno))<>date("Y-m-d",strtotime($Hora_inicio)))
    {
    $sw = 6 ; 
    }
    else{
        $sw = 1 ; 
      }
       return $sw;
  }


    function ValidarAccionesManuales($_CantidaKG,$IdMov,$tarifa,$FechaTurno,$Hora_inicio){
    if (($IdMov==1) and ($_CantidaKG>0) and ($tarifa==2)) {
       $sw = 3 ; 
    }
    else if(($IdMov==0) and (date("Y-m-d",strtotime($FechaTurno))<>date("Y-m-d",strtotime($Hora_inicio))))
    {
    $sw = 4 ; 
    }
    else{
        $sw = 1 ; 
      }
       return $sw;
  }

  /*=============================================
  VALIDA SUBGRUPOS
  =============================================*/

  function ValidarRegistroSubGrupos($DatosCheck,$NomSubGrupo,$Tipo,$IdSubGrupo)
  {
    if ((TRIM($DatosCheck)=='') and ($Tipo==1)) {
      $sw = 3;
    }
    elseif((trim($NomSubGrupo)=='') and ($Tipo==2))
    {
       $sw = 4;
    }
    elseif(((trim($IdSubGrupo)=='') or (trim($IdSubGrupo)=='undefined')) and ($Tipo==1)){
      $sw = 5;
    }
      else{
        $sw = 1 ; 
      }
       return $sw;

  }

}




 ?>