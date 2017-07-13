<?php
session_start();
include_once('../connection/connection.php');
require_once('checkauth.php');
header('Access-Control-Allow-Origin:*');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $sql = $pdo -> prepare('SELECT * FROM user WHERE `username` = :username AND `password` = :password;');
  $sql -> bindValue(':username', $_POST['username']);
  $sql -> bindValue(':password', $_POST['password']);
  $sql -> execute();
  $result = $sql -> fetch(PDO::FETCH_ASSOC);
  if ($result === false ) {
    echo '{"status":"false"}';
  }
  else {

    $sql = $pdo -> prepare('DELETE FROM online_user WHERE `username` = :username');
    $sql -> bindValue(':username', $_POST['username']);
    $sql -> execute();

    $_SESSION['username'] = $_POST['username'];
    $_SESSION['session_id'] = session_id();
    $sql = $pdo -> prepare('INSERT INTO online_user(`username`, `session_id`, `deadline`) VALUES(:username, :session_id, :deadline);');
    $sql -> bindValue(':username', $_POST['username']);
    $sql -> bindValue(':session_id', session_id());
    $sql -> bindValue(':deadline',date('Y-m-d H:i:s',time()+3));
    $sql -> execute();
    echo '{"status":"true"}';
  }
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if (isset($_GET['require']) && $_GET['require'] === 'check_login') {
    if (CheckAuth() == 1) {
      echo 'true';
    }
  }
}
