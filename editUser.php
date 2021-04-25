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
$userid = User::find($_REQUEST['id']);
$message =''; $error= false;$is_form_submitted=false;
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $is_form_submitted=true;
    // Check if file was received without errors
    if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {
        $image = new Image();
        $path = $image->upload($_FILES["photo"]);
        if ($path != null) {
            $userid->setImage($path);
             $error= false;
             
        } else {
	     $error= true;
             $message = 'Failed to upload image, try again.';
        }
		
    } 
    if (isset($_POST["id"]) && $_POST["id"] != '') {
		 $userid->setId($_POST["id"]);
		
    }	
	// Check firstname
    if (isset($_POST["first_name"]) && $_POST["first_name"] != '') {
		 $userid->setFirstName($_POST["first_name"]);
		
	}
	if (isset($_POST["last_name"]) && $_POST["last_name"] != '') {
		 $userid->setLastName($_POST["last_name"]);
		
	}
	if (isset($_POST["phone"]) && $_POST["phone"] != '') {
		 $userid->setPhone($_POST["phone"]);
		
	}
	if (isset($_POST["address"]) && $_POST["address"] != '') {
		 $userid->setAddress($_POST["address"]);
		
	}
	if (isset($_POST["user_type"])) {
		$user_type  = 0;
		 $userid->setUserType($user_type);
		
	}else{
            
            $user_type  = 1;
		 $userid->setUserType($user_type);
        }
      
	if(!$error){
	   $userid->update();
           $message = 'User updated successfully.';
        }else{
            
           $message = 'Failed to update user, try again.'; 
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
    <div class="row mt-5">
        <div class="col">
            <h1>Edit user</h1>
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
                <label for="first_name" class="form-label">
                    First Name
                </label>
                <div class="input-group">
                    <input type="text" name="first_name" id="first_name" class="form-control mr-2" value="<?php echo $userid->getFirstName(); ?>">
                   <input type="hidden" name="id" id="id" class="form-control mr-2" value="<?php echo $userid->getId(); ?>">
                   
                </div>
				
            </div>
			 <div class="mb-4">
                <label for="last_name" class="form-label">
                    Last Name
                </label>
                <div class="input-group">
                    <input type="text" name="last_name" id="last_name" class="form-control mr-2" value="<?php echo $userid->getLastName(); ?>">
                   
                </div>
			
                             
            </div>
           
		<div class="mb-4">
                <label for="Address" class="form-label">
                    Address
                </label>
                <div class="input-group">
                    <input type="text" name="address" id="address" class="form-control mr-2" value="<?php echo $userid->getAddress(); ?>">
                   
                </div>
				
            </div>
				
           
			 <div class="mb-4">
                <label for="Phone" class="form-label">
                    Phone
                </label>
                <div class="input-group">
                    <input type="text" name="phone" id="phone" class="form-control mr-2" value="<?php echo $userid->getPhone(); ?>">
                   
                </div>
				
            </div>
            <div class="mb-4">
                <label for="user_type" class="form-label">
                              <input type="checkbox" name="user_type" id="user_type" value='<?php echo ($userid->getUserType() == 0) ? "checked": "";?>'  class="mr-2" <?php echo ($userid->getUserType() == 0)? "checked": "";?>> Is Owner? </label> 
                <div class="input-group">
                   
                   
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
           <?php if ($userid->getImage() != null) { ?>
                <img src="<?php echo $userid->getImage(); ?>" alt="Profile image" />
                <p>Current image</p>
            <?php } ?>
                    <input type="submit" name="submit" value="Upload" class="btn btn-primary">
            
                    <div class="alert alert-info">
                <strong>Note:</strong> Only <code>.jpg</code>, <code>.gif</code>, and <code>.png</code> formats allowed. Max file size: <code>5MB</code>.
            </div>
        </form>
    </div>
    <div class="row mt-5">
        <a href="authenticated.php">Go back home</a>
    </div>
</div>
</div>
<?php

require_once('includes/footer.php');
