           
           <nav class="navbar fixed-top navbar-toggleable-md navbar-expand-lg scrolling-navbar double-nav bg-custom">
            <div class="container-fluid">
                <div class="mr-auto hamburger" id="sidebarCollapse" >
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                </div>

            <a class="navbar-brand hidden-md-down logo" href="javascript:cargarArchivo('contenido','principal.php')"> <img src="img/Logo-blanco.png" width="40" height="40" alt="">COINREFRI SRL</a>

                <ul class="nav navbar-nav nav-flex-icons ml-auto">
                    <li class="nav-item">
                        <div class="hs-user toggle" data-reveal=".user-info">
                        <img src="<?php echo trim($_SESSION['u_foto']);?>">
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="more-trigger toggle" data-reveal=".user-penal"> <i class="far fa-ellipsis-v fa-lg"></i></div>
                    </li>
                </ul>

            <section class="box-model">
                 <ul class="user-penal">
                    <!--  <li> <a href="#1"><i class="fal fa-envelope"></i> Mensajes <span class="label label-success">1</span></a> </li> -->
                    <li> <a href="#1" onclick="javascript:cargarArchivo('contenido','contenedor/formularios/frm_mantenimientoUsuario.php')"><i class="fal fa-user-tie"></i> Mis Datos</a> </li>

                    <li> <a onclick="salir();" href="#"> <i class="fad fa-sign-in"></i> Salir  </a> </li>
                 </ul>
            </section>



            </div>
            </nav>