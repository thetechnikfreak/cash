<?php
// Lösche das Cookie "username"
setcookie("username", "", time() - 3600, "/");

// Weiterleitung auf "/web.php"
header("Location: web.php");
exit;
?>
