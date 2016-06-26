<?php
/**
 * 全部好友以及自己的动态，分页返回
 */

require_once 'api_utilities.php';
$con = db_connect();
check_login($con);

$userid = intval(filter($con, $_POST["userid"]));
$start = intval(filter($con, $_POST["start"]));
$per_time = intval(filter($con, $_POST["per_time"]));

$result = $con->query("SELECT post.*, user.name, user.icon, COUNT(commentid) AS num FROM post LEFT JOIN comment ON post.postid=comment.postid, friends, user WHERE ((post.userid = friends.followed_userid AND friends.fan_userid = $userid) OR post.userid = $userid) AND post.userid = user.userid GROUP BY postid ORDER BY create_time DESC LIMIT $start, $per_time");
check_sql_error($con);
$count = mysqli_affected_rows($con);

if ($count == 0) {
    report_error(1, "没有更多状态");
}

$return = array();
while ($row = mysqli_fetch_array($result)) {
    $postid = $row["postid"];
    $images = array();
    $image_result = $con->query("SELECT * FROM post_images WHERE postid = '$postid'");
    check_sql_error($con);
    while ($image_row = mysqli_fetch_array($image_result)) {
        array_push($images, $image_row["image"]);
    }
    array_push($return, array(
        "postid" => $postid,
        "text" => $row["text"],
        "images" => $images,
        "create_time" => $row["create_time"],
        "userid" => $row["userid"],
        "name" => $row["name"],
        "icon" => $row["icon"],
        "comments_num" => $row["num"],
    ));
}

report_success(array("posts" => $return));