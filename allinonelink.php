<html ng-app="allinoneapp">
    <head>
        <?php
        
        if ($_COOKIE['username'] == '') {
            header("Location:index.php");
        }
        include './includefiles/header.php';
        include './includefiles/nav_menu.php';
        ?>  
        <script src="allinonelink_ctrl.js" type="text/javascript"></script>
    <br><br><br><br>
    <style> 
        .table{
            color:#fff;
        }
        .table thead>tr>th, .table tbody>tr>th, .table tfoot>tr>th, .table thead>tr>td, .table tbody>tr>td, .table tfoot>tr>td {
            padding: 5px 10px!important;
        }
        td{
            vertical-align: middle!important;
        }
        .table thead>tr>th, .table tbody>tr>th, .table tfoot>tr>th, .table thead>tr>td, .table tbody>tr>td, .table tfoot>tr>td {
            padding: 5px 10px!important;
            line-height: 0;
            vertical-align: middle;
            /* border-top: 1px solid #ddd; */
            font-size: small;}
        </style>
        <title>All in One links</title>
    </head>
    <body ng-controller="allinonectrl"> 

        <table class="table table-bordered col-md-12" >
        <thead>
            <tr>
                <th colspan="6">Categorys</th>
                <th>
                    <button type="button" title="Add" ng-click="addCategory()" class="btn btn-success btn-circle">
                        <i class="glyphicon glyphicon-plus"></i>
                    </button>
                    <button type="button" title="Save" ng-click="savecategory()" class="btn btn-warning btn-circle">
                        <i class="glyphicon glyphicon-floppy-disk"></i>
                    </button>

                </th>
            </tr>
            <tr>
                <th  class="col-md-1">S.no</th>
                <th   class="col-md-2">Code</th>
                <th  class="col-md-2">Name</th>
                <th  class="col-md-1">Sequence</th>
                <th  class="col-md-3">Icon</th>
                <th  class="col-md-1">Active</th>
                <th  class="col-md-1">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="row in categoryData.data" ng-click="getLinks($index);"  ng-init="row.isEdit = false;row.table = 'link_category';(row.category_key == '' || row.category_key == null) ? row.method = 'insert' : row.method = 'update'" >
                </div>
                <td ng-class="(row.isSelected==true)?'highlight':''" >
                    {{$index + 1}}
                </td>
                <td ng-class="(row.isSelected==true)?'highlight':''" >
                    <input type="text" class="form-control" ng-model="row.category_code" ng-show="row.isEdit">
                    <span ng-show="!row.isEdit">{{row.category_code}} </span>
                </td>
                <td ng-class="(row.isSelected==true)?'highlight':''" >
                    <input type="text" class="form-control" ng-model="row.category_name" ng-show="row.isEdit">
                    <span ng-show="!row.isEdit">{{row.category_name}} </span>
                </td>                        
                <td ng-class="(row.isSelected==true)?'highlight':''" >
                    <input type="text" class="form-control " ng-model="row.category_order" ng-show="row.isEdit">
                    <span ng-show="!row.isEdit">{{row.category_order}} </span>
                </td>
                <td ng-class="(row.isSelected==true)?'highlight':''" >
                    <img style="float:left;width:10%" class="grid-img-data" src="data:image/png;base64,{{row.category_icon}}"  alt="Red dot" />
                    <input style="float:left;width:30%" type="file" accept="image/png"  onchange="angular.element(this).scope().fileChoosed(this, 1)" class="form-control width-25" ng-show="row.isEdit">
                    <textarea style="float:left;width:60%;" type="text" class="form-control " ng-model="row.category_icon" ng-show="row.isEdit"></textarea>
                </td>
                <td ng-class="(row.isSelected==true)?'highlight':''" >
                    <input type="checkbox" class="form-control" ng-model="row.is_active" ng-init="row.is_active = (row.is_active > 0 || row.is_active == null)" ng-disabled="!row.isEdit">
                </td>
                <td ng-class="(row.isSelected==true)?'highlight':''" >
                    <button type="button" title="Add" ng-show="!row.isEdit" ng-click="row.isEdit = true" class="btn btn-danger btn-circle">
                        <i class="glyphicon glyphicon-pencil">
                        </i>
                    </button>
                    <button type="button" title="Add"  ng-click="row.isEdit = false; savecategorySingle($index)" class="btn btn-danger btn-circle">
                        <i class="glyphicon glyphicon-floppy-disk">
                        </i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>    



    <table class="table table-bordered col-md-12" >
        <thead>
            <tr>
                <th colspan="6">Categorys</th>
                <th>
                    <button type="button" title="Add" ng-click="addCategory()" class="btn btn-success btn-circle">
                        <i class="glyphicon glyphicon-plus"></i>
                    </button>
                    <button type="button" title="Save" ng-click="savecategory()" class="btn btn-warning btn-circle">
                        <i class="glyphicon glyphicon-floppy-disk"></i>
                    </button>

                </th>
            </tr>
            <tr>
                <th  class="col-md-1">S.no</th>
                <th   class="col-md-2">Code</th>
                <th  class="col-md-2">Name</th>
                <th  class="col-md-1">Sequence</th>
                <th  class="col-md-3">Icon</th>
                <th  class="col-md-1">Active</th>
                <th  class="col-md-1">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="row in categoryData.data" ng-init="row.isEdit = false;row.table = 'link_category';(row.category_key == '' || row.category_key == null) ? row.method = 'insert' : row.method = 'update'" >

                </div>
                <td >
                    {{$index + 1}}
                </td>
                <td ng-class="(row.isSelected==true)?'highlight':''" >
                    <input type="text" class="form-control" ng-model="row.category_code" ng-show="row.isEdit">
                    <span ng-show="!row.isEdit">{{row.category_code}} </span>
                </td>
                <td ng-class="(row.isSelected==true)?'highlight':''" >
                    <input type="text" class="form-control" ng-model="row.category_name" ng-show="row.isEdit">
                    <span ng-show="!row.isEdit">{{row.category_name}} </span>
                </td>                        
                <td ng-class="(row.isSelected==true)?'highlight':''" >
                    <input type="text" class="form-control " ng-model="row.category_order" ng-show="row.isEdit">
                    <span ng-show="!row.isEdit">{{row.category_order}} </span>
                </td>
                <td ng-class="(row.isSelected==true)?'highlight':''" >
                    <img style="float:left;width:10%" class="grid-img-data" src="data:image/png;base64,{{row.category_icon}}"  alt="Red dot" />
                    <input style="float:left;width:30%" type="file" accept="image/png"  onchange="angular.element(this).scope().fileChoosed(this, 1)" class="form-control width-25" ng-show="row.isEdit">
                    <textarea style="float:left;width:60%;" type="text" class="form-control " ng-model="row.category_icon" ng-show="row.isEdit"></textarea>
                </td>
                <td ng-class="(row.isSelected==true)?'highlight':''" >
                    <input type="checkbox" class="form-control" ng-model="row.is_active" ng-init="row.is_active = (row.is_active > 0 || row.is_active == null)" ng-disabled="!row.isEdit">
                </td>
                <td ng-class="(row.isSelected==true)?'highlight':''" >
                    <button type="button" title="Add" ng-show="!row.isEdit" ng-click="row.isEdit = true" class="btn btn-danger btn-circle">
                        <i class="glyphicon glyphicon-pencil">
                        </i>
                    </button>
                    <button type="button" title="Add"  ng-click="row.isEdit = false; savecategorySingle($index)" class="btn btn-danger btn-circle">
                        <i class="glyphicon glyphicon-floppy-disk">
                        </i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>    

</body>
</html>

{{result}}
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<!--
<button type="button" class="btn btn-default btn-circle"><i class="glyphicon glyphicon-ok"></i></button>
<button type="button" class="btn btn-primary btn-circle"><i class="glyphicon glyphicon-list"></i></button>
<button type="button" class="btn btn-success btn-circle"><i class="glyphicon glyphicon-link"></i></button>
<button type="button" class="btn btn-info btn-circle"><i class="glyphicon glyphicon-ok"></i></button>
<button type="button" class="btn btn-warning btn-circle"><i class="glyphicon glyphicon-remove"></i></button>
<button type="button" class="btn btn-danger btn-circle"><i class="glyphicon glyphicon-heart"></i></button>

<h2>lg</h2>
<button type="button" class="btn btn-default btn-circle btn-lg"><i class="glyphicon glyphicon-ok"></i></button>
<button type="button" class="btn btn-primary btn-circle btn-lg"><i class="glyphicon glyphicon-list"></i></button>
<button type="button" class="btn btn-success btn-circle btn-lg"><i class="glyphicon glyphicon-link"></i></button>
<button type="button" class="btn btn-info btn-circle btn-lg"><i class="glyphicon glyphicon-ok"></i></button>
<button type="button" class="btn btn-warning btn-circle btn-lg"><i class="glyphicon glyphicon-remove"></i></button>
<button type="button" class="btn btn-danger btn-circle btn-lg"><i class="glyphicon glyphicon-heart"></i></button>

<h2>xl</h2>
<button type="button" class="btn btn-default btn-circle btn-xl"><i class="glyphicon glyphicon-ok"></i></button>
<button type="button" class="btn btn-primary btn-circle btn-xl"><i class="glyphicon glyphicon-list"></i></button>
<button type="button" class="btn btn-success btn-circle btn-xl"><i class="glyphicon glyphicon-link"></i></button>
<button type="button" class="btn btn-info btn-circle btn-xl"><i class="glyphicon glyphicon-ok"></i></button>
<button type="button" class="btn btn-warning btn-circle btn-xl"><i class="glyphicon glyphicon-remove"></i></button>
<button type="button" class="btn btn-danger btn-circle btn-xl"><i class="glyphicon glyphicon-heart"></i></button>-->
