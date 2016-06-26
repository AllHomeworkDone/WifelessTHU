<!DOCTYPE html>
<!-- 显示当前用户的（粉丝）
需要以get方式提供 user_to_view 参数
-->
<html>
<head>
    <title>我的粉丝</title>
    <meta charset="utf-8">
    <script src="../js/angular.js"></script>
    <script src="../js/jquery-1.12.4.js"></script>
    <script src="../js/cookieAPI.js"></script>
    <link rel="stylesheet" href="../css/cssForShowFansAndFriends.css">
</head>
<body background="../bg.jpg">
<div ng-app="showFans" ng-controller="showFansController">

    <h1>我的粉丝</h1>
<ul style="list-style: none; padding-right: 40px">
<li ng-repeat="x in records">
    <div class="userInfoCard">
        <div class="userIcon" style=""><img src = "{{x.icon}}" id="image" width="100" height="100"></div>
        <div class="userName" style="">{{x.name}}</div>
    </div>
</li>
</ul>
<script type="text/javascript">
    $.ajaxSetup({
        async: false
    });
    var fansData;
    function getFans(user_to_view){
        userid = getCookie("userid");
        token = getCookie("token");
        viewing_userid = userid;
        if(user_to_view){
            if(user_to_view.length > 0){
                viewing_userid = user_to_view;
            }
        }

        $.post("../api/view_fans.php", {"userid":  userid, "token": token, "viewing_userid": viewing_userid}, function(data){console.log(data);fansData = data;})
        var fans_obj = JSON.parse(fansData);
        // 处理用户头像的路径
        for(var i = 0; i < fans_obj.data.length; ++i){
            if(fans_obj.data[i].icon){
                if(fans_obj.data[i].icon.length <= 0){
                    fans_obj.data[i].icon = "../images/icon/default.jpg";
                }
            }else{
                fans_obj.data[i].icon = "../images/icon/default.jpg";
            }
        }
//        console.log("in getFans, check icon url:" + JSON.stringify(fans_obj.data));
        return fans_obj.data
    }
</script>
<script>
    var app = angular.module("showFans", []);
    app.controller("showFansController", function($scope) {
        $scope.records = getFans("<?php if(!empty($_REQUEST['user_to_view'])) echo $_REQUEST['user_to_view']?>");
    });
</script>

</div>
</body>
</html>