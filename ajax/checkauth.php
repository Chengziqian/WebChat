<?php
function CheckAuth(){

  if ( !isset($_SESSION['session_id']) || !isset($_SESSION['username']) ){
    return -1;
  }
  else {
    global $pdo;
    $username = $_SESSION['username'];
    $sql = $pdo -> prepare('SELECT * FROM online_user WHERE `username` = :username;');
    $sql -> bindValue(':username', $username);
    $sql -> execute();
    $row = $sql -> fetch(PDO::FETCH_ASSOC);
    if ($row === false) {
      return -1;
    }
    else {
      if ($row['session_id'] === $_SESSION['session_id']) {
        return 1;
      }
      else {
        return 0;
      }
    }
  }
}
