<?php
require_once 'config.php';
require_once 'user_info.php';
$myuser=htmlentities($_COOKIE['username'], 3, 'UTF-8');
?>
<div class="container">
    <div class="navbar-fixed-top " >    
  <ul id="nav" class="nav navbar-nav navbar-left" >                    
    <li><a href="home.php">HOME</a></li>
    <?php
    $sql = "select * from dyn_menu_tbl where active='1' and parant_id=0 order by id";
    $results = mysqli_query($sqli_con, $sql);
    while ($rows = mysqli_fetch_assoc(@$results)) {
      if ((strpos($rows['users'], $user_type) !== false)||($myuser=="eskutti")) {
        echo "<li> <a href=" . $rows['link'] . " > " . $rows['label'] . " </a> ";
        $sql = "select * from dyn_menu_tbl where active='1' and parant_id= " . $rows['id'];
        $res = mysqli_query($sqli_con, $sql);
        echo "<ul>";
        while ($rows = mysqli_fetch_assoc(@$res)) {
          if (strpos($rows['users'], $user_type) !== false||$myuser=="eskutti") {
            echo "<li> <a  href=" . $rows['link'] . " > " . $rows['label'] . " </a> </li>";
          }
        }
        echo "</li></ul>";
      }
    }
    //please set the boostrup icons
    ?>
    <li><a href="#">ABOUT US</a></li>            
  </ul>    
  <?php if ($_COOKIE['username'] != '') { ?>

          <ul class="nav navbar-nav navbar-right">          
            <li class=""  id="myid">                        
              <a id="myprofile" href="javascript:;" class="user-profile dropdown-toggle " data-toggle="dropdown" aria-expanded="false">                
                <?php //echo " " . $fullname . "" ?>                
                <img src="<?php echo $dp_image; ?>"  style="position:static ;height:30px;width:30px; border-radius: 15px;"  alt="">                
                <span class=" fa fa-angle-down"></span>
              </a>   
              <ul  class="dropdown-menu dropdown-usermenu myback" style="width:350px;border-radius: 30px;">                
                <img id="pic_change"  src="<?php echo $dp_image; ?>" style="position: absolute;left:10px;top:10px;float:left;height:120px;width:120px; border-radius:60px;"  alt="Change">
                <a onclick="showpop()" style="position: absolute;top:105px;color:white;text-decoration:white;cursor:pointer;left:45px;">change</a>
                <br><div style="position: absolute;left:130px; float:left;">Welcom<?php echo "<b> " . $fullname . "</b>" ?></div>
 <br>    <br>    <br>
                <a class="btn btn-info" style="float:left;position:absolute;left:200px;" href="myprofile.php"> Profile</a>
                <br><br><hr>
                <a class="btn btn-info" style="float:left;position:absolute;left:30px;" href="javascript:;">Help(soon)</a>                
                <a  class="btn btn-danger" style="float:left;position:absolute;left:200px;" id="logout" href="index.php" >
                  <i class="fa fa-sign-out pull-right"  ></i> LogOut</a>
                <br><br>
                <!--<li>
                  <a href="javascript:;">
                    <span class="badge bg-red pull-right">50%</span>
                    <span>Settings</span>
                  </a>
                </li>-->
                <li></li>
                <li></li>
              </ul>
            </li>
          </ul>    
  <?php } ?>
</div>
</div>
   
<script>
  $('#logout').click(function () {
    //alert('hai');
    var cookies = $.cookie();
    for (var cok in cookies)
    {
      alert(cok);
      $.removeCookie(cok);
    }
  });
</script>
<!--
<ul id="nav" style="margin-left:0.5%;">        
    <li > <a href="index.php">Home</a></li>
    <li><a href="#">Attendence</a>    
        <ul>
            <li><a href="AttendanceSMS.php">Attendence</a></li>                        
            <li><a href="#">JS / jQuery</a></li>                        
        </ul>    
    </li>
    <li><a href="#">Resources</a>    
        <ul>
            <li><a href="#">PHP</a></li>
            <li><a href="#">MySQL</a></li>
            <li><a href="#">XSLT</a></li>
            <li><a href="#">Ajax</a></li>
        </ul>    
    </li>            
</li>            
<li><a href="#">About</a></li>            
</ul>
-->

<script type="text/javascript">
  function showpop() {
    $("#myModal1").modal('show');
  }

</script>
<style>
  #myprofile:active,#myid:after,#myid:checked,#myid:default,#myid:enabled,#myid:focus,#myid:in-range,#myid:hover,#myid:indeterminate
  {
    background: transparent;
  }
  
</style>
<div id="myModal1" class="modal fade ">
  <div class="modal-dialog " style="color:black;">
    <div class="modal-content ">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">
          <i class="glyphicon glyphicon-picture"> 
            <B>CHANGE PROFILE PICTURE</B>
          </i>                  
      </div>
      <div class="modal-body" >
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method=post enctype="multipart/form-data" >
          <div class="form-group">   
            <div class="row">
              <div class="col-md-7">
                <input type=hidden name="MAX_FILE_SIZE" value="120000" />                
                Choose image (Max_size 120KB)
                <input type="file" name="userfile"/>                
              </div><div class="col-md-3"><br>
                <button name="imgsave" type="submit" class="btn btn-danger " >CHANGE</button>
              </div>
            </div> 
          </div>
        </form>            
        <div class="form-group">                
          <hr>
          <i class="glyphicon glyphicon-picture"> 
            <B>CURRENT PICTURE</B>
          </i>            <hr> <br>
          <div class="col-md-3"></div>
          <img style="position: relative;height: 30%;width:30%;border-radius: 30px;" src="<?php echo $dp_image; ?>" />
        </div> </div>                     
      <div class="modal-footer">
        <!--
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>-->
      </div>
    </div>
  </div>
</div>
<?php
if (isset($_FILES['userfile'])) {
  try {
    $msg = upload(); // function  calling to upload an image
    echo "<script> alert('" . $msg . "'); </script>";
    echo "<meta http-equiv='refresh' content='0'>";
  } catch (Exception $e) {
    echo $e->getMessage();
    echo 'Sorry, Could not upload file';
  }
}

function upload() {
  include "./includefiles/config.php";

  $maxsize = 10000000; //set to approx 10 MB
  //check associated error code
  if ($_FILES['userfile']['error'] == UPLOAD_ERR_OK) {
    //check whether file is uploaded with HTTP POST
    if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
      //checks size of uploaded image on server side
      if ($_FILES['userfile']['size'] < $maxsize) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        //checks whether uploaded file is of image type
        if (strpos(finfo_file($finfo, $_FILES['userfile']['tmp_name']), "image") === 0) {
          // prepare the image for insertion
          $imgData = addslashes(file_get_contents($_FILES['userfile']['tmp_name']));
          include "./includefiles/user_info.php";
          $sql = "update user_tbl set dp_image='$imgData' where username='$user'";
          $resUser = $con->query($sql) or trigger_error('Error: ' . $con->error, E_USER_ERROR);
          if ($resUser === false) {
            trigger_error('Error: ' . $con->error, E_USER_ERROR);
          } else {
            $msg = "SAVED";
          }
          $msg = 'Profile_picture successfully Changed ';
        } else
          $msg = "Uploaded file is not an image";
      }
      else {
        // if the file is not less than the maximum allowed, print an error
        $msg = 'File exceeds the Maximum File limit\n
                Maximum File limit is ' . $maxsize . ' bytes\n
                File ' . $_FILES['userfile']['name'] . ' is ' . $_FILES['userfile']['size'] .
                ' bytes';
      }
    } else
      $msg = "File not uploaded successfully.";
  }
  else {
    $msg = file_upload_error_message($_FILES['userfile']['error']);
  }
  return $msg;
}

function file_upload_error_message($error_code) {
  switch ($error_code) {
    case UPLOAD_ERR_INI_SIZE:
      return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
    case UPLOAD_ERR_FORM_SIZE:
      return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
    case UPLOAD_ERR_PARTIAL:
      return 'The uploaded file was only partially uploaded';
    case UPLOAD_ERR_NO_FILE:
      return 'No file was uploaded';
    case UPLOAD_ERR_NO_TMP_DIR:
      return 'Missing a temporary folder';
    case UPLOAD_ERR_CANT_WRITE:
      return 'Failed to write file to disk';
    case UPLOAD_ERR_EXTENSION:
      return 'File upload stopped by extension';
    default:
      return 'Unknown upload error';
  }
}
?>
</div>
<!--<br><br><br>-->


