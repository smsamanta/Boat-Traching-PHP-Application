<?php

session_start();

require_once('class/lib/Exception.php');
require_once('class/lib/Image.php');
require_once('class/User.php');

// If we're not logged in, go to the login page
if (empty($_SESSION['isLoggedIn'])) {
    header('Location: login.php');
}

// We know we're authenticated so get the user by the id stored in the session.
$user = User::find($_SESSION['userId']);
$errorMessage ='';

$users = User::findAllByUser($_SESSION['userId']);

require_once('includes/header.php');

?>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
 <?php  require_once('includes/navbar.php'); ?>
  
  <!-- /.navbar -->
  
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> View All Users</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
          <div class="row">
              
               <div class="col-lg-12">
                   <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Listing</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Address</th>
                      <th>Phone</th>
                      <th>User Type</th>
                      <th >Image</th>
                      <th >Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php foreach($users as $i=>$u) { ?>
                    <tr>
                      <td><?php echo  $i+1; ?></td>
                      <td><?php echo  $u->first_name." ".$u->last_name; ?></td>
                      <td><?php echo  $u->address; ?></td>
                      <td><?php echo  $u->phone; ?></td>
                      <td><?php 
                                 echo  ($u->user_type == 0)?"Owner" : "Regular"; 
                                //echo  $u->user_type; 
                      
                          ?></td>
                      <td><img height="70px" src="uploads/<?php echo $u->image; ?>"></td>
                      <td>
                          <a href="editUser.php?id=<?php echo $u->id; ?>">Edit</a>|
                          <a href="deleteUser.php?id=<?php echo $u->id; ?>">Delete</a>
                      </td>
                    </tr>
                      <?php } ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

                  
                </div><!-- /.col -->
              
          </div><!-- /.row -->
      </div><!-- /.container -->
    </div><!-- /.content -->
 </div><!-- /.content-wrapper -->

</div><!-- /.wrapper -->
<?php

require_once('includes/footer.php');
