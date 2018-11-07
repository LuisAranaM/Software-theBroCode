<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link rel="icon" href="{{ URL::asset('img/pucp.png') }}">       
  <link href="https://fonts.googleapis.com/css?family=Catamaran" rel="stylesheet">


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

    $nombreEspecialidad=App\Entity\Especialidad::getNombreEspecialidadUsuario();
    $semestreActual=App\Entity\Semestre::getSemestre();
?>

</head>

<body class="nav-md" >
  <div class="container body" >
    <div class="main_container">

      <div class="col-md-3 left_col menu_fixed" >
        <div class="left_col scroll-view" style="border: solid 1px #D9DEE4; border-top: transparent;background-color: white">
          <div class="navbar nav_title text-center" style="border: 0; background-color: white;height: auto">
            <a href="#" class="site_title" style=""><img src="{{ URL::asset('img/logo2.png') }}" alt="logoRubriK" style="width: 70%"/></a>
          </div>
          <div class="clearfix" ></div>
          <hr id="sep-menu" style="border-color: 1px #D9DEE4; margin-top: 2px; margin-bottom: -10px">

          <!-- /menu profile quick info -->

          <br/>

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu" style="background-color: white; padding-left: 10px">
            <div class="menu_section" >
              <ul class="nav side-menu">

              <label class="sideBarText" style="padding-left: 14px" >Semestre: {{$semestreActual}}</label>

                
                <li class="pText"><a href="{{route('profesor.calificar')}}" style="color:#72777a"><i class="fa fa-bar-chart-o"></i>Calificar Alumnos</a>
                </li>
                
                @if($modoCoordinador or $modoAsistente)
                  <li class="pText"><a href="{{route('rubricas.gestion')}}" style="color:#72777a"><i class="fa fa-list-ul" ></i> Rúbricas</a>
                    
                  </li>
                  <li class="pText"><a style="color:#72777a"><i class="fa fa-edit"></i> Cursos <span class="fa fa-chevron-down"></span></a></a>
                    <ul class="nav child_menu">
                      <li class="pText"><a href="{{route('cursos.gestion')}}" style="color:#72777a">Gestionar Cursos</a></li>
                      <li class="pText"><a href="{{route('cursos.progreso')}}" style="color:#72777a">Visualizar Progreso</a></li>
                    </ul>
                  </li>
                  <!--<li class="pText"><a style="color:#72777a"><i class="fa fa-users"></i> Cargar Alumnos <span class="fa fa-chevron-down"></span></a>
                  </li>-->
                  <li class="pText"><a style="color:#72777a" href="{{route('reportes')}}"><i class="fa fa-table"></i> Reportes</a>
                  </li>
                  <!--<li class="pText"><a style="color:#72777a"><i class="fa fa-bar-chart-o"></i> Gráficos <span class="fa fa-chevron-down"></span></a>
                  </li>-->
                  <!--<li class="pText"><a style="color:#72777a" href="{{route('subir.excels')}}"><i class="fa fa-upload"></i> Subir Excels</a>
                  </li>-->
                  <li class="pText"><a style="color:#72777a" href="{{route('reuniones')}}"><i class="fa fa-book"></i> Reuniones</a>
                  </li>
                  <li class="pText"><a style="color:#72777a" href="{{route('objetivos')}}"><i class="fa fa-mortar-board"></i> Objetivos Educacionales</a>
                  </li>
                  <li class="pText"><a style="color:#72777a" href="{{route('avisos')}}"><i class="fa fa-bell"></i> Generar Avisos</a>
                  </li>
                @endif

              </ul>
            </div>         
          </div>
          <!-- /sidebar menu -->




          <!-- /menu footer buttons -->
        </div>

      </div>

      <div class="top_nav">
        <div class="nav_menu" style="background-color: white; border-color: #E6E9ED">
          <nav>
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
            <ul class="nav navbar-nav navbar-right">
              <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <img src="{{ URL::asset('img/profile.jpg') }}" alt="perfil"> <span style="font-family: segoe UI">
                  {{Auth::user()->NOMBRES .' '. Auth::user()->APELLIDO_PATERNO .' '. Auth::user()->APELLIDO_MATERNO}} - Coordinador de
                  {{$nombreEspecialidad}}
                  </span>
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <li><a href="javascript:;"> Perfil</a></li>
                  <li>
                    <a href="javascript:;">
                      <span class="badge bg-red pull-right">50%</span>
                      <span>Configuración</span>
                    </a>
                  </li>
                  <li><a href="javascript:;">Ayuda</a></li>
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
        @include('flash::message')
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
