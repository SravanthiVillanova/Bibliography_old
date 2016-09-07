<?php

// Make absolutely certain that the session is destroyed:
unset($_SESSION['user_id']);
if (isset($_COOKIE[session_name()])) {
   setcookie(session_name(), '', time()-42000, '/');
}
session_destroy();

header('Location: ' . $configArray['Main']['url']);
?>
