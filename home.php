<html>         
  <head>        
    <title >
      USER HOME            
    </title>
    <?php
   if ($_COOKIE['username']=='') {
      header("Location:index.php");
    }
    include './includefiles/bubbles.php';
    include './includefiles/header.php';
    include './includefiles/nav_menu.php';
    ?>        
  </head>
  <body class="myback">                     

    <div class="content homepage">                            
      <div class="container"  >           
        <form method="post" >                                   
          <?php // $st=print_r($_COOKIE);$way=  explode(";", $st);  //all cookie values ?>
          <?php// echo htmlentities($_COOKIE['username'], 3, 'UTF-8'); ?>          
          <?php          
          include './includefiles/config.php';
          $sql = "select user_type,full_name from user_tbl where username='" . htmlentities($_COOKIE['username'], 3, 'UTF-8') . "'";
          $res = $con->query($sql) or exit(mysqli_error($con));          
          $rs = mysqli_fetch_assoc($res);
          //echo $rs['user_type'];
          ?>
          
          <?php
          if ($rs['user_type'] == 'STUDENT') {
            $sql = "select * from tblattend where regno='" . htmlentities($_COOKIE['username'], 3, 'UTF-8') . "'";
         $res = $mscon->query($sql);$msg="";
              $count = 1;?>
          <div class="row">
          <table class="table-bordered table-condensed table ">
            <tr><th >S.NO</th><th>DATE</th><th>HOUR-1</th><th>HOUR-2</th><th>HOUR-3</th><th>HOUR-4</th><th>HOUR-5</th><th>REASON</th>
            </tr>  <?php
            while ($rs = $res->fetch()) {
              $msg = "";
               if (($rs['Hr1'] == 'AB') || ($rs['Hr2'] == 'AB') || ($rs['Hr3'] == 'AB') || ($rs['Hr4'] == 'AB') || ($rs['Hr5'] == 'AB')) {
            ?> <tr >                                                
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $rs['ADate'] ?></td>
                        <td><?php echo $rs['Hr1'] ?></td>
                        <td><?php echo $rs['Hr2'] ?></td>
                        <td><?php echo $rs['Hr3'] ?></td>
                        <td><?php echo $rs['Hr4'] ?></td>
                        <td><?php echo $rs['Hr5'] ?></td>
                        <td><?php echo $rs['LType'] ?></td>
                        <?php //  $s.=$rs['hr2'] . " is sucess" . file_get_contents("./index.php");   ?>
                    </tr>
                    <?php
                 
               }                             
            }
            ?>
          </table>
            <?php
          }
          ?>
          </div>
        </form>
        <?php
        //print "username =" + $_POST['user'];
        include_once './includefiles/footer.php';
        ?>
      </div>
    </div>    
  </body>
</html>
