<html>    
  <head> 
    <title>my profile</title>
    <?php
    if ($_COOKIE['username'] == '') {
      header("Location:index.php");
    }
    include './includefiles/bubbles.php';
    include './includefiles/header.php';
    include './includefiles/nav_menu.php';
    ?>        
  </head>
  <body class="myback">     
    <script >
      $.ajaxSetup({async: false});
      $(window).load(function () {
        $('.form-control').popover({trigger: 'focus'});
      });
      function validation() {
        try {
          var isvalid = true;
          var ctrl;
          var s = 0;
          $('.required').each(function () {
            $(this).css('background', 'transparent');
            if ($(this).val() === '')
            {
              $(this).css('background', 'red');
              if (s == 0)
              {
                $(this).focus();
                s++;
              }
              isvalid = false;
            }
          });
          return isvalid;
        } catch (ex) {
          alert("Err" + ex);
        }
      }

      function changepass()
      {
        var pas = $('#pass').val();
        var cpas = $('#cpass').val();
        if (pas == "") {
          alert('password required');
          return false;
        }
        if (pas != cpas)
        {
          $('#pass').focus();
          alert('pass not match');
          return false;
        }
        $.post("./includefiles/DBconnect.php", {
          password: pas,
          tbl: 'user_tbl',
          method: 'update',
          username: $('#username').val(),
        }, function (response) {            
          if (response == 'UPDATED')
          {
            alert('Password Changed Sucessfully')
            location.reload(true); 
          }
          else
          {
            alert(response);
          }
        });
        return false;
      }

      function saveclick()
      {
        if (!validation())
        {
          return false;
        }
        $.post("./includefiles/DBconnect.php", {
          email: $('#email').val(),
          full_name: $('#full_name').val(),
          dob: $('#dob').val(),
          mobile: $('#mobile').val(),
          method: 'update',
          tbl: 'user_tbl',
          username: $('#username').val(),
        }, function (response) {
          alert(response);
        });
        location.reload(true); 
        return false;
      }

    </script>                  

    <?php
    require_once './includefiles/config.php';
    require_once './includefiles/user_info.php';
//    echo $user_type . "<br>";
//    echo $user . "<br>";
//    echo $fullname . "<br>";
//    echo $email . "<br>";
//    echo $mobile . "<br>";
    ?>
    <div class="container-fluid" >           
      <br><br><br><br><br><br><br>
      <div class="row">
        <div class="col-md-12">         
          <div class="col-md-4">                            
            <div class="widget-content myback" style="border-radius:20px">
              <div class="page-title" style="text-align :center;color: white">
                 <i class="fa fa-user"> 
                    <?php echo $user ?>  Profile
                  </i>  
                </div> 
              <hr>
              <div class="form-group">      
                <input type="hidden" value="<?php echo $user ?>" data-content='USERNAME'  id="username" placeholder="USERANME"  maxlength="30" />                                                                                                                
              </div>                
              <div class="form-group">                  
                <label for="email">EMAIL</label>
                <input type="text" value="<?php echo $email ?>" class=" required form-control" data-content='EMAIL' id="email" placeholder="EMAIL" maxlength="30" />								                                                                        
              </div>                                                                                                   
              <div class="form-group">                                      
                <label for="mobile">MOBILE</label>
                <input  type="text" value="<?php echo $mobile ?>" class=" required form-control"  data-content='MOBILE'  id="mobile" placeholder="MOBILE"  maxlength="30" />                                                                                                                
              </div>
              <div class="form-group">          
                <label for="full_name">FULL NAME</label>
                <input  type="text" value="<?php echo $fullname ?>" class=" required form-control"  data-content='FULL NAME'  id="full_name" placeholder="FULL NAME"  maxlength="30" />                                                                                                                
              </div>              
              <div class="form-group">    
                <label for="dob">DATE OF BIRTH</label>
                <input  type="date"  value="<?php echo $dob ?>" data-content='DATE OF BIRTH' class=" required form-control"  id="dob" placeholder="DATE OF BIRTH"  maxlength="30" />                                                                                                                
              </div>
              <div class="form-group">
                <div class="col-md-8"></div>
                <button type="submit" onclick="return saveclick()"  class="btn btn-info " >UPDATE</button>
              </div>     

            </div>
          </div>     
          <div class="col-md-2">  
            <!-- save image -->
            <!--
            <form action="<?php //echo $_SERVER['PHP_SELF']; ?>" method=post enctype="multipart/form-data" >
              <div class="form-group">
                <br>
                <input type=hidden name="MAX_FILE_SIZE" value="120000" />
                Choose image (Max_size 120KB)
                <input type="file" name="userfile"/>
                <div class="col-md-8"></div>
                <button name="imgsave" type="submit" class="btn btn-danger " >CHANGE</button>
              </div> 
            </form>
             <i class="glyphicon glyphicon-picture"> 
                <B>CURRENT PICTURE</B><br><br>
                  </i> 
            
            <img style="position: relative;height: 50%;width:100%;border-radius: 30px;" src="<?php //echo $dp_image; ?>" />
            -->        
            </div>
          <div class="col-md-4">                            
            <div class="widget-content myback" style="border-radius:20px">
              <div class="page-title" style="text-align :center;color: white">
                 <i class="fa fa-lock"> 
                change password
                  </i>  
                </div>                                    
              <hr>
              <div class="form-group">                                      
                <label for="mobile">NEW PASSWORD</label>
                <input  type="password" class="form-control"  data-content='PASSWORD'  id="pass" placeholder="PASSWORD"  maxlength="30" />                                                                                                                
              </div>
              <div class="form-group">          
                <label for="full_name">CONFORM PASSWORD</label>
                <input  type="password"  class=" form-control"  data-content='CONFORM PASSWORD'  id="cpass" placeholder="CONFORM PASSWORD"  maxlength="30" />                                                                                                                
              </div>
              <br>
              <div class="form-group">
                <div class="col-md-8"></div>
                <button type="submit" onclick="return changepass();"  class="btn btn-warning " >CHANGE</button>
              </div>            
            </div>
          </div>         
        </div>           
      </div>

    </div>
  </div>
  <div class="row">                                                                               
    <div class="col-md-2">
    </div>
    <div class="col-md-9">
    </div>
  </div>
  <?php
  /*
// Checking the file was submitted
  if (isset($_FILES['userfile'])) {
    try {
      $msg = upload(); // function  calling to upload an image
      echo "<script> alert('" . $msg . "'); </script>";
    } catch (Exception $e) {
      echo $e->getMessage();
      echo 'Sorry, Could not upload file';
    }
  }

  function upload1() {
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

  function file_upload_error_message1($error_code) {
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
  }*/
  ?>
  <?php
  include_once './includefiles/footer.php';
  ?>
</div>
</div>    
</body>
</html>
