<?php
// 必须以get的方式提供name参数
    @$name = $_GET['name'];
//    var_dump($name);
    function name_to_userid($name, $post) {
        $post["userid"] = $_COOKIE["userid"];
        $post["token"] = $_COOKIE["token"];
        $post["name"] = $name;
//        echo '$post["name"]';
//        echo $name;
//        var_dump($post);
        $url = dirname(dirname("http://" . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"])) . "/api/view_user.php";
        $options = array('http' => array(
            'header' => "Content-Type: application/x-www-form-urlencoded",
            'method' => 'POST',
            'content' => http_build_query($post),
            ),
        );
        $result = file_get_contents($url, false, stream_context_create($options));
        return json_decode($result, true); // 以 array 返回json解码的数据
    }
    $viewing_userid = name_to_userid($name, array())["data"]["userid"];
//var_dump($viewing_userid);
//var_dump(name_to_userid($name, array()));
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name;?> 的个人信息</title>
    <link rel="stylesheet" href="../css/blogRoboto.css">
    <link rel="stylesheet" href="../css/material_icon.css">
    <link rel="stylesheet" href="../css/material.indigo-pink.min.css">
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../custom.css">
    <link rel="script" href="../js/material.min.js">
    <link rel="script" href="../path/to/dropzone.js">
    <style>
        /*  */
        .on-card-button{
            float: left;
            list-style: none;
            margin-left: 2px;
        }
    </style>
    <script src="../js/jquery-1.12.4.js"></script>
    <script src="../js/cookieAPI.js"></script>
</head>

<body background="../bg.jpg">


<div class="demo-blog mdl-layout mdl-js-layout has-drawer is-upgraded">
    <main class="mdl-layout__content">
        <div class="demo-blog__posts mdl-grid">

            <div class="mdl-card something-else mdl-cell mdl-cell--8-col mdl-cell--4-col-desktop" style="max-height: 300px">
                <button class="mdl-button mdl-js-ripple-effect mdl-js-button mdl-button--fab mdl-color--accent" onclick=" addFriend('<?php echo $_REQUEST['userid_to_view']?>');">
                    <i class="material-icons mdl-color-text--white" role="presentation" style="font-size: medium">关注</i>
                    <span class="visuallyhidden">add</span>
                </button>
                <div class="mdl-card__media mdl-color--white mdl-color-text--grey-600">
                    <img src="" id="userIconInTopRight" width="100px" hight="100px">
                    <div style="text-align: center;" id="userNameInTopLeft"></div>
                    <span id="numbers" style="display: inline-block"> </span>
                    <!-- 关注：<span id="numberOfFollowed" style="display: inline-block"> </span> | 粉丝：<span id="numberOfFans"> </span> | 动态：<span id="numberOfPosts"> </span> <br> -->
                    好友路径：
                    <div id="two_step_friend">加载好友路径中</div>
                </div>
            </div>
            <div id="postsContainer"> </div>
            <button id="loadMore" onclick="loadMore()">加载更多</button>

    </main>
    <div class="mdl-layout__obfuscator"></div>
</div>
<!--<a href="https://github.com/google/material-design-lite/blob/master/templates/blog/" target="_blank" id="view-source" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--accent mdl-color-text--white">View Source</a>-->
<script src="https://code.getmdl.io/1.1.3/material.min.js"></script>
</body>
<script>
    Array.prototype.forEach.call(document.querySelectorAll('.mdl-card__media'), function(el) {
        var link = el.querySelector('a');
        if(!link) {
            return;
        }
        var target = link.getAttribute('href');
        if(!target) {
            return;
        }
        el.addEventListener('click', function() {
            location.href = target;
        });
    });
</script>
<script>
    // 用于设置拖拽上传图片
//    var myDropZone = new Dropzone("#imageUploadArea",{url: "../api/test_wenkai/handle_post_image.php"})
</script>
<script src="../js/addOneCard.js"></script>

<script>
    // 用于在页面完全加载好之前显示提示信息
    function setWaitingState(){
        var cardData = document.createElement("div");
        cardData.innerHTML ='<div class="mdl-card on-the-road-again mdl-cell mdl-cell--8-col" style="width: 640px" id="waitingCard">' +
            '<div class="mdl-color-text--grey-600 mdl-card__supporting-text">' +
            '加载中，请稍候' +  // 此处存放文字
            '</div>' +
            '<div class="mdl-card__supporting-text meta mdl-color-text--grey-600">'+
            '<div class="minilogo"></div> '+
            '<div>'+
            '<strong>' +  ' ' + '</strong>'+  // 发布者名称
            '<span> </span>'+
            '</div>'+
            '<div>'+
            '<ul>   <li class="on-card-button">            评论            </li>            </ul>'+
            '</div>'+
            '</div>'+
            '</div>';
        var postContainer = document.getElementById("postsContainer");
        postContainer.appendChild(cardData);
    }
    function removeWaitingState() {
        document.removeChild(document.getElementById("waitingCard"));
    }
    setWaitingState();
</script>
<script>
    function addCardFromJson(jsondata) {
        document.getElementById("waitingCard").style.display = "none";
        var data = JSON.parse(jsondata);
        console.log("in addcardfromjson" + JSON.stringify(data.data));
        if (data.code != 0) return false;
        for (var i = 0; i < data.data.posts.length; i++) {
            var cardData = data.data.posts[i];
//            console.log("in addcardfromjson" + JSON.stringify(cardData));
            if (cardData.images) {
                if (cardData.images[0])
                    cardData["type"] = "textAndImage";
                else
                    cardData["type"] = "text";
            } else {
                cardData["type"] = "text";
            }
            cardData.name = data.data.userinfo.name;
            cardData.userid = data.data.userinfo.userid;
            cardData.icon = data.data.userinfo.icon;
            addOneCard(cardData);
        }
        return true;
    }
</script>

<script>
    /**
     * 设置用户头像和名称
     */
    function setUserIconURLAndName(){
        $.post("../api/view_user.php",{
            "viewing_userid": "<?php echo $_REQUEST['userid_to_view']?>",
            "userid": getCookie("userid"),
            "token": getCookie("token")
        }, function (data) {
            console.log("in setUserIconURL, data: " + data);
            var dataObj = JSON.parse(data);
            if(dataObj.code != 0){
                alert("拉取头像错误！错误码：" + dataObj.code + "   错误信息：" + dataObj.message);
                return false;
            }else{
                document.getElementById("userIconInTopRight").src = processIconStr(dataObj.data.icon);
                document.getElementById("userNameInTopLeft").innerHTML = dataObj.data.name;
                return true;
            }
        })
    }
    setUserIconURLAndName();
</script>
<script>
    // 用于异步从服务器加载内容
    startIndex = 0;
    itermsPertime = 10;
    isAddSuccessful = true;
    function autoload(startIndex) {
        $.ajaxSetup({async: false});
        $.post("../api/view_user_posts.php",
            {
                "token": getCookie("token"),
                "userid": getCookie("userid"),
                "start": startIndex,
                "per_time":itermsPertime,
                "viewing_userid": <?php  echo $_REQUEST['userid_to_view']  ?>
            },
            function(data){console.log("autoload dataLoaded: " + data); isAddSuccessful = addCardFromJson(data)});  // 添加type参数为application/x-www-form-urlencoded后就会出现问题，不知道为什么
        console.log("isAddSuccessful: " + isAddSuccessful);
        if(isAddSuccessful){
            return startIndex + itermsPertime;
        }else{
            return -1;
        }
    }
   startIndex = autoload(startIndex);
</script>
<script>
    function loadMore() {
        console.log("startIndex: "+ startIndex);
        if(startIndex == -1){
            document.getElementById("loadMore").innerHTML = "没有更多了";
        }else{
            startIndex = autoload(startIndex);
        }
    }
</script>

<script>
    isFriendsRouteSuccessful = true;
    isFriend = false;
    function checkFriends() {
        $.post("../api/check_friends.php",
        {
            "token": getCookie("token"),
            "userid": getCookie("userid"),
            "viewing_userid": <?php  echo $_REQUEST['userid_to_view']  ?>
        },
        function(data){console.log("check_friends: " + data); isFriend = JSON.parse(data)});
    }
    function loadRoute() {
        $.post("../api/two_step_friend.php",
        {
            "token": getCookie("token"),
            "userid": getCookie("userid"),
            "target_id": <?php  echo $_REQUEST['userid_to_view']  ?>
        },
        function(data){console.log("route dataLoaded: " + data); isFriendsRouteSuccessful = addRoute(data)});  // 添加type参数为application/x-www-form-urlencoded后就会出现问题，不知道为什么
        console.log("isFriendsRouteSuccessful: " + isFriendsRouteSuccessful);
    }
    console.log("checkFriends");
    checkFriends();
    console.log("isFriend: " + isFriend.data);
    if (isFriend.data) {
        routeHTML = "该用户已经是您的好友";
        document.getElementById("two_step_friend").innerHTML = routeHTML;
    }
    else{
        loadRoute();
    }
    function addRoute(jsondata) {
        var data = JSON.parse(jsondata);
        console.log("in addroutefromjson" + JSON.stringify(data.data));
        if (data.code != 0) return false;
        var routeHTML = "";
        for (var i = 0; i < Math.min(data.data.length, 4); i++) {
            routeData = data.data[i];
            routeHTML += "你 → " + routeData["name"] + " → <?php echo $name; ?><br />";
        }
        if (routeHTML.length == 0) {
            routeHTML = "该用户不是您两步以内的好友";
        }
        document.getElementById("two_step_friend").innerHTML = routeHTML;
        return true;
    }
</script>

<script>
    $(window).scroll(function(){console.log("scorll event2");})
</script>

<script>
    /**
     * 在加载完成后更新页面中的元素，此函数会更新所有userNameSpan中的内容
     */
    function updateUserName(){
        var nodeList = document.getElementsByName("userNameSpan");
        for (var node in nodeList){
            console.log("jaah");
        }
    }
    var storeUserName={
        "uptodate": false,
        "content": ""
    };
    function getUserName(){
        if(storeUserName.uptodate){
            return storeUserName.content;
        }else{
            $.post("../api/")
        }
    }
</script>

<script>
    /**
     * 添加好友：从当前的登陆用户发出添加好友申请到
     */
    // 从url中获取参数
    function getQueryString(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
        var r = window.location.search.substr(1).match(reg);
        if (r != null) return unescape(r[2]); return null;
    }
    function addFriend(tofollow_userid) {
        var userid = getCookie("userid");
        var token = getCookie("token");
        if(tofollow_userid.length <= 0){
            console.log("in addFriend: parameter tofollow_userid needed");
            tofollow_userid = userid;
        }
        $.post("../api/follow.php", {
            "userid": userid, 
            "token": token,
            "tofollow_userid": tofollow_userid
        },function (data) {
            console.log("in addFriend: " + data);
            var dataObj = JSON.parse(data);
            if(dataObj.code == 0) {
                alert("关注成功！");
            }else{
                alert("操作错误！错误码：" + dataObj.code + "     提示信息：" + dataObj.message);
            }
            }
        )
    }
</script>
<script>
    /**
     * initialize
     * 关注
     * 粉丝
     * 动态
    */
    function initialize() {
        var number_str = "关注：";
        $.post("../api/view_following.php",{
            "userid": getCookie("userid"),
            "token": getCookie("token"),
            "viewing_userid": <?php  echo $_REQUEST['userid_to_view']  ?>
        }, function(data){
            var number = JSON.parse(data).data.length;
            console.log("follow number: " + number);
            number_str += number;
            number_str += "  |  粉丝："
        })
        $.post("../api/view_fans.php",{
            "userid": getCookie("userid"),
            "token": getCookie("token"),
            "viewing_userid": <?php  echo $_REQUEST['userid_to_view']  ?>
        }, function(data){
            var number = JSON.parse(data).data.length;
            console.log("fan number: " + number);
            number_str += number;
            number_str += "  |  动态："
        })
        $.post("../api/user_posts_num.php",{
            "userid": getCookie("userid"),
            "token": getCookie("token"),
            "viewing_userid":<?php  echo $_REQUEST['userid_to_view']  ?>
        }, function(data){
            var number = 0;
            number = JSON.parse(data).data.count;
            console.log("posts number: " + number);
            number_str += number;
            document.getElementById("numbers").innerHTML = number_str;
        })
    }
    initialize();
</script>
</html>