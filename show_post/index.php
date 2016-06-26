<!DOCTYPE html>
<!-- 显示动态详情
需要以get方式提供postid
-->
<html>
<head>
    <title>查看动态</title>
    <meta charset="utf-8">
    <script src="../js/angular.js"></script>
    <script src="../js/jquery-1.12.4.js"></script>
    <script src="../js/cookieAPI.js"></script>
    <link rel="stylesheet" href="../css/blogRoboto.css">
    <link rel="stylesheet" href="../css/material_icon.css">
    <link rel="stylesheet" href="../css/material.indigo-pink.min.css">
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../custom.css">
</head>

<body background="../bg.jpg">

<div ng-app="showPost" ng-controller="showPostController" align="center">

    <div class="mdl-card on-the-road-again mdl-cell mdl-cell--8-col" style="width: 640px; top: 220px;" align="left">
        <div class="mdl-color-text--grey-600 mdl-card__supporting-text">{{post_records.text}}</div>
        <div class="mdl-card__supporting-text meta mdl-color-text--grey-600">
            <div class="minilogo" style="float: left; margin-right: 5px"><img src="{{post_records.icon}}" width="50px" height="50px"></div>
            <div>
            <div><strong>{{post_records.name}}</strong><br>
                <span>{{post_records.create_time}}</span><br>
            </div>

                <div>
                    <br>
                <div>评论：</div>
                <ul>
                    <li ng-repeat="x in comments_records">
                        <div>{{x.name}}  说：{{x.text}}</div>
                        <div>{{x.create_time}}</div>
                    </li>
                </ul>
                <form onsubmit="submitForm()" enctype="application/x-www-form-urlencoded">
                    <div>发表评论</div>
                    <input name="text" id="commentText">
                    <button type="submit">发表</button>
                    <script>
                        function submitForm() {
                            $.post("../api/comment.php",{
                                "text": document.getElementById("commentText").value,
                                "postid": getPostidInURL(),
                                "userid": getCookie("userid"),
                                "token": getCookie("token")
                            }, function (data) {
                                console.log("in submitForm, data: " + data);
                                var dataObj = JSON.parse(data);
                                if(dataObj.code != 0) {
                                    alert("评论发表错误，错误代码：" + dataObj.code + "   错误信息：" + dataObj.message);
                                }else{
                                    alert("评论发表成功！");
                                    location.reload();
                                }
                            })
                        }
                    </script>
                </form>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
    $.ajaxSetup({
        async: false
    });
    var postData;
    function getPost(postid_to_view){
        var userid = getCookie("userid");
        var token = getCookie("token");
        console.log(postid_to_view);
        var postid = -1;
        if(postid_to_view) {
            if (postid_to_view > 0) {
                postid = postid_to_view;
            }
        }
        if(postid == -1){ //postid没能得到成功的修改
            alert("未提供postid参数，查看失败！");
            return null;
        }
        $.post("../api/view_post.php", {"userid":  userid, "token": token, "postid": postid}, function(data){console.log("in getPost: " + data); postData = data;})
        var post_obj = JSON.parse(postData);
//        console.log("in getPost: " + postData);
        // 处理数据中的icon链接
        post_obj.data.post.icon = processIconStr(post_obj.data.post.icon);
        return post_obj.data;
    }
</script>
<script>
    var app = angular.module("showPost", []);
    app.controller("showPostController", function($scope) {
        var post = getPost("<?PHP if(!empty($_REQUEST['postid'])) echo $_REQUEST['postid']; ?>");
        $scope.post_records = post.post;
        $scope.comments_records = post.comments; 
    });
</script>
<script>
    function getPostidInURL(){
        return "<?PHP  if(!empty($_REQUEST['postid'])) echo $_REQUEST['postid'];?>";
    }
</script>
<script src="../js/processIconStr.js"></script>

</div>
</body>
</html>