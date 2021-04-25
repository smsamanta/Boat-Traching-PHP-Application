<?php

session_start();

require_once('class/lib/Exception.php');
require_once('class/lib/Image.php');
require_once('class/User.php');
require_once('class/Boat.php');
// If we're not logged in, go to the login page
if (empty($_SESSION['isLoggedIn'])) {
    header('Location: login.php');
}

// We know we're authenticated so get the user by the id stored in the session.
$user = User::find($_SESSION['userId']);
$owners = User::getAllOwners();


$boatid =Boat::find($_REQUEST['id']);
$message =''; $error= false;$is_form_submitted=false;
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $is_form_submitted=true;
    // Check if file was received without errors
    if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {
        $image = new Image();
        $path = $image->upload($_FILES["photo"]);
        if ($path != null) {
            $boatid->setImage($path);
             $error= false;
             
        } else {
	     $error= true;
             $message = 'Failed to upload image, try again.';
        }
		
    } 
    // Check firstname
        if (isset($_POST["name"]) && $_POST["name"] != '') {
		 $boatid->setName($_POST["name"]);
		
	}
	if (isset($_POST["reg_num"]) && $_POST["reg_num"] != '') {
            
		 $boatid->setRegNum($_POST["reg_num"]);
		
	}
	if (isset($_POST["length"]) && $_POST["length"] != '') {
		 $boatid->setLength($_POST["length"]);
		
	}
	if (isset($_POST["owner"]) && $_POST["owner"] != '') {
		 $boatid->setOwnerId($_POST["owner"]);
		 
	}
	
	if(!$error){
	   $boatid->update();
           $message = 'Boat updated successfully.';
        }else{
            
           $message = 'Failed to update boat, try again.'; 
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
        <a href="home.php">Go back home</a>
    </div>

    <div class="row mt-5">
         <form action="<?php echo $_SERVER['PHP_SELF'].'?id='.$boatid->getId(); ?>" method="post" enctype="multipart/form-data">
		     <div class="mb-4">
                <label for="name" class="form-label">
                    Name
                </label>
                <div class="input-group">
                    <input type="text" name="name" id="name" class="form-control mr-2" value="<?php echo $boatid->getName(); ?>">
                    <input type="hidden" name="id" id="id" class="form-control mr-2" value="<?php echo $boatid->getId(); ?>">

                </div>
				
            </div>
			<div class="mb-4">
                <label for="reg_num" class="form-label">
                    Registration number
                </label>
                <div class="input-group">
                    <input type="text" name="reg_num" id="reg_num" class="form-control mr-2" value="<?php echo $boatid->getRegNum(); ?>">
                   
                </div> 
				
            </div>
		     <div class="mb-4">
                <label for="length" class="form-label">
Length                </label>
                <div class="input-group">
                    <input type="text" name="length" id="length" class="form-control mr-2" value="<?php echo $boatid->getLength(); ?>">
                   
                </div>
				
            </div>
	    <div class="mb-4">
                <label for="owner" class="form-label">
Owner                </label>
                <div class="input-group">
                    <select name="owner" id="owner" class="form-control mr-2">
                        <?php foreach($owners as $owner) { 
                            
                           // echo "<option value='".$owner->id."' ".($boatid->getOwnerId() == $owner->id)? 'selected': ''.">".$owner->first_name." ".$owner->last_name."</option>";
                            echo "<option value='".$owner->id."'>".$owner->first_name." ".$owner->last_name."</option>";
                            
                        }?>
                        </select>
                    
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
             <?php if ($boatid->getImage() != null) { ?>
                <img src="<?php echo $boatid->getImage(); ?>" alt="Profile image" />
                <p>Current image</p>
            <?php } ?>
             <div class="alert alert-info">
                <strong>Note:</strong> Only <code>.jpg</code>, <code>.gif</code>, and <code>.png</code> formats allowed. Max file size: <code>5MB</code>.
            </div>
            <div class="mb-4">
                <input type="submit" name="submit" value="Submit" class="btn btn-primary">
				
            </div>
    </div>
</div>
<?php

require_once('includes/footer.php');
