<?php

$host = 'localhost';  
$dbase = 'cktech'; 
$user = "root";  
$pass = ""; 
$msg = "";
$dsn = 'mysql:dbname='.$dbase.';host='.$host;

 $sqli_con = new mysqli($host, $user,$pass,$dbase);
if ($sqli_con->connect_error) {
      //print_r($e->getMessage());
    print "{msg:\"Error\",Error: \"";
    print $sqli_con->connect_error;
    print "\"}";
    //die("Connection failed: " . $sqli_con->connect_error);
} 
try {
    $pdo_con = new PDO($dsn, $user, $pass);
    $pdo_con ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    print "{msg:\"Error\",Error: \"";
    print $e->getMessage();
    print "\"}";
    //echo 'Connection failed: ' . $e->getMessage();
}
 
?>