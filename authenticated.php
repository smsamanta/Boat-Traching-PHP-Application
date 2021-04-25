<?php

session_start();

require_once('class/User.php');

// If we're not logged in, go to the login page
if (empty($_SESSION['isLoggedIn'])) {
    header('Location: login.php');
}

// We know we're authenticated so get the user by the id stored in the session.
$user = User::find($_SESSION['userId']);

require_once('includes/header.php');
?>

<div class="container">
    <div class="row mt-5">
        <div class="col text-center">
            <h1>AUTHENTICATED!</h1>
            <h3>Hello, <?php echo $user->getFirstName(); ?>!</h3>

            <?php if ($user->getImage() != null) { ?>
            <p><img src="<?php echo $user->getImage(); ?>" alt="Profile image" /></p>
            <?php } ?>

            <a href="editUser.php?id=<?php echo $user->getId(); ?>">Edit Profile</a>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col text-center">
            <a href="logout.php">Logout</a>
        </div>
    </div>
</div>

<?php

require_once('includes/footer.php');
