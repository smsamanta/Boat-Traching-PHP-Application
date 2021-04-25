<?php

// Start the session; always invoked before anything else!
session_start();

require_once('class/lib/Auth.php');
require_once('class/lib/CSRF.php');

// Check if the user is already logged in and redirect to the authenticated page if so
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']) {
    header('Location: authenticated.php');
}
$errorMessage = '';
// Check POST request is valid with CSRF token
// and if we have username and password in the POST request
if (
    isset($_POST['username'])
    && isset($_POST['password'])
    
    && CSRF::verifyToken(true)
) {
    // Error message we will use to show invalid login
    $errorMessage = null;
$result=Auth::register($_POST,$_FILES);
    // Authenticate the user given credentials
    if ($result >0) {
        // Redirect to the authenticated page now that we have authenticated
        header('Location: login.php');
    } else {
        // Set the error message to display upon failure
        $errorMessage = 'Failed to register, please try';
    }
}

ob_start(); // Initiate output buffer - prevents early write of content so we can set CSRF cookie

require_once('includes/header.php');

?>

<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="index.php"><b>Register</b></a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register </p>
     
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
           <?php echo CSRF::getInputField(); ?>
        	     <div class="mb-4">
                <label for="username" class="form-label">
                    Username
                </label>
                <div class="input-group">
                    <input type="text" name="username" id="username" class="form-control mr-2">
                   
                </div>
				
            </div>
			<div class="mb-4">
                <label for="password" class="form-label">
                    Password
                </label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control mr-2">
                   
                </div>
				
            </div>
		    <div class="mb-4">
                <label for="first_name" class="form-label">
                    First Name
                </label>
                <div class="input-group">
                    <input type="text" name="first_name" id="first_name" class="form-control mr-2">
                   
                </div>
				
            </div>
			 <div class="mb-4">
                <label for="last_name" class="form-label">
                    Last Name
                </label>
                <div class="input-group">
                    <input type="text" name="last_name" id="last_name" class="form-control mr-2">
                   
                </div>
				
            </div>
			 <div class="mb-4">
                <label for="Address" class="form-label">
                    Address
                </label>
                <div class="input-group">
                    <input type="text" name="address" id="address" class="form-control mr-2">
                   
                </div>
				
            </div>
			<div class="mb-4">
                <label for="user_type" class="form-label">
                    
                              <input type="checkbox" name="user_type" id="user_type" value="checked"  class="mr-2" > Is Owner? </label> 
                <div class="input-group">
                   
                   
                </div>
				
            </div>
			 <div class="mb-4">
                <label for="Phone" class="form-label">
                    Phone
                </label>
                <div class="input-group">
                    <input type="text" name="phone" id="phone" class="form-control mr-2">
                   
                </div>
				
            </div>
            <div class="mb-4">
                <label for="photo" class="form-label">
                    Select an image and upload it!
                </label>
                <div class="input-group">
                    <input type="file" name="photo" id="photo" class="form-control mr-2">
                    
                </div>
				
            
			
					
            </div>
             <div class="alert alert-info">
                <strong>Note:</strong> Only <code>.jpg</code>, <code>.gif</code>, and <code>.png</code> formats allowed. Max file size: <code>5MB</code>.
            </div>
        <div class="row">
          
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

     

      <a href="login.php" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->
<?php

require_once('includes/footer.php');

ob_end_flush(); // Flush the output from the buffer
