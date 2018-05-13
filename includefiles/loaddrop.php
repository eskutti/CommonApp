
<?php
if ($_POST) {
    require_once 'config.php';
    ?> 
    <?php    
    $val="";
    $query = $_POST['query'];
    echo "<select id='".$_POST['id']."' class='".$_POST['class']."' name='".$_POST['name']."'>";
    echo "<option  > ". $_POST['name']."</optoin>";
    $results = mysqli_query($con,$query);
    while ($rows = mysqli_fetch_assoc(@$results)) {
    $val.="<option value='". $rows['k']."' >".$rows['v']."</option>";    
     }
     echo $val;
    }
?>
    </select>
<?php
    /*
    function dept($query)
    {
    require_once './includefiles/config.php';

    //$query = "select id as k,course as v  from department_tbl";
    $results = mysql_query($query);
    while ($rows = mysql_fetch_assoc(@$results)) {
    $val.="<option value=". $rows['k']." >".$rows['v']."</option>";
    }                   
    return $val;
    }*/
    ?>