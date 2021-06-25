


<?php 
$solidffd = '2';
?>
<?php if($solidffd == 2)
{?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Ellatech</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="css/mystyles.css">
  





    <!-- Custom styles -->
    <link href="css/sree-code.css" rel="stylesheet" />
    <link href="css/sree-main.css" rel="stylesheet" />
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">
            <img src="images/SREE-Logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
            BigBet Sports Betting
          </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav ">
      <li class="nav-item active">
      <router-link to="/dashboard" class="nav-link"> Home </router-link>
      </li>

      <?php $useridtousess = Auth::user()->id;
/// geting the users role
$myuserroledefined = DB::table('users')->where('id', $useridtousess)->value('mmaderole'); ?>
   
        
    <!-- Drop Down Start -->

    <?php 
/// selecting the allowed menues
$allowedmain  = DB::table('rolenaccmains')->where('roleto', $myuserroledefined)->get();
foreach ($allowedmain as $rowall)
{
     $component = ($rowall->component);

     $mainheaderssd = DB::table('mainmenucomponents')->where('id', $component)->get();

     foreach ($mainheaderssd as $myheaders)
     {
         $hname = ($myheaders->mainmenuname);
     
         $mainmenuno = ($myheaders->id);
         $classtoicon = ($myheaders->iconclass);
     /////

    //$shid = ($rowsubmenuesselection->shid);
    //$routelinkdd = ($rowsubmenuesselection->linkrouterre);


?>



      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">  <?php echo $hname; ?></a>

        <div class="dropdown-menu" aria-labelledby="dropdown01">

        <?php 
   //// woorking on the sub menues
   /// getting the logged in user role
   $lirole = Auth::user()->type;
   $allowedsubmenu  = DB::table('rolenaccsumbmens')->where('mainheader', $mainmenuno)->where('roleto', $myuserroledefined)->get();
foreach ($allowedsubmenu as $rowallsub)
{
     $componentvvvvbbb = ($rowallsub->component);
 $submenuesselection = DB::table('submheaders')->where('id',  $componentvvvvbbb)->orderBy('dorder', 'Asc')->get();
 foreach ($submenuesselection as $rowsubmenuesselection)
 {
     $submname = ($rowsubmenuesselection->submenuname);
 
     $shid = ($rowsubmenuesselection->shid);
     $routelinkdd = ($rowsubmenuesselection->linkrouterre);
 
  
  ?>

          <router-link to="<?php echo $routelinkdd; ?>" class="dropdown-item">
          <p><?php echo $submname; ?></p>
          </router-link>
          <?php } //// ?>
          <?php } //// ?>
        </div>
      </li>
      <?php } 

     }
     ?>

    </ul>

  
<div class="col-md-3 ml-auto sree-notifications"> 
    <div class="row"> 
    <div class=" col-sm-2 notification-area">
<!--Messages-->

<div class="messages-menu notification-area">
        <!-- Menu toggle button -->
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fas fa-envelope-open-text notif-icons"></i>
               <sup> <span class="badge badge-light notif-badge">4</span> </sup> 
        </a>

        <ul class="dropdown-menu sree-show">
          <li class="notif-header">You have 4 messages</li>
          <li>
            <!-- inner menu: contains the messages -->
            <ul class="menu sree-menu">
              <li><!-- start message -->
                <a href="#">

                <div class="row">  

                  <div class=" col-2 container-fluid">
                    <!-- User Image -->
                    <img src="images/SREE-Logo.png" class="img-circle" alt="User Image">
                  </div>
                  <!-- Message title and timestamp -->

                <div class=" col container sent-detials">

                    <div class="row"> 
                  <h4 class="sree-msg-title ">
                    Support Team
                 </h4>

                    <small class="ml-auto time-icon"> <i class="far fa-clock"></i> 5 mins ago </small>
                </div>

                    <!-- The message -->
                    <div class=" row notif-msg"> <p> Check out the New SREE Update Version 2.0 </p> </div>
                
                
                
                </div>

                     

                </div>  






               
                  
                </a>
              </li>
              <!-- end message -->
            </ul>

            <ul class="menu sree-menu">
                    <li><!-- start message -->
                      <a href="#">
      
                      <div class="row">  
      
                        <div class=" col-2 container-fluid">
                          <!-- User Image -->
                          <img src="images/SREE-Logo.png" class="img-circle" alt="User Image">
                        </div>
                        <!-- Message title and timestamp -->
      
                      <div class=" col container sent-detials">
      
                          <div class="row"> 
                        <h4 class="sree-msg-title ">
                          Chef Jevgeni
                       </h4>
      
                          <small class="ml-auto time-icon"> <i class="far fa-clock"></i> 5 mins ago </small>
                      </div>
      
                          <!-- The message -->
                          <div class=" row notif-msg"> <p> I'm excited about the performance of the new ... </p> </div>
                      
                      
                      
                      </div>
      
                           
      
                      </div>  
      
      
      
      
      
      
                     
                        
                      </a>
                    </li>
                    <!-- end message -->
                  </ul><ul class="menu sree-menu">
                        <li><!-- start message -->
                          <a href="#">
          
                          <div class="row">  
          
                            <div class=" col-2 container-fluid">
                              <!-- User Image -->
                              <img src="images/SREE-Logo.png" class="img-circle" alt="User Image">
                            </div>
                            <!-- Message title and timestamp -->
          
                          <div class=" col container sent-detials">
          
                              <div class="row"> 
                            <h4 class="sree-msg-title ">
                              Store Manager
                           </h4>
          
                              <small class="ml-auto time-icon"> <i class="far fa-clock"></i> 5 mins ago </small>
                          </div>
          
                              <!-- The message -->
                              <div class=" row notif-msg"> <p> Check out the New SREE Update Version 2.0 </p> </div>
                          
                          
                          
                          </div>
          
                               
          
                          </div>  
          
          
          
          
          
          
                         
                            
                          </a>
                        </li>
                        <!-- end message -->
                      </ul><ul class="menu sree-menu">
                            <li><!-- start message -->
                              <a href="#">
              
                              <div class="row">  
              
                                <div class=" col-2 container-fluid">
                                  <!-- User Image -->
                                  <img src="images/SREE-Logo.png" class="img-circle" alt="User Image">
                                </div>
                                <!-- Message title and timestamp -->
              
                              <div class=" col container sent-detials">
              
                                  <div class="row"> 
                                <h4 class="sree-msg-title ">
                                  F&amp;B Manager
                               </h4>
              
                                  <small class="ml-auto time-icon"> <i class="far fa-clock"></i> 5 mins ago </small>
                              </div>
              
                                  <!-- The message -->
                                  <div class=" row notif-msg"> <p> Check out the New SREE Update Version 2.0 </p> </div>
                              
                              
                              
                              </div>
              
                                   
              
                              </div>  
              
              
              
              
              
              
                             
                                
                              </a>
                            </li>
                            <!-- end message -->
                          </ul>
            <!-- /.menu -->
          </li>
          <li class="notif-footer"><a href="#">See All Messages</a></li>
        </ul>
    </div>





    </div>

    <div class="col-sm-2"> 
        <div class="messages-menu notification-area">
                <!-- Menu toggle button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fas notif-icons fa-bell"></i>
                       <sup> <span class="badge badge-light notif-badge">6</span> </sup> 
                </a>
        
                <ul class="dropdown-menu sree-show">
                  <li class="notif-header">You have 6 Notifications</li>
                  <li>
        
                    <ul class="menu sree-menu">
                            <li class="one-not"><!-- start message -->
                            <a href="#">
                                <div class="row">    
                                    <div class="col-1 not-icon"> <i class="fas notif-icons-kitchen fa-bell"></i>  </div>

                                    <div class="col-10 not-descrip"> Pdt: 2340 - Heinkens Ketchup is reaching reorder value soon!. <small class="not-time">Just now</small> <br> <small class="not-seen-by"> <span class="seen-by"> Seen by: </span> Agnes, Grace, Solomon  </small> </div>
                                   
                                </div>
                            </a>
                            </li>

                            <li class="one-not"><!-- start message -->
                                <a href="#">
                                    <div class="row">    
                                        <div class="col-1 not-icon"> <i class="fas notif-icons-kitchen finance-not fas fa-chart-bar"> </i>  </div>
    
                                        <div class="col-10 not-descrip"> Invoice 4544 due for payment in 3 days. <small class="not-time"> 5 min ago</small> <br> <small class="not-seen-by"> <span class="seen-by"> Seen by: </span> Agnes, Grace, Solomon  </small> </div>

                         
    
                                    </div>
                                </a>
                                </li>

                                <li class="one-not"><!-- start message -->
                                    <a href="#">
                                        <div class="row">    
                                            <div class="col-1 not-icon"> <i class="fas notif-icons-kitchen delivery-not fa-shipping-fast"></i>  </div>
        
                                            <div class="col-10 not-descrip"> New online Kitchen Pilao order!.<small class="not-time"> 1 hour ago</small> <br> <small class="not-seen-by"><span class="seen-by"> Seen by: </span> Agnes, Grace, Solomon  </small> </div>

        
                                        </div>
                                    </a>
                                    </li>

                                    <li class="one-not"><!-- start message -->
                                        <a href="#">
                                            <div class="row">    
                                                <div class="col-1 not-icon"> <i class="fas notif-icons-kitchen fa-bell"></i>  </div>
            
                                                <div class="col-10 not-descrip"> Pdt: 2340 - Heinkens Ketchup is reaching reorder value soon!. <small class="not-time"> Just now </small> <br> <small class="not-seen-by"> <span class="seen-by"> Seen by: </span>  Agnes, Grace, Solomon  </small> </div>
                                         
            
                                            </div>
                                        </a>
                                        </li>
            
                                        <li class="one-not"><!-- start message -->
                                            <a href="#">
                                                <div class="row">    
                                                    <div class="col-1 not-icon"> <i class="fas notif-icons-kitchen finance-not fas fa-chart-bar"> </i>  </div>
                
                                                    <div class="col-10 not-descrip"> Invoice 4544 due for payment in 3 days. <small class="not-time"> 30 sec ago </small> <br> <small class="not-seen-by"> <span class="seen-by"> Seen by: </span> Agnes, Grace, Solomon  </small> </div>
                                                   
                
                                                </div>
                                            </a>
                                            </li>
            
                                            <li class="one-not"><!-- start message -->
                                                <a href="#">
                                                    <div class="row">    
                                                        <div class="col-1 not-icon"> <i class="fas notif-icons-kitchen delivery-not fa-shipping-fast"></i>  </div>
                    
                                                        <div class="col-10 not-descrip"> New online Kitchen Pilao order!. <small class="not-time"> Just now</small> <br> <small class="not-seen-by"> <span class="seen-by"> Seen by: </span> Agnes, Grace, Solomon  </small> </div>
                                                        
                    
                                                    </div>
                                                </a>
                                                </li>


                               
                  <li class="notif-footer"><a href="#">See All Notifications</a></li>
                </ul>
            </li></ul></div>
    
    
    </div>

    <div class="col-sm-2"> 
                
                <div class="messages-menu notification-area">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fas notif-icons fa-user"></i> 
                               
                        </a>
                
                        <ul class="dropdown-menu light-border sree-show">
                          
                          <li>
                            <!-- inner menu: contains the messages -->
                            <ul class="menu sree-menu">
                              <li><!-- start message -->
                                <a href="#">
                
                                <div class="row">  
                
                                  <div class=" user-img-bg container col-11">
                                    <!-- User Image -->
                                    <img class="user-img" src="images/user.jpg" alt="User Image">
                                  </div>

                                  </div>
                                  <!-- Message title and timestamp -->
                                  <div class="row">
                                <div class=" col container sent-detials">
                
                                    <div class="row"> 
                                 
                                    <p class="user-name"> Lubwama Peterson  <br> <span class="user-title"> Restaurant Owner </span> </p>
                                 
                
                                   
                                </div>
                
                                 
                                
                                
                                
                                </div>
                
                                     
                
                                </div>  
                
                
                
                
                
                
                               
                                  
                                </a>
                              </li>
                              <!-- end message -->
                            </ul>
                
                       
                            <!-- /.menu -->
                          </li>
                          <li class="user-footer">
                              <div class="row">
                                <div class="pull-left mx-auto">
                                  <a href="#" class="btn user-btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right mx-auto">
                                  <a href="Login.html" class="btn user-btn btn-default btn-flat">Sign out</a>
                                </div>

                            </div>
                              </li>
                        </ul>
                    
                
                
                
                
                
                    </div>
    
    </div>



    <div class="col-sm-2"> <a href="#">  <i class="fas notif-icons fa-cogs"></i> </a> </div>
    <div class="col-sm-2"> <a href="#">  <i class="far notif-icons fa-comments"></i> </a> </div>

</div>
</div>
  </div>

  
</nav>


  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">

    
      <router-view></router-view>
      <vue-progress-bar></vue-progress-bar>   



      
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
 
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>



<script src="/js/app.js"></script>
</body>
</html>
<?php } ?>






<?php if($solidffd == 1)
{
  ?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Ellatech</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  
  <link rel="stylesheet" href="css/mystyles.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
 
  <!-- Ionicons -->

  <!-- daterange picker -->

 </head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">



  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light"><b>EllaPos</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }} </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        
               <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Home
                
              </p>
            </router-link>
          </li>
        
        
          <?php $useridtousess = Auth::user()->id;
/// geting the users role
$myuserroledefined = DB::table('users')->where('id', $useridtousess)->value('mmaderole'); ?>
   
        
    <!-- Drop Down Start -->

    <?php 
/// selecting the allowed menues
$allowedmain  = DB::table('rolenaccmains')->where('roleto', $myuserroledefined)->get();
foreach ($allowedmain as $rowall)
{
     $component = ($rowall->component);

     $mainheaderssd = DB::table('mainmenucomponents')->where('id', $component)->get();

     foreach ($mainheaderssd as $myheaders)
     {
         $hname = ($myheaders->mainmenuname);
     
         $mainmenuno = ($myheaders->id);
         $classtoicon = ($myheaders->iconclass);
     /////

    //$shid = ($rowsubmenuesselection->shid);
    //$routelinkdd = ($rowsubmenuesselection->linkrouterre);


?>

    <li class="nav-item has-treeview menu">
            
            
            
            <a href="#" class="nav-link">
              <i class="<?php echo $classtoicon; ?>"></i>
              <p>
              <?php echo $hname; ?>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>




            <ul class="nav nav-treeview">


            <?php 
   //// woorking on the sub menues
   /// getting the logged in user role
   $lirole = Auth::user()->type;
   $allowedsubmenu  = DB::table('rolenaccsumbmens')->where('mainheader', $mainmenuno)->where('roleto', $myuserroledefined)->get();
foreach ($allowedsubmenu as $rowallsub)
{
     $componentvvvvbbb = ($rowallsub->component);
 $submenuesselection = DB::table('submheaders')->where('id',  $componentvvvvbbb)->orderBy('dorder', 'Asc')->get();
 foreach ($submenuesselection as $rowsubmenuesselection)
 {
     $submname = ($rowsubmenuesselection->submenuname);
 
     $shid = ($rowsubmenuesselection->shid);
     $routelinkdd = ($rowsubmenuesselection->linkrouterre);
 
  
  ?>
           
             
             <!-- sub menu -->
              <li class="nav-item">
              <router-link to="<?php echo $routelinkdd; ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p><?php echo $submname; ?></p>
                </router-link>
              </li>
              <?php } //// ?>
  <?php } //// Closing the start of access submenu loop ?>



<!-- submenu -->

            </ul>
          </li>
 <?php }//// closing the loop foe menu name
    
    }/// closing the main menu access loop
    ?>







<!-- Drop Down End -->





          <li class="nav-item">
           
           <a class="nav-link" href="{{ route('logout') }}"
           onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
<i class="nav-icon fa fa-power-off red"></i>
<p>

            {{ __('Logout') }}
          </p>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>


         </li>



        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      <router-view></router-view>
      <vue-progress-bar></vue-progress-bar>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2019 </strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->



<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>


<script src="/js/app.js"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });
    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>
<!--
  <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Select2 (Bootstrap4 Theme)</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
         
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Minimal</label>
                  <select class="form-control select2bs4" style="width: 100%;">
                    <option selected="selected">Alabama</option>
                    <option>Alaska</option>
                    <option>California</option>
                    <option>Delaware</option>
                    <option>Tennessee</option>
                    <option>Texas</option>
                    <option>Washington</option>
                  </select>
                </div>
              
              </div>
             
            </div>
           
          </div>
  
        </div> --->
</body>

</html>
<?php } ?>