<?php
session_start();
$_SESSION = [];
session_unset();
session_destroy();
// setcookie('nama', '', time() - 3600);
// setcookie('pass', '', time() - 3600);
header("Location: index.php");
exit;
?>