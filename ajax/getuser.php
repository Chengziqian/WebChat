<?php
  require_once('../connection/connection.php');
  header('Access-Control-Allow-Origin:*');
  session_start();
  if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    echo $_SESSION['username'];
  }
