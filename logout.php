<?php

  session_start();

  unset($_SESSION['id_akun']);

  // destroy the session
  session_destroy();  

  header("Location: login.php");

?>