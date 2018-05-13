<?php
if (!isset($_COOKIE['username'])) {
  $_COOKIE['username'] = '';
}
include 'config.php';
$sql = "select * from user_tbl where username='" . htmlentities($_COOKIE['username'], 3, 'UTF-8') . "'";
$res = $sqli_con->query($sql) or exit(mysqli_error($sqli_con));
$rs = mysqli_fetch_assoc($res);
$user_type=$rs['user_type'];
$user = $rs['username'];
$fullname = $rs['full_name'];
$email = $rs['email'];
$mobile = $rs['mobile'];
$dob = $rs['dob'];
$gender = $rs['Gender'];
$dp_image= 'data:image/jpeg;base64,'.base64_encode($rs['dp_image']);
?>




