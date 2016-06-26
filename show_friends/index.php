<!DOCTYPE html>
<!-- 显示当前用户关注的人
需要以get方式提供 user_to_view 参数
-->
<html>
<head>
    <title>我关注的人</title>
    <meta charset="utf-8">
    <script src="../js/angular.js"></script>
    <script src="../js/jquery-1.12.4.js"></script>
    <script src="../js/cookieAPI.js"></script>
    <link rel="stylesheet" href="../css/cssForShowFansAndFriends.css">
</head>
<body background="../bg.jpg">
<div ng-app="showFriends" ng-controller="showFriendsController">

    <h1>我关注的人</h1>
<ul>
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
    var friendsData;
    function getFriends(user_to_view){
        userid = getCookie("userid");
        token = getCookie("token");
        viewing_userid = userid;
        if(user_to_view){
            if(user_to_view.length > 0){
                viewing_userid = user_to_view;
            }
        }
        $.post("../api/view_following.php", {"userid":  userid, "token": token, "viewing_userid": viewing_userid}, function(data){friendsData = data;})
        console.log("in getFriends, friendsData: " + friendsData);
        var friends_obj = JSON.parse(friendsData);
        if(friends_obj.code != 0){
            alert("获取  关注的人  的信息出现错误，错误码：" + friends_obj.code + "   错误信息：" + friends_obj.message);
            return [];
        }
        // 处理用户头像的路径
        for(var i = 0; i < friends_obj.data.length; ++i){
            if(friends_obj.data[i].icon){
                if(friends_obj.data[i].icon.length <= 0){
                    friends_obj.data[i].icon = "../images/icon/default.jpg";
                }
            }else{
                friends_obj.data[i].icon = "../images/icon/default.jpg";
            }
        }
        console.log("in getFriends, check icon url:" + JSON.stringify(friends_obj.data));
        return friends_obj.data
    }
</script>
<script>
    var app = angular.module("showFriends", []);
    app.controller("showFriendsController", function($scope) {
        $scope.records = getFriends("<?php if(!empty($_REQUEST['user_to_view'])) echo $_REQUEST['user_to_view']?>");
    });
</script>

</div>
</body>
</html>