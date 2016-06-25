<?php
/**
 * Created by PhpStorm.
 * User: Frank
 * Date: 16/4/27
 * Time: 上午11:08
 */

/**
 * Common functions for Social API.
 */
require_once 'api_utilities.php';
$con = db_connect();
check_login($con);

$userid = intval(filter($con, $_POST["userid"]));
$viewing_userid = intval(filter($con, $_POST["viewing_userid"]));
@$name = filter($con, $_POST["name"]);

if (strlen($name) == 0 && $viewing_userid == 0) {
    report_error(ERROR_MISSING_PARAMETER);
}

if ($viewing_userid == 0) {
    $result = $con->query("SELECT * FROM user WHERE name = '$name'");
} else {
    $result = $con->query("SELECT * FROM user WHERE userid = '$viewing_userid'");
}
check_sql_error($con);
if (mysqli_affected_rows($con) == 0) {
    report_error(1, "该用户不存在");
}
$result = mysqli_fetch_array($result);
$return = array(
	"userid" => $result["userid"],
    "name" => $result["name"],
    "sex" => $result["sex"],
    "icon" => $result["icon"],
);
if ($userid == $result["userid"]) { // 自己才能查看邮箱
    $return["email"] = $result["email"];
}

report_success($return);