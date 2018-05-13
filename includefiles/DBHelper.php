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
        $sql_insert = " INSERT INTO " . $table . " (";
        $sql_update = " UPDATE " . $table . " set ";
        $temp_insert = "";
        $temp_update = "";
        $temp_insertcolums = "";
        $isFirst = true;
        $isPrimary = false;
        foreach ($fields as $key) {
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
                $temp_update .= $key . " = :" . $key;
            }
            $temp_insert .= ":" . $key;
            //$temp_update .= $key . " = ?";
            //$temp_insert .= "?";
            $temp_insertcolums .= $key;
            //}
        }
        $sql_update .= $temp_update;
        $sql_insert .= $temp_insertcolums . ") VALUES (" . $temp_insert . ")";
        //$sql_update .= " WHERE " . $primaryColumn . " = ?";
        $sql_update .= " WHERE " . $primaryColumn . " = :" . $primaryColumn;
        //print $sql_update . " " . $sql_insert;
        $stmt_insert = $pdo_con->prepare($sql_insert);
        $stmt_update = $pdo_con->prepare($sql_update);
        $dataType = "";
        $isNew = false;
        $lpdoparam = array();
        //$stmt = $pdo_con->prepare($sql_update);
        $i = 0;
        foreach ($fields as $key) {
            array_push($lpdoparam, $key);
            // if ($key != $primaryColumn)
            $stmt_insert->bindParam(':' . $key, $lpdoparam[$i]);
            $stmt_update->bindParam(':' . $key, $lpdoparam[$i]);
            $i++;
        }

        foreach ($tableData as $t_key => $t_value) {
            $i = 0;
            $isNew = false;
            if ($t_value[$primaryColumn] == "" || $t_value[$primaryColumn] == "0") {
                $isNew = true;
            }
            foreach ($fields as $f_key) {
                $lpdoparam[$i] = $t_value[$f_key];
                $i++;
            }
            if ($isNew)
                $stmt_insert->execute();
            else
                $stmt_update->execute();
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
    else {
        print "{msg:'Error',Error: 'No method Avaiable for give key'}";
    }
    print trim($msg);
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


