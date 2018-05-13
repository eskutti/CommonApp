<?php
//$mscon = new mysqli("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$db");
include './config.php';
if ($_POST) {
    $sql = $_POST['query'];
    if ($_POST['action'] == 'view') {
        /* $res = $mscon->query("update tblattend set adate=date()-2 where hr1='ab'");
          echo $res; */
        //$viewsql = "select regno,hr1,hr2,hr3,hr4,hr5 from tblattend where  regno LIKE '%$cor%' ";                                                                
        //$viewsql = "select regno,hr1,hr2,hr3,hr4,hr5 from tblattend where  adate = #16-Jun-16# ";                                                                                                
        //$mydate = $_POST['myDate'];
        //$viewsql = "select regno,hr1,hr2,hr3,hr4,hr5 from tblattend where  adate = #$mydate# ";
        ?>
        <table width="100%"  class="table-bordered">
            <tr><th>S.NO</th><th>Register NO</th><th>hr1</th><th>hr2</th><th>hr3</th><th>hr4</th><th>hr5</th>
            </tr>                        
            <?php
           $res = $mscon->query($sql);$msg="";
              $count = 1;
            while ($rs = $res->fetch()) {
                ?>
                <tr >                                                
                    <td><?php echo $count++ ?></td>              
                    <td><?php echo $rs['regno'] ?></td>              
                    <td><?php echo $rs['hr1'] ?></td>                
                    <td><?php echo $rs['hr2'] ?></td>                
                    <td><?php echo $rs['hr3'] ?></td>                
                    <td><?php echo $rs['hr4'] ?></td>                
                    <td><?php echo $rs['hr5'] ?></td>                                
                    <?php //  $s.=$rs['hr2'] . " is sucess" . file_get_contents("./index.php");   ?>
                </tr>
                <?php
            }//whilte
            ?>
        </table>
        <?php
    }//if
    else {
        ?> <table class="table-bordered blue ">
            <tr><th >S.no</th><th>REG NO</th><th>Message</th><th>STATUS</th>
            </tr>                    
        <?php
        $sno = 1;
        $res = $mscon->query($sql);$msg="";
        while ($rs = $res->fetch()) {$msg="";
            //if (($rs['hr1'] == 'AB') || ($rs['hr2'] == 'AB') || ($rs['hr3'] == 'AB') || ($rs['hr4'] == 'AB') || ($rs['hr5'] == 'AB')) {
          $msg="<pre>Regno  : ".$rs['regno']."<br>";//"Name : ".$rs['name']."<br>"          
          $msg.="Hour-1 :   ".$rs['hr1']."<br>";
          $msg.="Hour-2 :   ".$rs['hr2']."<br>";
          $msg.="Hour-3 :   ".$rs['hr3']."<br>";
          $msg.="Hour-4 :   ".$rs['hr4']."<br>";
          $msg.="Hour-5 :   ".$rs['hr5']."<br></pre>";
          /*
                     if (($rs['hr1'] == 'AB') && ($rs['hr2'] == 'AB') && ($rs['hr3'] == 'AB') && ($rs['hr4'] == 'AB') && ($rs['hr5'] == 'AB')) {                        
                        $msg.="One day ";
                    }
                    else if (($rs['hr1'] == 'AB') ||($rs['hr2'] == 'AB') || ($rs['hr3'] == 'AB'))
                    {
                           $msg.="First 3 Hrs ".$rs['adate'];                                                
                    }
                    else if (($rs['hr4'] == 'AB') || ($rs['hr5'] == 'AB'))
                        {
                        $msg.="Last 2 Hr's ";
                        }*/
                ?>        
                    <tr >                                                
                        <td><?php echo $sno++; ?></td>                 
                        <td><?php echo $rs['regno']; ?></td>                              
                        <td><?php echo $msg; ?></td>                              
                        <td><?php echo "sucess"; ?></td>                                
                        <?php //  $s.=$rs['hr2'] . " is sucess" . file_get_contents("./index.php");   ?>
                    </tr>
                    <?php
                //}
            }
        }
        ?>
    </table>
    <?php
}
?>