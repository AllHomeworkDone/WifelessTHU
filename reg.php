<!DOCTYPE html>
<!-- saved from url=(0065)http://www.17sucai.com/preview/207728/2016-01-07/login/index.html -->
<html lang="en" class="login-content ng-scope" data-ng-app="materialAdmin"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><style type="text/css">.ng-animate.item:not(.left):not(.right){-webkit-transition:0s ease-in-out left;transition:0s ease-in-out left}</style><style type="text/css">@charset "UTF-8";[ng\:cloak],[ng-cloak],[data-ng-cloak],[x-ng-cloak],.ng-cloak,.x-ng-cloak,.ng-hide:not(.ng-hide-animate){display:none !important;}ng\:form{display:block;}</style>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Generator" content="EditPlus®">
    <meta name="Author" content="">
    <meta name="Keywords" content="">
    <meta name="Description" content="">
    <title>Material Admin</title>
    <!--
        作者：561568157@qq.com
        时间：2016-01-07
        描述：ICO
    -->
    <link rel="shortcut icon" type="image/x-icon" href="http://www.17sucai.com/preview/207728/2016-01-07/login/favicon.ico">
    <!-- Vendor CSS -->
    <link href="./Material Admin_files/material-design-iconic-font.min.css" rel="stylesheet" type="text/css">
    <!-- CSS -->
    <link href="./Material Admin_files/app.min.1.css" rel="stylesheet" type="text/css">
    <style type="text/css"></style></head>
<body class="login-content ng-scope" data-ng-controller="loginCtrl as lctrl" youdao="bind">

<div class="lc-block" id="l-login" data-ng-class="{&#39;toggled&#39;:lctrl.login === 1}">
    <h1 class="lean">Azrael</h1>

    <div class="input-group m-b-20">
    		<span class="input-group-addon">
    			<i class="zmdi zmdi-account"></i>
    		</span>
        <div class="fg-line fg-toggled has-error">
            <input type="text" class="form-control" placeholder="Username" regex="^\w{3,16}$">
        </div>
    </div>

    <div class="input-group m-b-20">
    		<span class="input-group-addon">
    			<i class="zmdi zmdi-male"></i>
    		</span>
        <div class="fg-line fg-toggled has-error">
            <input type="password" class="form-control" placeholder="Password" regex="^\w+">
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="checkbox">
        <label>
            <input type="checkbox" value="">
            <i class="input-helper">
                Keep me signed in
            </i>
        </label>
    </div>

    <a href="http://www.17sucai.com/preview/207728/2016-01-07/login/index.html" class="btn btn-login btn-danger btn-float">
        <i class="zmdi zmdi-arrow-forward"></i>
    </a>

    <ul class="login-navigation">
        <li class="bgm-red" data-ng-click="lctrl.login = 0; lctrl.register = 1">Register</li>
        <li data-block="#l-forget-password" class="bgm-orange" data-ng-click="lctrl.login = 0; lctrl.forgot = 1">Forgot Password?</li>
    </ul>
</div>

<!-- ngIf: lctrl.register === 1 -->

<!-- ngIf: lctrl.forgot === 1 --><div class="lc-block ng-scope toggled" id="l-forget-password" data-ng-class="{ &#39;toggled&#39;: lctrl.forgot === 1 }" data-ng-if="lctrl.forgot === 1">
    <h1 class="lean">Azrael</h1>
    <p class="text-left">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eu risus. Curabitur commodo lorem fringilla enim feugiat commodo sed ac lacus.</p>
    <div class="input-group m-b-20">
        <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
        <div class="fg-line">
            <input type="text" class="form-control" placeholder="Email Address" regex="^\w+@\w+\.[a-zA-Z]+(\.[a-zA-Z]+)?$">
        </div>
    </div>

    <a href="http://www.17sucai.com/preview/207728/2016-01-07/login/index.html" class="btn btn-login btn-danger btn-float"><i class="zmdi zmdi-arrow-forward"></i></a>

    <ul class="login-navigation">
        <li data-block="#l-login" class="bgm-green" data-ng-click="lctrl.forgot = 0; lctrl.login = 1">Login</li>
        <li data-block="#l-register" class="bgm-red" data-ng-click="lctrl.forgot = 0; lctrl.register = 1">Register</li>
    </ul>
</div><!-- end ngIf: lctrl.forgot === 1 -->

<div class="lc-block" id="l-register" data-ng-class="{ 'toggled': lctrl.register === 1 }" data-ng-if="lctrl.register === 1">
    <h1 class="lean">Azrael</h1>

    <div class="input-group m-b-20">
    		<span class="input-group-addon">
    			<i class="zmdi zmdi-account"></i>
    		</span>
        <div class="fg-line">
            <input type="text" class="form-control" placeholder="Username" regex="^\w{3,16}$"/>
        </div>
    </div>

    <div class="input-group m-b-20">
    		<span class="input-group-addon">
    			<i class="zmdi zmdi-email"></i>
    		</span>
        <div class="fg-line">
            <input type="text" class="form-control" placeholder="Email Address" regex="^\w+@\w+\.[a-zA-Z]+(\.[a-zA-Z]+)?$"/>
        </div>
    </div>

    <div class="input-group m-b-20">
    		<span class="input-group-addon">
    			<i class="zmdi zmdi-male"></i>
    		</span>
        <div class="fg-line">
            <input type="password" class="form-control" placeholder="Password" regex="^\w+"/>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="checkbox">
        <label>
            <input type="checkbox" value=""/>
            <i class="input-helper"></i>
            Accept the license agreement
        </label>
    </div>

    <a href="" class="btn btn-login btn-danger btn-float"><i class="zmdi zmdi-arrow-forward"></i></a>

    <ul class="login-navigation">
        <li data-block="#l-login" class="bgm-green" data-ng-click="lctrl.register = 0; lctrl.login = 1">Login</li>
        <li data-block="#l-forget-password" class="bgm-orange" data-ng-click="lctrl.register = 0; lctrl.forgot = 1">Forgot Password?</li>
    </ul>
</div>

<script src="./Material Admin_files/jquery.min.js"></script>
<script src="./Material Admin_files/log.js"></script>
<!-- Angular -->
<script src="./Material Admin_files/angular.min.js"></script>
<script src="./Material Admin_files/angular-resource.min.js"></script>
<script src="./Material Admin_files/angular-animate.min.js"></script>


<!-- Angular Modules -->
<script src="./Material Admin_files/angular-ui-router.min.js"></script>
<script src="./Material Admin_files/loading-bar.js"></script>
<script src="./Material Admin_files/ocLazyLoad.min.js"></script>
<script src="./Material Admin_files/ui-bootstrap-tpls.min.js"></script>

<!-- Common js -->
<script src="./Material Admin_files/nouislider.min.js"></script>
<script src="./Material Admin_files/ng-table.min.js"></script>

<!-- Placeholder for IE9 -->
<!--[if IE 9 ]>
<script src="js/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
<![endif]-->
<!-- App level -->
<script src="./Material Admin_files/app.js"></script>
<script src="./Material Admin_files/main.js"></script>
<script src="./Material Admin_files/ui-bootstrap.js"></script>


<!-- Template Modules -->
<script src="./Material Admin_files/form.js"></script>
</body></html>