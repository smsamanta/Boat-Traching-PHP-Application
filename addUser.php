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
$message =''; $error= false;$is_form_submitted=false;

$usera = new User();
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$is_form_submitted=true;
    // Check if file was received without errors
    if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {
        $image = new Image();
        $path = $image->upload($_FILES["photo"]);
        if ($path != null) {
            $usera->setImage($path);
             $error= false;
             
        } else {
	     $error= true;
             $message = 'Failed to upload image, try again.';
        }
		
    } 
	
	// Check firstname
        if (isset($_POST["first_name"]) && $_POST["first_name"] != '') {
		 $usera->setFirstName($_POST["first_name"]);
		
	}
	if (isset($_POST["last_name"]) && $_POST["last_name"] != '') {
		 $usera->setLastName($_POST["last_name"]);
		
	}
	if (isset($_POST["username"]) && $_POST["username"] != '') {
		 $usera->setUsername($_POST["username"]);
		
	}
	if (isset($_POST["password"]) && $_POST["password"] != '') {
		 $usera->setPassword($_POST["password"]);
		
	}
	if (isset($_POST["phone"]) && $_POST["phone"] != '') {
		 $usera->setPhone($_POST["phone"]);
		
	}
	if (isset($_POST["address"]) && $_POST["address"] != '') {
		 $usera->setAddress($_POST["address"]);
		
	}
	if (isset($_POST["user_type"]) && $_POST["user_type"] != '') {
		 $user_type  = 0;
		 $usera->setUserType($user_type);
		
	}else{
            
            $user_type  = 1;
		 $usera->setUserType($user_type);
        }
	if(!$error){
	   $usera->create();
           $message = 'User created successfully.';
        }else{
            
           $message = 'Failed to create user, try again.'; 
        }
}

require_once('includes/header.php');

?>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
 <?php  require_once('includes/navbar.php'); ?>
  
  <!-- /.navbar -->
<div class="container">
     <div class="row mt-5 right">
        <a href="home.php">Go back home</a>
    </div>
    <div class="row mt-5">
        <div class="col">
            <h1>ADD User</h1>
            <?php 
           if ($is_form_submitted){
            if ($error) { ?>
            <div class="alert alert-danger">
                <?php echo $message; ?>
            </div>
            <?php }else{?>
             <div class="alert alert-success">
                <?php echo $message; ?>
            </div>
           <?php } }?>
        </div>
    </div>
    
    <div class="row mt-5">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
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
            <div class="mb-4">
                <input type="submit" name="submit" value="Upload" class="btn btn-primary">
				
            </div>
           
        </form>
    </div>
   
</div>
</div>
<?php

require_once('includes/footer.php');
