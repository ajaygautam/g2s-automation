<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
   <title>{{ config('app.name', 'Laravel') }} | {{$page_title}}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}} ">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css')}} ">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css')}} ">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ asset('bower_components/jvectormap/jquery-jvectormap.css')}} ">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css')}} ">
  <link rel="stylesheet" href="{{ asset('dist/css/custom.css')}} ">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css')}} ">
  <link rel="icon" title="favicon" href="{{ asset('dist/images/favicon.ico')}} ">

  @stack('styles')


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesnt work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="{{ url('/dashboard') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"> 
      <!-- Golf Lounge     -->
       <img src="{{asset('dist/images/gl18logowhite.png')}}" style="height:30px">
     
    </span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"> 
        <!-- Golf Lounge 18 -->
        <img src="{{asset('dist/images/gl18logowhite.png')}}" style="height:45px">
      </span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{Auth::user()->profile_pic!=''?asset('dist/images/'.Auth::user()->profile_pic):asset('dist/images/user2.jpg')}}" width="32px" class="img-circle" alt="User Image">
              <span class="hidden-xs"> {{ Auth::user()->name }} </span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{Auth::user()->profile_pic!=''?asset('dist/images/'.Auth::user()->profile_pic):asset('dist/images/user2.jpg')}}" width="160px" class="img-circle" alt="User Image">
                
                <p>
                {{ Auth::user()->name }} 
                <small><a style="color:rgba(255,255,255,0.8);text-decoration: underline" href="/dashboard/profile/upload_pic">Change Picture</a></small>
                  <small>Last Login - {{format_date(Auth::user()->last_login,3)}}</small>
                  <small>Last Logout - {{format_date(Auth::user()->last_logout,3)}}</small>
                </p>
              </li>
         
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                   <a href="/dashboard/change_password" class="btn btn-warning btn-flat">Change Password</a> 
                </div>
                <div class="pull-right">
                <a href="{{ route('logout') }}" class="btn btn-primary btn-flat"
                    onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                    Sign Out
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>


                  
                </div>
              </li>
            </ul>
          </li>
        
        </ul>
      </div>

    </nav>
  </header>

  @include('adminlte.layouts.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{$page_title}}
        {!! isset($sub_title)&&$sub_title!=''?'<small>'.$sub_title.'</small>':'' !!}
      </h1>

      @php if(isset($breadcrumbs)){
                create_breadcrumbs($breadcrumbs);
      }
      @endphp
    </section>

    <!-- Main content -->
    <section class="content">

      @if ($errors->any())
          <div class="alert">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif

      @if (Session::has('success_message'))
          <div class="alert alert-success">
              {{Session::get('success_message')}}
          </div>
      @endif
      @if (Session::has('error_message'))
          <div class="alert alert-danger">
              {{Session::get('error_message')}}
          </div>
      @endif

    @yield('content')

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0    </div>
    <strong>Copyright &copy; 2018 <a href="{{url('/')}}">Company name</a>.</strong> All rights
    reserved.
  </footer>

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}} "></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}} "></script>
<!-- FastClick -->
<script src="{{ asset('bower_components/fastclick/lib/fastclick.js')}} "></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js')}} "></script>
<!-- Sparkline -->
<script src="{{ asset('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}} "></script>
<!-- jvectormap  -->
<script src="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}} "></script>
<script src="{{ asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}} "></script>
<!-- SlimScroll -->
<script src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}} "></script>
<!-- ChartJS -->
<script src="{{ asset('bower_components/Chart.js/Chart.js')}} "></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard2.js')}} "></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js')}} "></script>


@stack('scripts')

</body>
</html>
