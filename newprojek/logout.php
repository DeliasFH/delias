
<?php
// logout.php: Logout dan redirect ke halaman login
session_start();
session_unset();
session_destroy();
header('Location: index.php');
exit;
?>
