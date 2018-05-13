<html>
    <head>

    </title>
    <?php
        if ($_COOKIE['username']=='') {
      header("Location:index.php");
    }

    include './includefiles/header.php';
    include './includefiles/nav_menu.php';
    ?>   
    <title>Tutorial</title>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <script>
        var tutorial_key = "";
        var Dbconnect = "includefiles/DBconnect.php";
        function set_key(str)
        {
            debugger;
            str.cells[0]
            //var Cells = str.getElementsByTagName("td");
            tutorial_key = str.cells[0].innerHTML;
            $('#txt_sub_title').val(str.cells[2].innerHTML);
            $('#txt_sub_title_name').val(str.cells[3].innerHTML);
            $('#txt_content').val(str.cells[4].innerHTML);
            $('#txt_example').val(str.cells[5].innerHTML);
            $('#txt_example_detail').val(str.cells[6].innerHTML);
        }
        function validation(clas)
        {
            var f = true;
            $('.' + clas).each(function ()
            {
                if ($(this).val() == "")
                {
                    f = false;
                    $(this).focus();
                    return f;
                }
            });
            return f;
        }
        function save_click()
        {
            var str = "";
            var f = validation("required");
            if (!f) {
                return false;
            }
            if (tutorial_key != "") {
                $.post(Dbconnect, {
                    title_code: $('#sel_tutorial_title').val(),
                    sub_title: $('#txt_sub_title').val(),
                    sub_title_name: $('#txt_sub_title_name').val(),
                    content: $('#txt_content').val(),
                    example: $('#txt_example').val(),
                    example_detail: $('#txt_example_detail').val(),
                    tbl: 'tutorial_tbl',
                    method: 'update',
                    tutorial_key: tutorial_key
                }, function (response) {
                    alert(response);
                    $('.required').val("");
                    tutorial_key = "";
                });
            } else
            {
                // alert('inser');
                $.post(Dbconnect, {
                    title_code: $('#sel_tutorial_title').val(),
                    sub_title: $('#txt_sub_title').val(),
                    sub_title_name: $('#txt_sub_title_name').val(),
                    content: $('#txt_content').val(),
                    example: $('#txt_example').val(),
                    example_detail: $('#txt_example_detail').val(),
                    tutorial_type: $('#tutorial_type').val(),
                    tbl: 'tutorial_tbl',
                    method: 'insert',
                }, function (response) {
                    alert(response);
                    $('.required').val("");
                });
            }
            return false;
        }
        function view(str_1)
        {
            str_query = "select tutorial_key as 'ID',tt.title_code as 'TITLE',sub_title  as 'SUB TITLE',";
            str_query += "sub_title_name,content as 'Content',example as 'Example',example_detail as 'Example Detail' from tutorial_tbl tt\n\
                               inner join tutorial_title_tbl ttt on tt.title_code=ttt.title_code \n\
                                inner join tutorial_type ty on ty.tutorial_code =ttt.tutorial_code";
            if (str_1 != "") {
                str_query += " where tt.title_code='" + str_1 + "'";
            }
            // alert(str_query);
            $.post(Dbconnect, {
                method: 'json',
                query: str_query,
            }, function (response) {
                //  alert(response);
                $('#tbl').text('');
                var mydata = eval(response);
                var table = $.makeTable(mydata);
                $(table).appendTo("#tbl");

            });
            return false;
        }
        $.makeTable = function (mydata) {
            var table = $('<table class="table table-bordered table-hover table-condensed">');
            var tblHeader = " <thead><tr>";
            for (var k in mydata[0])
                tblHeader += "<th>" + k + "</th>";
            tblHeader += "</thead>";
            $(tblHeader).appendTo(table);
            $.each(mydata, function (index, value) {
                var TableRow = "<tr onclick='set_key(this)' >";
                $.each(value, function (key, val) {
                    TableRow += "<td >" + val + "</td>";
                });
                TableRow += "</tr>";
                $(table).append(TableRow);
            });
            return ($(table));
        };
        function PageLoad()
        {
            alert('s');
        }
        function save_title()
        {
            var f = validation("tuttitle");
            if (!f)
                return false;
            $.post(Dbconnect, {
                tutorial_code: $('#sel_tutorial_type').val(),
                title_code: $('#sel_tutorial_type').val() + "-" + $('#txt_title_code').val(),
                title: $('#txt_title').val(),
                title_name: $('#txt_title_name').val(),
                method: 'insert',
                tbl: 'tutorial_title_tbl',
            }, function (response) {
                alert(response);
                $('.tuttitle').val("");
            });
        }
        function save_tut()
        {
            var f = validation("tuttype");
            if (!f)
                return false;
            $.post(Dbconnect, {
                tutorial_code: $('#txt_tutorial_code').val(),
                tutorial_name: $('#txt_tutorial_name').val(),
                method: 'insert',
                tbl: 'tutorial_type',
            }, function (response) {
                alert(response);
                $('.tuttype').val("");
            });
            loaddropdown('tutorial_code', 'tutorial_name', 'tutorial_type', 'sel_tutorial_type');
            loaddropdown('tutorial_code', 'tutorial_name', 'tutorial_type', 'sel_tutorial_type_2');
            return false;
        }
        function execute_query()
        {
            $.post(Dbconnect, {
                method: 'query',
                query: $('#txt_query').val(),
            }, function (response) {
                alert(response);
            });
        }
    </script>
</head>
<body style="color:white;">        <br><br>     
    <form class="form-horizontal" >
        <div class="container-fluid">            
            <div class="row">
                <div class="container" style='padding:10px' >
                    <b>Tutorial Entry</b>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">                
                    <div class="col-md-6 shadow">
                        <fieldset>   
                            <div class="form-group">                                  
                                <div class="col-md-2"></div>
                                <div class="col-md-5">
                                    <select id="sel_tutorial_type_2"  class="form-control">                                        
                                        <option value="">CHOOSE OPTION</option>             
                                    </select>
                                </div>                                 
                                <div class="col-md-5">
                                    <select id="sel_tutorial_title" onchange="return view(this.value);" class="form-control required">                                        
                                        <option value="">CHOOSE OPTION</option>                                                
                                    </select>
                                </div>

                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="name">Sub Title</label>  
                                <div class="col-md-10">
                                    <input id="txt_sub_title" type="text" placeholder="Enter SubTitle" class="form-control input-md required" >
                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="email">Sub Title name</label>  
                                <div class="col-md-10">
                                    <input id="txt_sub_title_name" type="text" placeholder="Enter SubTitle" class="form-control input-md required" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="street">Content</label>  
                                <div class="col-md-10">
                                    <textarea style="height: 15%;" id="txt_content" type="text" class="form-control input-md required" >
                                    </textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="street">Example</label>  
                                <div class="col-md-10">
                                    <textarea style="height: 20%;" id="txt_example" type="text" class="form-control input-md required" >
                                    </textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="street">Example Details</label>  
                                <div class="col-md-10">
                                    <textarea style="height: 10%;" id="txt_example_detail" type="text" class="form-control input-md required" >
                                    </textarea>
                                </div>
                            </div>
                            <!-- Button -->
                            <div class="form-group">
                                <label class="col-md-10 control-label" for=""></label>
                                <div class="col-md-2">
                                    <button  onclick="return save_click()" class="btn btn-success">Save</button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-5 shadow" >                      
                        <div  data- style="height:79%;overflow:auto; ">
                            <div class="container">
                                <div class="panel panel-default trans">
                                    <div class="panel-heading">
                                        <div class="form-inline" style="float:left">
                            <button onclick="return showpop_cat();" class="btn btn-sm btn-danger">New </button>
                        </div>
                                         click any row to edit
                                    </div>
                                    <div class="" id="tbl">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="modal_cat" class="modal fade ">
                <div class="modal-dialog" style="width:80%;">
                    <div class="modal-content ">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">
                                <i class="glyphicon glyphicon-picture">                                     
                                </i>                  
                                Create tutorial and title
                        </div>
                        <div class="modal-body" >
                            <div class="row">
                                <div class="container-fluid">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="street">Tutorial code</label>  
                                            <div class="col-md-8">
                                                <input id="txt_tutorial_code" type="text" class="form-control input-md tuttype" >                                                
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="street">Tutorial name</label>  
                                            <div class="col-md-8">
                                                <input id="txt_tutorial_name" type="text" class="form-control input-md tuttype" >                                                
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8"></div>
                                            <button  type="button" onclick="return save_tut();" class="btn btn-success" >save</button>
                                        </div>

                                        <div class="form-group">                                           
                                            <div class="col-md-12">
                                                <textarea id="txt_query" style="height:20%;overflow:auto; " type="text" class="form-control input-md tuttype" >
                                                </textarea>
                                            </div>

                                        </div>                                      
                                        <button  type="button" onclick="return execute_query();" class="btn btn-danger" >execute</button>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">                                
                                            <label class="col-md-4 control-label" for="street">choose tutorial</label>  
                                            <div class="col-md-8">
                                                <select id="sel_tutorial_type"   class="form-control tuttitle">                                                    
                                                    <option value="">choose tutorial</option>                                                                                                              
                                                </select></div>
                                        </div>  
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="street">Title code</label>  
                                            <div class="col-md-8">
                                                <input id="txt_title_code" type="text" class="form-control input-md tuttitle" >                                                
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="street">Title</label>  
                                            <div class="col-md-8">
                                                <input id="txt_title" type="text" class="form-control input-md tuttitle" >                                                
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="street">Title name</label>  
                                            <div class="col-md-8">
                                                <input id="txt_title_name" type="text" class="form-control input-md tuttitle" >                                                
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8"></div>
                                            <button type="button" onclick="return save_title()" class="btn btn-success" >save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>                     
                            <div class="modal-footer">
                                <!--
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                  <button type="button" class="btn btn-primary">Save changes</button>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function showpop_cat() {
                $("#modal_cat").modal('show');
                return false;
            }
            $(document).ready(function ()
            {
                loaddropdown('tutorial_code', 'tutorial_name', 'tutorial_type', 'sel_tutorial_type');
                loaddropdown('tutorial_code', 'tutorial_name', 'tutorial_type', 'sel_tutorial_type_2');
            });
            $('#sel_tutorial_type_2').change(function ()
            {
                var tbl = "tutorial_title_tbl where tutorial_code='" + $('#sel_tutorial_type_2').val() + "'";
                loaddropdown('title_code', 'title', tbl, 'sel_tutorial_title');
            });

            function loaddropdown(dropkey, dropvalue, tbl_condition, controlid)
            {
                var options = "";
                str_query = "select " + dropkey + "," + dropvalue + " from " + tbl_condition;
                $.post(Dbconnect, {
                    method: 'json',
                    query: str_query,
                }, function (response) {
                    var resdata = JSON.parse(response);
                    for (var i = 0; i < resdata.length; i++) {
                        //alert(resdata[i]["cal_date"]);
                        var key = resdata[i][dropkey];
                        var value = resdata[i][dropvalue];
                        options += "<option value='" + key + "'>" + value + "</option>";
                    }
                    $('#' + controlid).html("<option value=''>CHOOSE OPTION</option>" + options);
                });
            }
        </script>  
</body>
</html>