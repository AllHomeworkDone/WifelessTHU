<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <script src="./js/angular.js"></script>
</head>
<body>
<div ng-app="showFriends" ng-controller="showFriendsController">

    您的好友列表如下：
<ul>
<li ng-repeat="x in records">
    {{x.name}}
</li>
</ul>
<script>
    var app = angular.module("showFriends", []);
    app.controller("showFriendsController", function($scope) {
        $scope.records = [
            {
                "name":"菜鸟教程1"
            },
            {
                "name":"菜鸟教程2"
            },

        ]
    });
</script>

</div>
</body>
</html>