<?php
  require_once('../connection/connection.php');
  header('Access-Control-Allow-Origin:*');
  session_start();
  if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    $sql = $pdo -> prepare('SELECT `username` FROM online_user');
    $sql -> execute();
    $online = $sql -> fetchall(PDO::FETCH_ASSOC);
    echo json_encode($online);
  }
