<html>
    <head>

<?php
 include './includefiles/headerkadambur.php';
?>
        <title>Kadambur user activation</title>
        <script>
//            var Dbconnect = "./includefiles/DBkadambur.php";
            var Dbconnect =  "http://eskutti.eu5.org/includefiles/DBkadambur.php";
           // $(".check").switchable();

            function search()
            {
                var search_val = $('#searchtxt').val();
                if (search_val != "") {
                    str_query = "select id,full_name,mobile,email,user_type,address,active from user_tbl where Full_name like '%" + search_val + "%'";
                    str_query += " or email like '%" + search_val + "%' or mobile like '%" + search_val + "%'";
                    $.post(Dbconnect, {
                        method: 'json',
                        query: str_query,
                    }, function (response) {
                        $('#tbl').text('');
                        var mydata = eval(response);
                        var table = $.makeTable(mydata);
                        $(table).appendTo("#tbl");

                    });
                }
            }
            function view(str)
            {
                if (str == "")
                    str = "1 or active=0";
                str_query = "select id,full_name,mobile,email,user_type,address,active from user_tbl where  active=" + str;
                $.post(Dbconnect, {
                    method: 'json',
                    query: str_query,
                }, function (response) {
                    $('#tbl').text('');
                    var mydata = eval(response);
                    var table = $.makeTable(mydata);
                    $(table).appendTo("#tbl");
                  //  $(".check").switchable();
                });
            }
            $.makeTable = function (mydata) {
                var table = $('<table border=1 class="table table-hover">');
                var tblHeader = "<tr>";
                var check_id = "";
                var check_val = "";
                for (var k in mydata[0])
                    tblHeader += "<th>" + k + "</th>";
                tblHeader += "<th>Status</th></tr>";
                $(tblHeader).appendTo(table);
                $.each(mydata, function (index, value) {
                    var TableRow = "<tr>";
                    $.each(value, function (key, val) {
                        if (key == "id")
                        {
                            check_id = val;
                        }
                        TableRow += "<td>" + val + "</td>";
                        check_val = (val == 1) ? 'checked' : '';
                    });
                    //alert(check_id);
                    TableRow += "<td><input type='checkbox' class='check'  onclick='check(this);' id='" + check_id + "'" + check_val + "/></td>"
                    TableRow += "</tr>";
                    $(table).append(TableRow);
                });
                return ($(table));
            };

            function check(str)
            {
                var ativ = 0;
                if ($(str).is(':checked'))
                    ativ = 1;
                $.post(Dbconnect, {
                    active: ativ,
                    method: 'update',
                    tbl: 'user_tbl',
                    id: $(str).prop('id')
                }, function (response) {
                    alert(response);
                });
            }
        </script>
    </head>
    <body><br><br><br><br>        
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">                        
                        <div class="col-md-3">
                            <label for="user_state">Status</label>
                        </div>
                        <div class="col-md-9">
                            <select name="user_state" id="user_state" onchange="view(this.value);" class="form-control">
                                <option value="">all</option>
                                <option value="true">active</option>
                                <option value="false">in-active</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">                        
                        <div class="col-md-9">
                            <input type="text" id="searchtxt" class="form-control text-center" placeholder="search" >
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-danger" onclick="search()">search</button>
                        </div>
                    </div>

                </div>
                <br><br><br><br><br><br>
                <dic id="tbl">

                </dic>
            </div>

        </div>
    </body>
</html>