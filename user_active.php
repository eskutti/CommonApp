<html>            
  <link href="css/login.css" rel="stylesheet" type="text/css"/>

  <head>        
    <title>            
      User_active 
    </title>
    <?php
 if ($_COOKIE['username']=='') {  
      header("Location:index.php");
    }
    include './includefiles/header.php';
    include './includefiles/bubbles.php';
    include './includefiles/nav_menu.php';
    ?>      
    <link href="css/checkbox.css" rel="stylesheet" type="text/css"/>
    <script src="js/checkbox.js" type="text/javascript"></script>        
  </head>
  <body class="myback">   
    <script type = "text/javascript" >

      $(document).ready(function () {
        $('#active').switchable();
      });
      function userstate()
      {
        var ativ = 0;
        if ($('#active').is(':checked'))
          ativ = 1;
        $.post("./includefiles/DBconnect.php", {
          Active: ativ,
          tbl: 'user_tbl',
          method: 'update',
          id: $('#user_code').val(),
        }, function (response) {
          alert(response);
        });
        return false;
      }
      function delete_user()
      {
         $.post("./includefiles/DBconnect.php", {          
          tbl: 'user_tbl',
          method: 'delete',
          id: $('#user_code').val(),
        }, function (response) {
          alert(response);
        });
        return false;
      }

      $.ajaxSetup({async: false});
      $(document).ready(function () {
        $("table").fixMe();
      });
    </script>      
    <div class="content homepage">                            
      <div class="container" >           
        <form method="post" >                                   
<br><br>   <br><br>   
          <div class="row"><br><br>                  
            <div class="col-md-12">         
              <div class="col-md-6">                                                            
                <div class="col-md-6">                            
                  <div class="form-group">                                        
                    <select id="user_typ" name="user_type" class="form-control required">                                            
                      <option value="" >select user type</option>                                            
                      <option value="tstaff" >TEACHING STAFF</option>                                            
                      <option value="nstaff" >NON TEACHING STAFF</option>                                            
                      <option value="student" >STUDENTS</option>                                                                                        
                    </select>	
                  </div>
                </div>
                <div class="col-md-6">                            
                  <div class="form-group">                                        
                    <button name="btnclick"   type="submit" class="btn btn-success">View</button>                                        
                  </div>                                
                </div>                            
              </div>
              <div class="col-md-4">                            
                <div class="widget-content  myback" style="border-radius:20px">
                  <div class="page-title" style="text-align :center;color: white">                                        
                    <i class="fa fa-users"> 
                   USER ACTIVATION
                    </i>          
                    <hr>
                  </div>
                  <br>                                     
                  <div id="parant_ctrl">
                    <div class="form-group">
                      <input type="text" id="user_code" placeholder="user_code" data-content="parant_id" name="parant_id" class="form-control required" />                                                                                
                    </div>                                            
                  </div>                                
                  <div class="form-group">
                      <!--<div class="col-md-3"><p style="float:left;">Active</p></div>-->                                        
                    <input type="checkbox" id="active" name="active" value="checked" data-label="Active"/>                                                                                                                        
                    <button  type="button" name="btnsave" onclick="return userstate()" class="btn  btn-info"  >Save</button>                                    
                    <button  type="button" name="btndelete" onclick="return delete_user()" class="btn  btn-danger"  >delete</button>                                    
                  </div>    
                </div>                                    
              </div>  
            </div>
          </div>
          <div class="row">                                     
            <br><br>                                
              <?php
              
              require_once 'includefiles/config.php';
              if ($_POST) {
                $sql = "select * from user_tbl where user_type= '" . $_POST['user_type'] . "'";
                ?>
            <div class="widget-content" style='background:  rgba(255, 255, 255, 0.15); border-radius: 50px;'>                            
                <table width="100%"  class="table-bordered">
                  <tr><th>S.NO</th><th>user_code</th><th>UserName</th><th>Mobile</th><th>Email</th><th>Status</th>
                  </tr>                        
                  <?php
                  $res = $con->query($sql) or exit(mysql_errno());
                  $count = 1;
                  $results = mysqli_query($con, $sql);
                  while ($rs = mysqli_fetch_assoc(@$results)) {
                    // while ($rs = $res->fetch()) {
                    ?>
                    <tr >                                                
                      <td><?php echo $count++ ?></td>              
                      <td><?php echo $rs['id'] ?></td>              
                      <td><?php echo $rs['username'] ?></td>              
                      <td><?php echo $rs['mobile'] ?></td>                
                      <td><?php echo $rs['email'] ?></td>                
                      <td><?php echo $rs['active'] ?></td>                                                                    
                    </tr>
                    <?php
                  }//whilte
                }
                ?>
              </table>                                

            </div>
          </div>                        
        </form>
        <?php
        // include_once './includefiles/bubbles.php';
        include_once './includefiles/footer.php';
        ?>
      </div>
    </div>    
  </div>
</body>
</html>



