<?php

try {
    require_once './config.php';
    $req_arr = $_POST['requestData']; //json_decode(,true);;
    $querytype = $req_arr["method"];
    if ($querytype == "saveData") {
        $querytype = $req_arr["primaryColumn"];
        $table = $req_arr["table"];
        $fields = $req_arr["fields"];
        $datatype = $req_arr["datatype"];
        print_r($req_arr);
        $array = $jsondata;
        $array = json_decode($jsondata, true);
        $jsondata = json_decode('[{"var1":"9","var2":"16","var3":"16"},{"var1":"8","var2":"15","var3":"15"}]');
        
        foreach ($jsondata as $key => $jsons) { // This will search in the 2 jsons
            foreach ($jsons as $key => $value) {
                echo "\n" . $value; // This will show jsut the value f each key like "var1" will print 9
                // And then goes print 16,16,8 ...
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
?>