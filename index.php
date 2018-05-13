<html>            
  <head>   
    <title>            
      LOGIN
    </title>
    <?php
    if (isset($_COOKIE['username'])) {
      $_COOKIE['username'] = "";
    }
    include './includefiles/header.php';    
    include './includefiles/nav_menu.php';
    ?>   
    <script>
      $(document).ready(function () {
        document.cookie = "username=";
      });
    </script>
  </head>
  <body class="myback">                
    <script  type="text/javascript">
      $.ajaxSetup({async: false});
      $(window).load(function () {
        $('.form-control').popover({trigger: 'focus'});
      });
      function lgvalidation()
      {
        var isvalid = true, s = 0;
        $('.lgrequired').each(function () {
          if ($(this).val() === '') {
            $(this).addClass("text-danger");
            if (s == 0)
            {
              this.focus();
              s++;
            }
            isvalid = false;
          }
        });
        return isvalid;
      }

      function login() {
        if (!lgvalidation())
        {
          return false;
        }
        var username = $('#username').val(), password = $('#password').val();
       /* if (username == "eskutti" && password == "amlegand")
        {
          //document.cookie = "username=" + username;
        //  window.location.href = "home.php";
        }else*/
        {
        $.post("./includefiles/DBconnect.php", {
          tbl: 'user_tbl',
          username: username,
          password: password,
          method: 'count',
          active: 1,
        }, function (response) {
          if (response > 0)
          {
            sessionStorage['username'] = username;
            document.cookie = "username=" + username;
            window.location.href = "home.php";
          } else
          {
            alert('username/password is invalid' + response);
          }
        });
    }
        return false;
      }
      function sendpassword()
      {
        $.post("./includefiles/DBconnect.php", {
          subject: 'NEW PASSWORD FROM MYSXC',
          msg: 'your new password is ',
          from: 'echempu.kutti@gmai.com',
          method: 'mail',
          to: $('#rec_mail').val(),
        }, function (response) {
          alert(response);
        }
        );
      }



         function validation() {
                try {
                    var isvalid = true;
                    var ctrl;
                    var s = 0;
                    $('.required').each(function () {                        
                        if ($(this).val() === '')
                        {
                            $(this).addClass("btn-danger");
                            if (s == 0)
                            {
                                $(this).focus();
                                s++;
                            }
                            isvalid = false;
                        }
                        else
                        {
                            $(this).removeClass("btn-danger");
                        }
                    });
                    return isvalid;
                } catch (ex) {
                    alert("Err" + ex);
                }
            }
            function saveclick()
            {active=0;
                if (!validation())
                {
                    return false;
                }
                if (!user_avail())
                    return false;
                  var pass=Math.random().toString(32).substr(1, 10);
                  var f=false;
                  var s=$('#user_type').val();
                  if(s=='STUDENT'){active=1;}
                $.post("./includefiles/DBconnect.php", {
                    username: $('#username').val(),
                    password: pass,
                    email: $('#email').val(),
                    user_type: $('#user_type').val(),                    
                    tbl: 'user_tbl',
                    active:active,
                    mobile: $('#mobile').val(),
                    method: 'insert',
                }, function (response) {
                    if (response == 'SAVED'){
                        alert('Record saved and your password is sent to your mail id or mobile');
                        window.location.href = "index.php";
                        f=true; 
                      }                                           
                    else if (response == "UPDATED"){
                        alert('Details updated');f=false;}
                      
                    else{
                        alert(response+'failed');f=false;}                      
                });
                if(f)
                {
                  //send sms to the user      
                         $.post("./includefiles/DBconnect.php", {
                    userid:'8012713034',
                    password: 'amlegand',
                    to: $('#mobile').val(),
                    msg: 'You login pass word is '+pass,                    
                    method: 'sms'
                }, function (response) {
                  alert(response);
                });                   
                }
                else
                {//send sms to the user      
                         $.post("./includefiles/DBconnect.php", {
                    userid:'8012713034',
                    password: 'amlegand',
                    to: $('#mobile').val(),
                    msg: 'register failed try after sometime',                    
                    method: 'sms'
                }, function (response) {
                  alert(response);
                });                   
                }
                return false;
            }           
            function user_avail()
            {
                var flag = true;
                $.post("./includefiles/DBconnect.php", {
                    tbl: 'user_tbl',
                    method: 'count',
                    username: $('#username').val(),
                }, function (response) {
                    if (response > 0)
                    {
//                      alert(response);
                        $('#username').css('background', 'red');
                        alert('username is not availdable');
                        flag = false;
                    }
                });
                return flag;
            }
    </script>  
    <form method="post" >    
      <div class="login-wrap">
        <div class="login-html">
          <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Sign In</label>
          <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Sign Up</label>
          <div class="login-form">
            <div class="sign-in-htm">
              <br>
              
              
              
              <div class="form-group">
              
                
                <div class="inner-addon left-addon">
                  <i class="glyphicon glyphicon-user" >                                                        
                  </i>                                            
                  <input type="text" id="username" data-contant="Username" data-content="Username" class="lgrequired form-control" name="username" placeholder="Username"  maxlength="30" required/>                                                                                                                                                                
                </div>

              </div>
              <div class="form-group">
                
                <div class="inner-addon left-addon">    
                          <i class="fa fa-lock">  </i>
                          <input type="password" id="password" placeholder="password" data-content="password" name="password" class="form-control lgrequired" />                                            
                        </div>
                      
              </div>
              <div class="group">
                <input id="check" type="checkbox" class="check" checked>
                <label for="check"><span class="icon"></span> Keep me Signed in</label>
              </div>
              <div class="group">                
                <button  type="submit" name="btn" onclick="return login()" class="button btn  btn-info" value="Login" >Sign In</button>
              </div>
              
              <div class="foot-lnk">                
                <a class="btn btn-link" data-toggle="modal" data-target="#myModal" > Forgot Password?</a>                        
              </div>
            </div>
            <div class="sign-up-htm">
              <br>               
              <div class="form-group">
                       <input type="text" class="required form-control  " data-content='USERNAME'  id="username" placeholder="USERANME"  maxlength="30" />                                                                                                                                             
              </div>
              <div class="form-group">
                       <input type="text" class=" required form-control" data-content='EMAIL' id="email" placeholder="EMAIL" maxlength="30" />								                                                                        
              </div>
              <div class="form-group">
                <input  type="text" class=" required form-control"  data-content='MOBILE'  id="mobile" placeholder="MOBILE"  maxlength="30" />                                                                                                                
              </div>
               <div class="form-group">
                                    <select id="user_type" data-content='USER TYPE'  data-live-search="true" class=" required btn-default form-control  ">
                                      <option  value="" >USER TYPE</option>                                            
                                        <option value="TSTAFF" >TEACHING STAFF</option>                                            
                                        <option value="NSTAFF" >NON TECHACHING STAFF</option>                                            
                                        <option value="STUDENT" >STUDENT</option>                                                                                        
                                    </select>	
                 
                 
                                </div>
              <div class="group">
                <button type="button" onclick="return saveclick()"  class="button btn " >Signup</button>
              </div>
              <div class="foot-lnk">
                <a>
                <label for="tab-1">Already Member?</label></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <link href="css/login.css" rel="stylesheet" type="text/css"/>
    </div>
  </div>
  <div class="row">                                                                               
 <style>
.modal-dialog
{
    width:39%;
}
</style>-->       
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">                                
      <div class="modal-dialog ">                                    
        <div class="modal-content "  style="border-radius: 20px; text-align: center;background: #0078a3;" >
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="flase" style="color:red;">&times; 
            </button>
            <h4 class="modal-title">
              <div class="page-title" style="color:white">   Forget Password</div>
            </h4>
          </div>
          <div class="modal-body">          
            <div class="col-md-8">
            <div class="form-group">
              <div class="inner-addon left-addon">
                <i class="glyphicon glyphicon-apple">  </i>
                <input type="text" id="rec_mail"  name="password" class="form-control" placeholder="Recovery Email" maxlength="30" required/>								                                                                        
              </div>
            </div>                                                                                        
            </div>
                  <button type="button" onclick="sendpassword()" class="btn btn-info">Send Password</button>
          </div>
          <div cla ss="modal-footer" style="border:none;">
<!--            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>-->
      
          </div>
          <br>
        </div>
      </div>
    </div>
  </div>
  <?php

  include_once './includefiles/footer.php';
  ?>
</div>
</div>    
</form>
</body>
</html>
