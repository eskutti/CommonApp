/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var obj_current = null;
var app = angular.module('allinoneapp', []);
app.controller('allinonectrl', function ($scope, $http) {
    $scope.requestURL = "includefiles/DBHelper.php";
    $scope.categoryData = [];
    angular.element(document).ready(function () {
        $scope.getCategoryData();
    });
    $scope.addCategory = function () {
        $scope.categoryData.data.push({"category_key":"", "category_name":"", "category_code":"", "category_icon":"", "category_order":"", "is_active":""});
    }
    $scope.getCategoryData = function () {
        var request = {};
        request.query = 'select category_key,category_name,category_code,category_icon,category_order,is_active from link_category';
        request.method = 'json';
        $scope.postRequest(request).then(function (res) {
            if (res == "")
                res = "[]";
            $scope.categoryData = {
                "fields":
                        ["category_key", "category_name", "category_code", "category_icon", "category_order", "is_active"],
                table: "link_category",
                primaryColumn: "category_key",
                method: "saveData",
                data: eval(res)
            }
            $scope.$apply();
        });
    }

    $scope.savecategory = function () {
        var jsonstr = angular.toJson($scope.categoryData);
        //var jsonstr=angular.toJson($scope.categoryData.data[index]);
        $scope.postRequest(JSON.parse(jsonstr)).then(function (res) {
            alert(eval(res.trim()));
        });
    }
    $scope.getLinks = function(index){
        $scope.categoryData.data[index].isSelected=true;
        alert($scope.categoryData.data[index].category_code);
    }
    $scope.postRequest = function (requestData) {
        return $.post($scope.requestURL, {'requestData': requestData}, function (response) {
            return response;
        });
//                return $http.post($scope.requestURL, requestData).then(function (response) {
//                    return response.data;
//                });
    }

    $scope.fileChoosed = function (obj, index) {
        if (obj.files[0].size > 60000) {
            alert("File size should be within 50kb")
            return;
        }
        obj_current = obj;
        var reader = new FileReader();
        reader.readAsDataURL(obj.files[0]);
        reader.onload = function () {
            $(obj_current).next().val(reader.result.replace('data:image/png;base64,', ''));
        };
        reader.onerror = function (error) {
            console.log('Error: ', error);
        };
    }
});
