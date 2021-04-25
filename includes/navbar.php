<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="index.php" class="navbar-brand">
      
        <span class="brand-text font-weight-light">Marina</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="index.php" class="nav-link">Home</a>
          </li>
          <?php if (!isset($_SESSION['isLoggedIn'])) { ?>
         <li class="nav-item">
            <a href="login.php" class="nav-link">Login</a>
          </li>
          <?php } ?>
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Boats</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="addBoat.php" class="dropdown-item">Add Boat </a></li>
              <li><a href="viewBoats.php" class="dropdown-item">View All Boats</a></li>

            </ul>
          </li>
		   <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Users</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              
              <li><a href="addUser.php" class="dropdown-item">Add User </a></li>
              <li><a href="viewUsers.php" class="dropdown-item">View All Users</a></li>
            </ul>
          </li>
         <!-- <li class="nav-item">
            <a href="editUser.php?id=<?php echo $user->getId(); ?>" class="nav-link">MyProfile</a>
          </li>-->
        </ul>

        <!-- SEARCH FORM -->
        <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']) { ?>
        <li class="nav-item">
            <a href="logout.php" class="nav-link">Logout</a>
          </li>
        <?php } ?>
      </ul>
      </div>

     
    </div>
  </nav>