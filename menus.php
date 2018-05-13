<html>        
  <head>        
    <title >
      Menu_tools
    </title>
    <?php
if ($_COOKIE['username']=='') {
      header("Location:index.php");
    }
    include './includefiles/bubbles.php';
    include './includefiles/header.php';
    ?>   
    <link href="css/mulidropstyle.css" rel="stylesheet" type="text/css"/>
    <script src="js/checkbox.js" type="text/javascript"></script>        
    <link href="css/checkbox.css" rel="stylesheet" type="text/css"/>
  </head>
  <body class="myback">   
    <?php
    include './includefiles/nav_menu.php';
    ?>    
    <script >
      function getusers()
      {
        var str = "";
        $('.upuser span').each(function () {
          str += $(this).text();
        });      
        return str;
      }      
      $(window).load(function () {
        $('.form-control').popover({trigger: 'focus'});
      });
      $(document).ready(function () {
        $('#active,#upactive').switchable();
      });
      function updatemenu()
      {
        var ativ = 0;
        if ($('#upactive').is(':checked'))
          ativ = 1;
        var usr=getusers();
        $.post("./includefiles/DBconnect.php", {
          Active: ativ,
          users:usr,
          tbl: 'dyn_menu_tbl',
          method: 'update',
          id: $('#menu_id').val(),
        }, function (response) {
          alert(response);
        });
        return false;
      }
      function saveclick() {
        var ativ = 0;
        if ($('#active').is(':checked'))
          ativ = 1;
             
        $.post("./includefiles/DBconnect.php", {
          menu_type: $('#menu_type').val(),
          Label: $('#label').val(),
          tbl: 'dyn_menu_tbl',
          method: 'insert',
          Link: $('#link').val(),
          Parant_id: $('#parant_id').val(),
          Active: ativ,          
        }, function (response) {
          alert(response);
        });
        return false;
      }
      function loadparant(str)
      {
        //alert(str);
        var myval = " <div class='form-group'><input type='text' id='parant_id' placeholder='parant_id' data-content='parant_id' name='parant_id' class='form-control required' /></div>   ";
        if (str == 'Main')
        {
          $('#parant_ctrl').hide();
          $('#parant_ctrl').html(myval);
        } else
        {
          var sql = "select id as k,label as v  from dyn_menu_tbl where menu_type = 'main'";
          $.post("./includefiles/loaddrop.php", {
            id: 'parant_id',
            query: sql,
            class: 'form-control required',
            name: 'parant_id',
          }, function (response) {
            //                               $('#myval').html(response));                                                        
            $('#parant_ctrl').show();
            document.getElementById('parant_ctrl').innerHTML = response;
          });
          //$('#parant_ctrl').html('myval');
          return true;
        }
      }
      function deltemenu()
      {
         var ativ = 0;
        if ($('#upactive').is(':checked'))
          ativ = 1;
        var usr=getusers();
        $.post("./includefiles/DBconnect.php", {          
          tbl: 'dyn_menu_tbl',
          method: 'delete',
          id: $('#menu_id').val(),
        }, function (response) {
          alert(response);
        });
        return false;
      }
      function loadupdatemenu(str)
      {
        //  alert(str);
        var sql = "select id as k,label as v  from dyn_menu_tbl where menu_type = '" + str + "'";
        $.post("./includefiles/loaddrop.php", {
          id: 'menu_id',
          query: sql,
          class: 'form-control required',
          data_content: 'MENU NAME',
          name: 'menu_id',
        }, function (response) {
          //                               $('#myval').html(response));                                                        
          $('#menu_update').show();
          document.getElementById('menu_update').innerHTML = response;
        });
        //$('#parant_ctrl').html('myval');
        return false;
      }
    </script>          
    <div class="content homepage ">                            
      <div class="container" >    
        <form method="post" > 
          <br><br><br><br><br><br>
          <div class="row">                    
            <div class="col-md-4">                            
              <div class="widget-content  myback" style="border-radius:20px">
                <div class="page-title" style="text-align :center;color: white">                                        
                  <i class="fa fa-users"> 
                    Menus Creation    
                  </i>                                            
                </div>
                <br><br>
                <div class="form-group">                                                
                  <Select id="menu_type" data-content="MENU TYPE" onchange="return loadparant(this.value)" class="required form-control" name="menu_type"/>   
                  <option value="" > MENU TYPE</option>
                  <option value="Main" >MAIN MENU</option>
                  <option value="Sub" >SUB MENU</option>
                  </select>
                </div>
                <div class="form-group">
                  <input type="text" id="label" placeholder="LABEL" data-content="LABEL" name="label" class="form-control required" />                                                                                
                </div>                                            
                <div class="form-group">
                  <input type="text" id="link" placeholder="LINK" data-content="LINK" name="link" class="form-control required" />                                                                                
                </div>                                       
                <div id="parant_ctrl">
                  <div class="form-group">
                    <input type="text" id="parant_id" placeholder="PARANT LINK" data-content="PARANT LINK" name="parant_id" class="form-control required" />                                                                                
                  </div>                                            
                </div>                    
                <div class="form-group">
                    <!--<p style="float:left;">Active</p>-->
                  <input type="checkbox" data-label="Active" id="active" name="active"  />                                                                                
                </div>    
                <div class="form-group">
                  <div class="col-md-2"></div>                                                                            
                  <button  type="button" name="btnsave"  onclick="return saveclick()" class="btn  btn-info"  >SAVE  </button>                                    
                </div>
              </div>                                    
            </div>                    
            <div class="col-md-4">                            
              <div class="widget-content  myback" style="border-radius:20px">
                <div class="page-title" style="text-align :center;color: white">                                        
                  <i class="fa fa-user"> 
                    Menu Active    
                  </i>                                           
                </div>
                <br> <br>

                <div class="form-group">                                                
                  <Select id="menu_active" data-contEnt="MENU TYPE" onchange="return loadupdatemenu(this.value)" class="required form-control" name="menu_active"/>                                                                                                                                                                                                    
                  <option value="" > MENU TYPE</option>
                  <option value="Main" >MAIN MENU</option>
                  <option value="Sub" >SUB MENU</option>
                  </select>
                </div>                               
                <div id="menu_update">
                  <div class="form-group">
                    <input type="text" id="parant_id" placeholder="PARANT ID" data-content="PARANT ID" name="parant_id" class="form-control required" />                                                                                
                  </div>    
                </div>
                  <div class="form-group">
                  <dl class="dropdown form-control" style="text-align: left;"> 
                    <dt  >
                      <a href="#">
                        <span class="hida">Select</span>    
                        <p class="multiSel upuser"></p>  
                      </a>
                    </dt>  
                    <dd>
                      <div class="mutliSelect  dropdown" >
                        <ul>
                          <li>
                            <input type="checkbox" id="all" value="all" /> ALL</li>  
                          <li class="check">
                            <input type="checkbox" value="TSTAFF" /> TEACHING STAFF</li>
                          <li class="check">
                            <input type="checkbox" value="NSTAFF" /> NON TEACHING STAFF</li>
                          <li class="check">
                            <input type="checkbox" value="STUDENT" /> STUDENTS </li>                         
                        </ul>
                      </div>
                    </dd>  
                  </dl>
                </div>
                <div class="form-group">
                    <!--<p style="float:left;">Active</p>-->
                  <input type="checkbox" id="upactive" data-label="Active"name="active"/>                                                                                
                </div>  
                <div class="form-group">
                
                  <button  type="button" name="btnupdate" onclick="return updatemenu()" class="btn  btn-info"  >UPDATE</button>                                    
                
                  <button  type="button" name="btnupdate" onclick="return deltemenu()" class="btn  btn-danger"  >DELETE</button>                                    
                </div>
           
              </div>                                    
            </div>
          </div>
        </form>
        <?php
        // include_once './includefiles/bubbles.php';
        include_once './includefiles/footer.php';
        ?>
      </div>
    </div>    
    <script src="jquery/multidropdown.js"></script>
  </body>
</html>



