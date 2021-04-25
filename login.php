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

    // Authenticate the user given credentials
    if (Auth::login($_POST['username'], $_POST['password'])) {
        // Redirect to the authenticated page now that we have authenticated
        header('Location: home.php');
    } else {
        // Set the error message to display upon failure
        $errorMessage = 'Failed to login, please try';
    }
}

ob_start(); // Initiate output buffer - prevents early write of content so we can set CSRF cookie

require_once('includes/header.php');

?>

<body  class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1"><b>Marina</b>Login</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start seeing your  data</p>

      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	    <?php echo CSRF::getInputField(); ?>
        <div class="input-group mb-3">
          <input type="username" name="username" id="username" class="form-control" required placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" id="password" class="form-control" required placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

     <p class="mb-0">
        <a href="register.php" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
<?php

require_once('includes/footer.php');

ob_end_flush(); // Flush the output from the buffer
