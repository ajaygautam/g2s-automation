@section('sidebar')
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
         <img src="{{Auth::user()->profile_pic!=''?asset('dist/images/'.Auth::user()->profile_pic):asset('dist/images/user2.jpg')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p> {{ Auth::user()->name }} </p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        
        <li {{$component=='dashboard'?'active':''}}>
            <a href="{{url('/dashboard/home')}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
          </li>     

       

        @can('all',\App\User::class)
        <li {{$component=='users'?'active':''}}>
          <a href="{{url('/dashboard/config')}}"><i class="fa fa-dashboard"></i> <span>Config</span></a>
        </li>      
        <li {{$component=='users'?'active':''}}>
          <a href="{{url('/dashboard/users')}}"><i class="fa fa-users"></i> <span>Users</span>
           <span class="pull-right-container">
              <span class="label label-primary pull-right">
                <?php
                  echo \App\User::get()->count();
                ?>
              </span>
            </span>
          </a>
        </li>      
        <li {{$component=='appointments'?'class=active':''}}>
          <a href="{{url('/dashboard/appointments')}}"><i class="fa fa-users"></i> <span>Appointments</span>
           <span class="pull-right-container">
              <span class="label label-primary pull-right">
                <?php
                  echo \App\Appointment::get()->count();
                ?>
              </span>
            </span>
          </a>
        </li>          
        <li {{$component=='customers'?'class=active':''}}>
          <a href="{{url('/dashboard/customers')}}"><i class="fa fa-users"></i> <span>Customers</span>
           <span class="pull-right-container">
              <span class="label label-primary pull-right">
                <?php
                  echo \App\Customer::get()->count();
                ?>
              </span>
            </span>
          </a>
        </li>          
        <li {{$component=='payments'?'class=active':''}}>
          <a href="{{url('/dashboard/payments')}}"><i class="fa fa-users"></i> <span>Payments</span>
           <span class="pull-right-container">
              <span class="label label-primary pull-right">
                <?php
                  echo \App\Payment::get()->count();
                ?>
              </span>
            </span>
          </a>
        </li>          
     
        <li {{$component=='resources'?'class=active':''}}>
          <a href="{{url('/dashboard/resources')}}"><i class="fa fa-users"></i> <span>Resources</span></a>
        </li>          
        
        <li {{$component=='memberships'?'class=active':''}}>
          <a href="{{url('/dashboard/memberships')}}"><i class="fa fa-users"></i> <span>Membership Plans</span>
          </a>
        </li>          
        @endcan
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  @show