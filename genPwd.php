<?php

// Temporary pw generator - probably don't expose this if serving publicly!
if(!isset($_GET['p'])) {
    header('Location: index.php');
}

echo password_hash($_GET['p'], PASSWORD_DEFAULT);
