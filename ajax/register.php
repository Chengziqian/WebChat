<?php
include_once('../connection/connection.php');
header('Access-Control-Allow-Origin:*');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $sql = $pdo ->prepare('SELECT * FROM user WHERE `username` = :username;');
  $sql -> bindValue(':username', $_POST['username']);
  $sql -> execute();
  $result = $sql -> fetch(PDO::FETCH_ASSOC);
  if ($result === false) {
    $sql = $pdo -> prepare('INSERT INTO user(`username`, `password`) VALUES(:username, :password);');
    $sql -> bindValue(':username', $_POST['username']);
    $sql -> bindValue(':password', $_POST['password']);
    $sql -> execute();

    session_start();
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['session_id'] = session_id();

    $sql = $pdo -> prepare('INSERT INTO online_user(`username`, `session_id`, `deadline`) VALUES(:username, :session_id, :deadline);');
    $sql -> bindValue(':username', $_POST['username']);
    $sql -> bindValue(':session_id', session_id());
    $sql -> bindValue(':deadline', date('Y-m-d H:i:s',time()+10));
    $sql -> execute();

    echo '{"status":"true"}';
  }
  else {
    echo '{"status":"false"}';
  }
}
