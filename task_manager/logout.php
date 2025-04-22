<?php
session_start();          // Session start karo
session_unset();          // Sare session variables hatao
session_destroy();        // Session ko destroy kar do

header("Location: login.php"); // Login page pe bhej do
exit();
?>
