<?php
  session_start();
  require_once('../connection/connection.php');
  require_once('checkauth.php');
  header('Access-Control-Allow-Origin:*');

  if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    $judge = CheckAuth();
    if ($judge == -1){
      header('HTTP/1.1 401 Unauthorized');
      //Header("HTTP/1.1 404 Not Found");
    }
    elseif ($judge == 0) {
      echo "REPEAT";
    }
    else {
      // if (isset($_GET['getuser'])) {
      //   echo '{"username":"'.$_SESSION['username'].'"}';
      //   unset($_GET['getuser']);
      // }
      // else {
        // $sql = $pdo-> prepare('SELECT * FROM online_user WHERE `username` = :username ;');
        // $sql-> bindValue(':username', $_SESSION['username']);
        // $sql-> execute();
        // $online_user = $sql-> fetch(PDO::FETCH_ASSOC);
        // $left_time = $online_user['deadline'];


        $sql = $pdo -> prepare('UPDATE online_user SET `deadline` = :deadline WHERE `username` = :username');
        $sql-> bindValue(':deadline', date('Y-m-d H:i:s',time()+3));
        $sql-> bindValue(':username', $_SESSION['username']);
        $sql-> execute();

        $sql = $pdo-> prepare('SELECT * FROM message WHERE `id` > :id ;');
        $sql-> bindValue(':id', $_GET['from_id']);
        $sql-> execute();
        $datas = $sql->fetchall(PDO::FETCH_ASSOC);
        if ($datas == false){
          echo "NULL";
        }
        else {
          $i = 0;
          foreach ($datas as $data) {
            if ($data['username'] === $_SESSION['username']) {
              $datas[$i]['status'] = 1;
            }
            else {
              $datas[$i]['status'] = 0;
            }
            $i++;
          }
          echo json_encode($datas);
        }
      // }
          $sql = $pdo ->prepare('SELECT * FROM online_user');
          $sql-> execute();
          $useronline = $sql -> fetchall(PDO::FETCH_ASSOC);
          foreach ($useronline as $user) {
            $deadtime = $user['deadline'];
            if (time() > strtotime($deadtime)) {
              $sql = $pdo -> prepare('DELETE FROM online_user WHERE `username` = :username');
              $sql -> bindValue(':username', $user['username']);
              $sql -> execute();
            }
          }
    }


  }
  if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $sql = $pdo-> prepare('INSERT INTO message(`message`, `username`, `time`) VALUES (:message, :username, :sendtime);');
    $sql-> bindValue(':message', $_POST['message']);
    $sql-> bindValue(':username', $_SESSION['username']);
    $sql-> bindValue(':sendtime', date('Y-m-d H:i:s',time()));
    $sql-> execute();


  }
