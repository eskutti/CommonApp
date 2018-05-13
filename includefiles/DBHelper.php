<?php

try {
    require_once './config.php';
    $req_arr = $_POST['requestData']; //json_decode(,true);;
    $querytype = $req_arr["method"];
    if ($querytype == "saveData") {
        $primaryColumn = $req_arr["primaryColumn"];
        $table = $req_arr["table"];
        $fields = $req_arr["fields"];
        $tableData = $req_arr["data"];
        // $array = json_decode($tableData, true);
        //$tableData = json_decode('[{"var1":"9","var2":"16","var3":"16"},{"var1":"8","var2":"15","var3":"15"}]');
        $sql_insert = " INSERT INTO " . $table . " (";
        $sql_update = " UPDATE " . $table . " set ";
        $temp_insert = "";
        $temp_update = "";
        $temp_insertcolums = "";
        // $stmt = $sqli_con->prepare("INSERT INTO MyGuests (firstname, lastname, email) VALUES (?, ?, ?)");
        // $stmt->bind_param("sss", $firstname, $lastname, $email);
        $isFirst = true;
        $isPrimary = false;
        foreach ($fields as $key => $value) {
            if ($primaryColumn == $key)
                $isPrimary = true;
            else
                $isPrimary = false;

            if ($temp_update != "")
                $temp_update .= ",";
            if ($temp_insert != "")
                $temp_insert .= ",";
            if ($temp_insertcolums != "")
                $temp_insertcolums .= ",";

            if (!$isPrimary) {
                // $temp_update .= $key . " = :" . $key;
                $temp_update .= $key . " = ?";
                $temp_insert .= "?";
                $temp_insertcolums .= $key;
            }
        }
        $sql_update .= $temp_update;
        $sql_insert .= $temp_insertcolums . ") VALUES (" . $temp_insert . ")";
        $sql_update .= " WHERE " . $primaryColumn . " = ?";
        //$sql_update .= " WHERE " . $primaryColumn . " = :" . $primaryColumn;
        //  print $sql_update;
        $stmt_insert = $sqli_con->prepare($sql_insert);
        $stmt_update = $sqli_con->prepare($sql_update);
        $dataType = "";
        $isNew = false;
        //$lpdoparam = array();
//        $stmt = $pdo_con->prepare($stmt_update);
//        $i = 0;
//        foreach ($fields as $key => $value) {
//            array_push($lpdoparam, $key);
//            $stmt->bindParam(':firstname', $lpdoparam[$i]);
//        }
//        print_r($lpdoparam);
//        foreach ($tableData as $t_key => $t_value) {
//            $i = 0;
//            foreach ($fields as $f_key => $f_value) {
//                $lpdoparam[$i] = $t_value[$f_key];
//            }
//            print_r($lpdoparam);
//            print_r($stmt);
//            $stmt->execute();
//        }
        foreach ($tableData as $t_key => $t_value) {
            $lparam = array();
            if ($t_value[$primaryColumn] == "" || $t_value[$primaryColumn] == "0")
                $isNew = true;
            $dataType = "";
            $myval = "";
            foreach ($fields as $f_key => $f_value) {
                if ($f_key == $primaryColumn) {
                    continue;
                }
                if($myval !="")
                    $myval .=",";
                //print_r($t_value[$f_key]);
                array_push($lparam, $t_value[$f_key]);
                // print_r($f_key);
                //print_r($t_value);
                $dataType .= $f_value;
            }
            if ($isNew) {
                //print_r($lparam);
                //echo $dataType;
                //$stmt_insert->bind_param($dataType, $lparam);
                //$stmt_insert->execute();
                // print "inserted";
            } else {
                $dataType .= "i";
                array_push($lparam, $t_value[$primaryColumn]);
                print_r($lparam);
                print_r($dataType);
//                print_r($stmt_update);
                eval('$stmt_update->bind_param( ' . $dataType . ',' . $lparam . '); ');
                $stmt_update->bind_param($dataType, $lparam);
                $stmt_update->execute();
                // print "updated";
            }
        }

        $msg = "{msg:'SUCCESS'}";
    } else if ($querytype == "json") {
        $sql = $req_arr["query"];
        $encode = array();
        $results = mysqli_query($sqli_con, $sql) or print mysqli_error("{msg:'Error',Error: '" . $sqli_con + "'}");
        while ($rows = mysqli_fetch_assoc($results)) {
            $encode[] = $rows;
        }
        print json_encode($encode);
    } else if ($querytype == "query") {
        $sql = $_POST['query'];
        $resUser = $sqli_con->query($sql) or trigger_error("{msg:'Error',Error: '" . $sqli_con->error + "'}", E_USER_ERROR);
        if ($resUser === false) {
            trigger_error("{msg:'Error',Error: '" . $sqli_con->error + "'}", E_USER_ERROR);
        } else {
            $msg = "{msg:'SUCCESS'}";
        }
    }//query
} catch (Exception $e) {
    //print_r($e->getMessage());
    print "{msg:\"Error\",Error: \"";
    print $e->getMessage();
    print "\"}";
}
//i	 integer
//d	 double
//s	 string
//b	corresponding variable is a blob and will be sent in packets
?>


