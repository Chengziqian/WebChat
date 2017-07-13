<?php
date_default_timezone_set('PRC');
$conn_hostname='localhost';
$conn_database='Chat';
$conn_username='root';
$conn_psaaword='root';
try{
    $pdo=new PDO('mysql:host='.$conn_hostname.';dbname='.$conn_database,$conn_username,$conn_psaaword);
    $pdo->exec('SET NAMES UTF8');
}
catch (Exception $e){
die('<h1>数据库链接错误！</h1>');
return;
}
