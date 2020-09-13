<?php

session_start();
session_unset();
session_destroy();

header("location: /CHATUR_PHP/forum/home.php");
exit;

?>