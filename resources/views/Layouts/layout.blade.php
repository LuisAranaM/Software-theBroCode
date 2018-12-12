<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link rel="icon" href="{{ URL::asset('img/logo.png') }}">       
  <link href="https://fonts.googleapis.com/css?family=Catamaran" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

  <title>@yield('pageTitle') - RubriK</title>

  <!-- CSS-->
  <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ URL::asset('css/custom/custom.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ URL::asset('css/custom/broCode.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ URL::asset('css/custom/custom.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ URL::asset('css/custom/customRubr.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ URL::asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

  <link href="{{ URL::asset('css/pnotify.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('css/pnotify.buttons.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('css/pnotify.nonblock.css') }}" rel="stylesheet">

  <link href="{{ URL::asset('css/daterangepicker.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('css/formValidation.min.css') }}" rel="stylesheet" type="text/css" > 

  <!--<link href="{{ URL::asset('css/dropzone.css') }}" rel="stylesheet" type="text/css">-->
  <!--JS-->
  <!--<script type="text/javascript"  src="{{ URL::asset('js/custom.min.js') }}"></script>-->
  <script type="text/javascript"  src="{{ URL::asset('js/jquery-1.12.4.min.js') }}"></script>
  <script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>       
  <script type="text/javascript" src="{{ URL::asset('js/impl.js') }}"></script>
  <script type="text/javascript" src="{{ URL::asset('js/typeahead.bundle.js') }}"></script>
  <script type="text/javascript" src="{{ URL::asset('js/k/custom.js') }}"></script>
  <!--<script type="text/javascript" src="{{ URL::asset('canvas/canvasjs.min.js') }}"></script>-->

  <script type="text/javascript" src="{{ URL::asset('js/pnotify.js') }}"></script>
  <script type="text/javascript" src="{{ URL::asset('js/pnotify.buttons.js') }}"></script>
  <script type="text/javascript" src="{{ URL::asset('js/pnotify.nonblock.js') }}"></script>  

  <script type="text/javascript" src="{{ URL::asset('js/moment.min.js') }}"></script>
  <script type="text/javascript" src="{{ URL::asset('js/daterangepicker.js') }}"></script>  

  <!--AGREGUE PARA TREE CON CHECKBOX-->
  <script  type="text/javascript" src="{{ URL::asset('js/checktree.js') }}"></script>
  <script src="{{ URL::asset('js/bootstrap-treeview.js') }}"></script>

  <!--FORM VALIDATION-->
  <script type="text/javascript" src="{{ URL::asset('js/formvalidation/formValidation.popular.min.js') }}"></script>
  <script type="text/javascript" src="{{ URL::asset('js/formvalidation/language/es_CL.js') }}"></script>
  <script type="text/javascript" src="{{ URL::asset('js/formvalidation/framework/bootstrap.min.js') }}"></script>

  <!--DRAG AND DROP-->
  <!--<script type="text/javascript" src="{{ URL::asset('js/dropzone.js') }}"></script>-->

  <script type="text/javascript" src="{{ URL::asset('js/especialidades/configuracion.js') }}"></script>


  @yield('js-libs')

  <script>
    var APP_URL = "<?php echo config('app.url'); ?>";
    var APP_PUBLIC_URL = "<?php echo config('app.url'); ?>";
  </script>


  <?php
    // Evaluar si este blade lo esta viendo el ejecutivo o un gerente

  $modoAdministrador = Auth::user()->ID_ROL==App\Entity\Usuario::ROL_ADMINISTRADOR?true:false;
  $modoCoordinador=Auth::user()->ID_ROL==App\Entity\Usuario::ROL_COORDINADOR?true:false;
  $modoAsistente=Auth::user()->ID_ROL==App\Entity\Usuario::ROL_ASISTENTE?true:false;
  $modoProfesor=Auth::user()->ID_ROL==App\Entity\Usuario::ROL_PROFESOR?true:false;

  $modoSoloLectura=in_array(Auth::user()->ID_ROL,App\Entity\Usuario::getModoLectura());

  $nombreEspecialidad=App\Entity\Especialidad::getNombreEspecialidadUsuario();
  $especialidades=App\Entity\Especialidad::getEspecialidades();

  $nombreRol=App\Entity\Rol::getRolUsuario();
  if(!$modoAdministrador)
    $nombreRol.=' de ' .$nombreEspecialidad;
    //dd($nombreRol);
  $especialidadActual=App\Entity\Especialidad::getEspecialidadUsuario();
  $semestreActual=App\Entity\Semestre::getSemestre();

  ?>

</head>

<body class="nav-md" >
  <div class="container body" >
    <div class="main_container">

      <div class="col-md-3 left_col menu_fixed" >
        <div class="left_col scroll-view" style="border: solid 1px #D9DEE4; border-top: transparent;background-color: white">
          <a href="#" class="site_title text-center" style=""><img id="imagenRubrik" src="{{ URL::asset('img/logo2.png') }}" alt="logoRubriK" style="width: 65%"/></a>
          <!--<div class="navbar nav_title text-center" style="border: 0; background-color: white;height: auto">-->
            <!--<a href="#" class="site_title" style=""><img src="{{ URL::asset('img/logo2.png') }}" alt="logoRubriK" style="width: 70%"/></a>-->
            <!--</div>-->
            <div class="clearfix" style="padding-bottom: 1px"></div>
            <hr id="sep-menu" style="border-color: 1px #D9DEE4; margin-top: 2px; margin-bottom: -10px">

            <!-- /menu profile quick info -->

            <br/>

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu" style="background-color: white; padding-left: 10px">
              <div class="menu_section" >
                <ul class="nav side-menu" id="menuLateral">
                  @if($modoAdministrador)
                  <center>
                  <label>Ver como: 
                    <select class="form-control" id="verComoEsp">
                      <option value=""></option>
                      @foreach($especialidades as $especialidad)
                      <option value="{{$especialidad->ID_ESPECIALIDAD}}" especialidad="{{$especialidad->NOMBRE}}"" {{($especialidad->ID_ESPECIALIDAD == $especialidadActual)? 'selected="selected"':''}}>{{$especialidad->NOMBRE}}</option>
                      @endforeach
                    </select>
                  </label></center>
                  @endif

                  <li class="pText" ><a href="#" style="color:#72777a;font-weight: bold;cursor: default;color:black" id="semestreSistema"><i class="fa fa-calendar"></i>Semestre: {{$semestreActual}}</a>
                  </li>
                  @if($modoAdministrador)
                <!--<li class="pText"><a href="{{route('administrador.usuario')}}" style="color:#72777a"><i class="fa fa-users"></i>Gestionar Usuarios</a>
                </li>-->

                <li id="formatos" class="pText"><a style="color:#72777a"><i class="fa fa-users"></i>Administrador<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none;">
                    <li class="pText"><a href="{{route('administrador.usuario')}}" style="color:#72777a">
                    Gestionar Usuarios</a></li>
                    <li class="pText"><a href="{{route('administrador.usuario.activacion')}}" style="color:#72777a">
                    Activar Usuarios</a></li>
                    <li class="pText"><a href="{{route('administrador.semestre')}}" style="color:#72777a">Gestionar Semestres</a>
                    </li>
                    <li class="pText"><a href="{{route('administrador.especialidad')}}" style="color:#72777a">Gestionar Especialidad</a>
                    </li>
                  </ul>
                </li>

                @endif
                @if($modoCoordinador or $modoAsistente or $modoProfesor or $modoAdministrador)
                <li id="calificar" class="pText"><a href="{{route('profesor.calificar')}}" style="color:#72777a"><i class="fa fa-bar-chart-o"></i>Calificar Alumnos</a>
                </li>
                @endif
                @if($modoCoordinador or $modoAsistente or $modoAdministrador)
                <li id="objetivos" class="pText"><a style="color:#72777a"><i class="fa fa-mortar-board"></i> Objetivos <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li class="pText"><a href="{{route('objetivosGestion')}}" style="color:#72777a">Gestionar Objetivos</a></li>
                    <li class="pText"><a href="{{route('objetivos')}}" style="color:#72777a">Mapear Objetivos</a></li>
                  </ul>
                </li>
                <li id="rubricas" class="pText"><a href="{{route('rubricas.gestion')}}" style="color:#72777a"><i class="fa fa-list-ul" ></i> Rúbricas</a>

                </li>
                <li id="cursos" class="pText"><a href="{{route('cursos.gestion')}}" style="color:#72777a"><i class="fa fa-edit"></i> Gestionar Cursos 
                </a>
                 
                  </li>
               
                  <li id="reportes" class="pText"><a style="color:#72777a" href="{{route('reportes')}}"><i class="fa fa-table"></i> Reportes y Gráficos</a>
                  </li>
                  <li id="reuniones" class="pText"><a style="color:#72777a" href="{{route('reuniones')}}"><i class="fa fa-book"></i> Reuniones</a>
                  </li>
                  <li id="avisos" class="pText"><a style="color:#72777a" href="{{route('avisos')}}"><i class="fa fa-bell"></i> Generar Avisos</a>
                  </li>                  
                  @endif
                  <!--<li id="formatos" class="pText"><a style="color:#72777a"><i class="fa fa-download"></i>Descargar Formatos <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu" style="display: none;">
                      <li class="pText"><a href="{{URL::asset('formatos/RubriK_Formato_Carga_Cursos.xlsx')}}" download="RubriK_Formato_Carga_Cursos.xlsx" style="color:#72777a">
                      Carga de Cursos</a></li>
                      <li class="pText"><a href="{{URL::asset('formatos/RubriK_Formato_Carga_Alumnos.xlsx')}}" download="RubriK_Formato_Carga_Alumnos.xlsx" style="color:#72777a">
                      Carga de Alumnos</a></li>
                    </ul>
                  </li>-->

                </ul>
              </div>         
            </div>
            <!-- /sidebar menu -->




            <!-- /menu footer buttons -->
          </div>

        </div>

        <div class="top_nav">
          <div id="barraSuperior" class="nav_menu" style="background-color: white; border-color: #E6E9ED">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              <ul class="nav navbar-nav navbar-right">

                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <span class="userName">
                      @if(Auth::user()->PERFIL==NULL)
                      <img src="{{ URL::asset('img/profile.jpg') }}" alt="perfil"> 
                      @else
                      <img src="{{Auth::user()->PERFIL}}" alt="perfil"> 
                      @endif
                      <span style="font-family: segoe UI">
                        {{Auth::user()->NOMBRES .' '. Auth::user()->APELLIDO_PATERNO .' '. Auth::user()->APELLIDO_MATERNO}} - 
                      </span>
                    </span>
                    <span style="font-family: segoe UI">
                      {{$nombreRol}}
                    </span>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <!--<li><a href="javascript:;"> Perfil</a></li>-->
                    <li><a href="{{route('pass.update')}}"><i class="fa fa-key pull-right"></i>  Cambiar Contraseña</a></li>
                    <li><a href="{{route('logout')}}"><i class="fa fa-sign-out pull-right"></i> Cerrar sesión</a></li>
                  </ul>
                </li>


              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->


        <div class="right_col" role="main">
          @yield('content')         
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <!--<footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
      -->

    </div>
  </div>

</body>
@yield('js-scripts')

</html>
