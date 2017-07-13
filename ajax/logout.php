<?php
  require_once('../connection/connection.php');
  header('Access-Control-Allow-Origin:*');
  session_start();
  if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    $sql = $pdo -> prepare('DELETE FROM online_user WHERE `session_id` = :session_id;');
    $sql -> bindValue(':session_id', $_SESSION['session_id']);
    $result = $sql -> execute();
    if ($result == true) {
      unset($_SESSION['username']);
      unset($_SESSION['session_id']);
      echo '{"status":"true"}';
    }
    else {
      header('HTTP/1.1 401 Unauthorized');
      echo '{"status":"false"}';
    }
  }
