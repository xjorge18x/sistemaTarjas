<nav id="sidebar">
            <div id="dismiss">
                <i class="fas fa-arrow-left"></i>
            </div>

            <div class="sidebar-header avatar">
            <img src="<?php echo trim($_SESSION['u_foto']);?>" alt=""><br><br>
            <h2><?php echo trim($_SESSION['u_nombre']);  ?></h2>
           
            </div>

            <ul class="list-unstyled components">
                <li class="active">
                     <a href="javascript:cargarArchivo('contenido','principal.php')" id="ocultarmenu"><i class="fas fa-home fa-lg"></i>&nbsp; Inicio</a>
                </li>

                <?php if(($_SESSION['u_perfil']==1) or ($_SESSION['u_perfil']==3)){?>
                <li >
                    <a href="#personalSubmenu" data-toggle="collapse" aria-expanded="false"><i class="fas fa-clipboard-list fa-lg"></i>&nbsp;&nbsp; Personal</a>
                    <ul class="collapse list-unstyled" id="personalSubmenu">
                        <li>
                            <a href="javascript:cargarArchivo('contenido','contenedor/formularios/frm_asistenciaPersonal.php')" id="ocultarmenu">Registrar Asistencia</a>
                        </li>

                      <!-- <li>
                            <a href="javascript:cargarArchivo('contenido','contenedor/formularios/frm_asistenciaPersonal2.php')" id="ocultarmenu">Registrar Asistencia II</a>
                        </li> -->
                        <li>
                            <a href="javascript:cargarArchivo('contenido','contenedor/formularios/frm_horasmuertas.php')" id="ocultarmenu">Horas no laborable</a>
                        </li>

                        <li>
                            <a href="javascript:cargarArchivo('contenido','contenedor/formularios/frm_RegistrarSubGrupos.php')" id="ocultarmenu">Registro SubGrupos</a>
                        </li>


<!--                         <li>
                            <a href="javascript:cargarArchivo('contenido','contenedor/formularios/frm_listadoPersonal.php')" id="ocultarmenu">Listado de Personal</a>
                        </li> -->
                    </ul>
                </li>
                <?php }?>
                 <?php if(($_SESSION['u_perfil']==1) or ($_SESSION['u_perfil']==3)){?>
                <li>
                     <a href="#ProcesoSubmenu" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sliders-h fa-lg"></i>&nbsp; Procesos Online</a>
                    <ul class="collapse list-unstyled" id="ProcesoSubmenu">
                         <li>
                            <a href="javascript:cargarArchivo('contenido','contenedor/formularios/Frm_RegistroDistribucionSesion.php')" id="ocultarmenu">Registro Distribución</a>
                        </li>
<!--                         <li>
                            <a href="javascript:cargarArchivo('contenido','contenedor/formularios/frm_RegistroProcesosUnidades.php')" id="ocultarmenu">Registrar Envío Mesas </a>
                        </li> -->

                         <li>
                            <a href="javascript:cargarArchivo('contenido','contenedor/formularios/frm_RegistroProcesosKG-G.php')" id="ocultarmenu">Registro de Proceso Grupal(KG) </a>
                        </li>
                        <li>
                            <a href="javascript:cargarArchivo('contenido','contenedor/formularios/frm_RegistroProcesosKG-P.php')" id="ocultarmenu">Registro de Proceso Persona(KG)</a>
                        </li>
                        <li>
                            <a href="javascript:cargarArchivo('contenido','contenedor/formularios/frm_RegistroAvancePrecocido.php')" id="ocultarmenu">Registro Proceso Precocido</a>
                        </li>
                    </ul>
                </li>
                  <li>
                     <a href="#ProcesoSubmenuManual" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sliders-h fa-lg"></i>&nbsp; Procesos Manuales</a>
                      <ul class="collapse list-unstyled" id="ProcesoSubmenuManual">
                        <li>
                            <a href="javascript:cargarArchivo('contenido','contenedor/formularios/frm_regstroManualKG_G.php')" id="ocultarmenu">Registro Grupal - Manual(KG)</a>
                        </li>
                        <li>
                            <a href="javascript:cargarArchivo('contenido','contenedor/formularios/frm_regstroManualKG_P.php')" id="ocultarmenu">Registro Persona - Manual(KG)</a>
                        </li>
                    </ul>
                 </li>
                 <?php }?>

                <?php if(($_SESSION['u_perfil']==1) or ($_SESSION['u_perfil']==2)){?>
<!--                 <li>
                     <a href="#RecepcionSubmenu" data-toggle="collapse" aria-expanded="false"><i class="fas fa-truck fa-lg"></i> Recepción</a>
                    <ul class="collapse list-unstyled" id="RecepcionSubmenu">
                        <li>
                            <a href="javascript:cargarArchivo('contenido','contenedor/formularios/frm_manRecepcion.php')" id="ocultarmenu">Registrar Recepción M.P</a>
                        </li>
                    </ul>
                </li> -->
                <?php }?>
                 <?php if(($_SESSION['u_perfil']==4) OR ($_SESSION['u_perfil']==5) or ($_SESSION['u_perfil']==6)){?>
                 <li>
                     <a href="#EtiquetadoSubmenu" data-toggle="collapse" aria-expanded="false"><i class="fas fa-pallet-alt fa-lg"></i> Etiquetado</a>
                    <ul class="collapse list-unstyled" id="EtiquetadoSubmenu">
                        <li>
                            <a href="javascript:cargarArchivo('contenido','contenedor/etiquetado/frm_GenerarPalet.php')" id="ocultarmenu">Etiqutado Palet</a>
                        </li>
                         <li>
                            <a href="javascript:cargarArchivo('contenido','contenedor/etiquetado/frm_GestinarPalet.php')" id="ocultarmenu">Gestion Palet</a>
                        </li>
                        <li>
                                <a href="javascript:cargarArchivo('contenido','contenedor/etiquetado/frm_GestinarCajas.php')" id="ocultarmenu">Gestion Cajas</a>
                        </li>

                        <li>
                                <a href="javascript:cargarArchivo('contenido','contenedor/etiquetado/frm_TrazabilidadCaja.php')" id="ocultarmenu">Trazabilidad Caja</a>
                        </li>  
                    </ul>
                </li>
                <?php }?>
            </ul>

            <ul class="list-unstyled CTAs">
                <li> 
                    <button type="button" class="myButton" onclick="salir();">Cerrar Sesión</button>
                </li>
            </ul>
</nav>