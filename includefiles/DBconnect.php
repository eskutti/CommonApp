<?php

include_once './config.php';

if ($_POST) {
  $querytype = $_POST['method'];
  
  if ($querytype == "insert") {
    $i = 0;
    $field = $val = $tbl = "";
    foreach ($_POST as $key => $value) {
      if ($i == 0) {
        $field = " $key ";
        $val = "'" . mysqli_real_escape_string($sqli_con, $value) . "'";
      } else if (($key == "tbl")) {
        $tbl = $value;
      } else if (($key == "method")) {
        
      } else {
        $field.=",$key";
        $val.=",'" . mysqli_real_escape_string($sqli_con, $value) . "' ";
      }
      $i++;
    }
    $sql = "Insert into $tbl($field) values($val) ";
    $resUser = $sqli_con->query($sql) or trigger_error('Error: ' . $sqli_con->error, E_USER_ERROR);
//echo "<br>" . $sql;                
    if ($resUser === false) {
      trigger_error('Error: ' . $sqli_con->error, E_USER_ERROR);
    } else {
      $msg = "SAVED";
    }
    /* $retrival = mysql_query($sql, $sqli_con) or exit(mysql_error($sqli_con));
      if ($retrival) {
      $msg = "SAVED";
      } else {
      $msg = "FAIELD:" . mysql_error();
      } */
  }//insert method
  else if ($querytype == "update") {
    $upf = $whf = $ftbl = 0;
    $field = $val = $tbl = $whr = "";
    foreach ($_POST as $key => $value) {
      if (($key == "tbl")) {
        $tbl = $value;
        $ftbl = 1;
      } else if (($key == "method")) {
        
      } else if ($ftbl == 1) {
        if ($whf > 0) {
          $whr.=" and ";
        } $whr.= " " . $key . "='" . mysqli_real_escape_string($sqli_con, $value) . "' ";
        $whf++;
      } else {
        if ($upf > 0) {
          $val.=" , ";
        }
        $val.=" " . $key . "='" . mysqli_real_escape_string($sqli_con, $value) . "' ";
        $upf++;
      }
    }
    $sql = "update $tbl set $val where $whr ";
//echo "<br>" . $sql;
    $resUser = $sqli_con->query($sql) or trigger_error('Error: ' . $sqli_con->error, E_USER_ERROR);
    if ($resUser === false) {
      trigger_error('Error: ' . $sqli_con->error, E_USER_ERROR);
    } else {
      $msg = "UPDATED";
    }
  }//update
  else if ($querytype == "count") {
    $field = $val = $whr = $tbl = "";
    $i = $ftbl = $upf = $whf = 0;
    foreach ($_POST as $key => $value) {
      if ($key == "tbl") {
        $tbl = $value;
        $ftbl = 1;
      } else if ($key == "method") {
        
      } elseif ($ftbl == 1) {
        if ($i == 0) {
          $whr = " where ";
          $i++;
        }
        if ($whf > 0) {
          $whr.=" and ";
        } $whr.= " " . $key . "='" . mysqli_real_escape_string($sqli_con, $value) . "' ";
        $whf++;
      } else {
        if ($upf > 0) {
          $val.=",";
        }
        $val.=$key;
        $upf++;
      }
    }
    if ($val == "") {
      $val = " * ";
    }
    $sql = "Select $val  from  $tbl $whr";
//        echo $sql;
    $resUser = $sqli_con->query($sql);
    if ($resUser === false) {
      trigger_error('Error: ' . $sqli_con->error, E_USER_ERROR);
    } else {
      $msg = $resUser->num_rows;
    }
  }//count 
  else if ($querytype == "query") {
    $sql = $_POST['query'];
    $resUser = $sqli_con->query($sql) or trigger_error('Error: ' . $sqli_con->error, E_USER_ERROR);
    if ($resUser === false) {
      trigger_error('Error: ' . $sqli_con->error, E_USER_ERROR);
    } else {
      $msg = "SUCCESS";
    }
  }//query
  else if ($querytype == "delete") {
    $field = $val = $whr = $tbl = "";
    $i = $ftbl = $upf = $whf = 0;
    foreach ($_POST as $key => $value) {
      if ($key == "tbl") {
        $tbl = $value;
        $ftbl = 1;
      } else if ($key == "method") {
        
      } elseif ($ftbl == 1) {
        if ($i == 0) {
          $whr = " where ";
          $i++;
        }
        if ($whf > 0) {
          $whr.=" and ";
        } $whr.= " " . $key . "='" . mysqli_real_escape_string($sqli_con, $value) . "' ";
        $whf++;
      } else {
        if ($upf > 0) {
          $val.=",";
        }
        $val.=$key;
        $upf++;
      }
    }
    $sql = "Delete  From  $tbl $whr";
//        echo $sql;
    $resUser = $sqli_con->query($sql);
    if ($resUser === false) {
      trigger_error('Error: ' . $sqli_con->error, E_USER_ERROR);
    } else {
      $msg = "Deleted";
    }
  } //delete
  else if ($querytype == "json") {
    $encode = array();
    $sql = $_POST['query'];
    $results = mysqli_query($sqli_con, $sql) or print mysqli_error($sqli_con);
    while ($rows = mysqli_fetch_assoc($results)) {
      $encode[] = $rows;
    }
    print json_encode($encode);
  } //json
  else if ($querytype == "mail") {
    $to = $_POST['to'];
    $subject = $_POST['subject'];
    $message = $_POST['msg'];
    $header = "From:" . $_POST['from'] . "\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";
    $retval = mail($to, $subject, $message, $header);
    if ($retval == true) {
      $msg= "SUCESS";
    } else {
      $msg="FAILED";
    }
  }//mail  
  else if ($querytype == "sms") { {
      include('way2sms-api.php');
      $res = sendWay2SMS($_POST['userid'], $_POST['password'], $_POST['to'], $_POST['msg']);
      if (is_array($res)) {
        $msg = $res[0]['result'] ? 'true' : 'false';
      } else {
        $msg = $res;
        exit;
      }
    }
  } else {
    $msg = "no method";
  }
} else {
  $msg = "no post";
}
print $msg;?>