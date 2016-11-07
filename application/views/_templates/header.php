<?php
@session_start();
$user_id = isset($_SESSION['loginID']) ? $_SESSION['loginID'] : null;
$user_class = isset($_SESSION['loginClass']) ? $_SESSION['loginClass'] : "2";

// Google Analystics 추적 코드
include_once("analyticstracking.php");

?>
<!DOCTYPE HTML>
<html>
<head>
    <title>ことこと</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <!--[if lte IE 8]>
    <script src="/public/assets/js/ie/html5shiv.js"></script><![endif]-->
    <link rel="stylesheet" href="/public/assets/css/main.css"/>
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/public/assets/css/ie8.css"/><![endif]-->

    <!-- CSS -->
    <link href="/public/assets/css/style.css" rel="stylesheet">
    <link href="/public/assets/css/farm.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/assets/css/clndr.css">

    <!-- JQuery -->
    <script src="/public/assets/js/jquery-2.2.2.min.js"></script>
    <script src="/public/assets/js/admin.js"></script>
    <script type="text/javascript" src="/public/assets/js/turnjs/jquery.min.1.7.js"></script>
    <script type="text/javascript" src="/public/assets/js/turnjs/jquery-ui-1.8.20.custom.min.js"></script>
    <script type="text/javascript" src="/public/assets/js/turnjs/jquery.mousewheel.min.js"></script>
    <script type="text/javascript" src="/public/assets/js/turnjs/modernizr.2.5.3.min.js"></script>
    <script type="text/javascript" src="/public/assets/js/turnjs/hash.js"></script>
    <script type="text/javascript" src="/public/ckeditor/ckeditor.js"></script>

    <script>

        function cameraStart() {
            // alert('cameraStart');
            // window.android.cameraonClick(<?php echo $_SESSION['loginID']?>);
            var loginID = '<?=$_SESSION['loginID']?>';
            window.android.cameraonClick(loginID);
        }

        function qrcodeStart() {
            // alert('qrcodeStart');
            window.android.qrcode();
        }

    </script>


    <style>
        .form-control {

        }
    </style>

</head>

<?php if (isset($sidebar)){ ?>
<body class="left-sidebar">
<?php }elseif (isset($index)){ ?>
<body class="homepage">
<?php }else{ ?>
<body class="no-sidebar">
<?php } ?>

<!-- node.js -->

<script src="/public/assets/node_js/node_modules/socket.io-client/dist/socket.io.js"></script>


<script>
    var socket = io.connect('http://kotokoto.xyz:8000');
    socket.on('connect', function () {
        socket.send(window.location.href);
    });
    window.onhashchange = function () {
        socket.send(window.location.href);
    }

</script>
<script>
    $(document).ready(function () {
        var bodyWidth = document.body.clientWidth
        if (bodyWidth > 400) {
            jQuery("#search").show();
        }
    })
</script>

<div id="page-wrapper">
    <!-- Header -->
    <div id="header-wrapper">
        <div id="header" class="container">
            <!-- Logo -->
            <div e>
                <a href="/home">
                    <img src="/public/assets/img/Logo4.png" style="margin-bottom: -3%;">
                </a>
            </div>
            <?php if ($user_class == 2) { ?>
                <div align="center" style="margin-left: 10%; display: none" id="search">
                    <!--<h1 id="logo"><a href="/home">コトコト</a></h1>-->
                    <form class="form-inline" method="post" action="/Recipe/search"
                          style="width: 50%; margin-left: 35%; margin-right: 0;">
                        <!--<li><a id="qrcode" href="#"><span onclick="qrcodeStart();">QRCode</span></a></li>
                        <li><a id="camera" href="#"><span onclick="cameraStart();">Camera</span></a></li>-->

                      <!--  <input type="text" class="form-control" name="scontent"
                               placeholder="#를 이용해 중복검색 ex) #김치#된장찌개"
                               style="width: 36%;">
                        <input type="submit" class="btn btn-default" value="검색"
                               style="margin: 0 auto; width: 10%; text-align: center; padding: 10px"> -->
                    </form>

                </div>
            <?php } else { ?>
                <!--<h1>コトコト</h1>-->
            <?php } ?>

            <!-- Nav -->
            <nav id="nav">
                <ul pa>
                    <?php if ($user_class == 1) { ?>
                        <li><a class="icon fa-home" href="/Farm/farm"><span>産地紹介</span></a></li>
                        <li><a href="/Farm/farmCrop" class="fa fa-pagelines"><span>生産物管理</span></a></li>
                        <li><a class="fa fa-list-alt" href="/Farm/farmHope"><span>受注リスト</span></a></li>
                        <li><a class="fa fa-pie-chart" href="/Farm/farmStock"><span>管理者の在庫</span></a></li>
                    <?php } else if ($user_class == 0) { ?>
                        <li><a class="fa fa-pie-chart" href="/Admin/adminStock"><span>在庫管理</span></a></li>
                        <li><a href="/Admin/adminOrder" class="fa fa-truck"><span>発注リスト</span></a></li>
                        <li><a class="fa fa-user" href="/Admin/adminMember"><span>会員管理</span></a></li>
                        <li><a class="fa fa-newspaper-o" href="/Admin/adminRecipe"><span>レシピ管理</span></a></li>
                        <li><a class="fa fa-briefcase" href="/Admin/adminOrderManage"><span>注文管理</span></a></li>
                        <li><a class="fa fa-area-chart"
                               href="/Admin/adminGraph/default/default/sessions"><span>アクセスログ解析</span></a></li>
                    <?php } else { ?>
                        
                        <li style="padding-right: 4em;"><a class="icon fa-home" href="/Company/index"><span>ことこと</span></a>
                        </li>
                        
                        <li style="padding-right: 4em;"><a href="/Recipe/best"
                                                           class="icon fa-thumbs-o-up"><span>Best</span></a></li>
                        <li style="padding-right: 4em;"><a class="icon fa-asterisk"
                                                           href="/Recipe/all/<?php echo $lineup = 0 ?>"><span>All</span></a>
                        </li>
                        <li style="padding-right: 4em;"><a class="icon fa-heart" href="/Recipe/needs"><span>Needs</span></a>
                        </li>
                        <li style="display:none;"><a id="qrcode" href="#"><span onclick="qrcodeStart();"
                                                                                style="display:none;">QRCode</span></a>
                        </li>
                        <li style="display:none;"><a id="camera" href="#"><span onclick="cameraStart();"
                                                                                style="display:none;">Camera</span></a>
                        </li>

                    <?php } ?>
                </ul>
            </nav>

            <nav id="nav2" style="float: left">
                <ul>
                    <?php if (isset($_SESSION['loginID'])) { ?>

                        <li style="line-height: 15px">
                            <a href="/Mypage/diary_Info"><img width="20px" src="/public/assets/img/header/member.gif">
                                <h6
                                    style="font-size: 10px;"><?= $_SESSION['loginID'] ?></h6></a>
                        </li>
                        <li style="line-height: 15px">
                            <a href="/Member/logout"><img width="20px" src="/public/assets/img/header/logout.png"><h6
                                    style="font-size: 10px;">Logout</h6></a>
                        </li>
                        <li style="line-height: 15px">
                            <a href="/Buy/cart"><img width=20px" src="/public/assets/img/header/cart.png"><h6
                                    style="font-size: 10px;">
                                    Cart</h6>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li style="line-height: 15px">
                            <a data-toggle="modal" data-target="#login" id="get_material_info" href=""><img
                                    width="15px"
                                    src="/public/assets/img/header/login.gif">
                                <h6 style="font-size: 10px;">Login</h6></a>
                        </li>
                        <li style="line-height: 15px">
                            <a href="/Member/join"><img width="20px" src="/public/assets/img/header/join.gif"><h6
                                    style="font-size: 10px; margin:0;">Join</h6></a>
                        </li>
                    <?php } ?>
                    <li style="line-height: 15px">
                        <a href="#"><img width="20px" src="/public/assets/img/header/customer.gif"><h6
                                style="font-size: 10px">
                                Help</h6>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

    </div>
</div>

<!-- 모달 팝업 -->

<div class="container">
    <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" style="width: 400px;">
            <div class="modal-content" style="width: 400px; height: 280px">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"></h4>

                    <h1 style="color: black">Login</h1>
                </div>
                <div class="modal-body">
                    <form method="post" action="/Member/login">
                        <p style="color: black; width: 80%; margin: 0 auto; padding-bottom: 10px"><input type="text"
                                                                                                         name="uid"
                                                                                                         placeholder="ID">
                        </p>

                        <p style="color: black; width: 80%; margin: 0 auto"><input type="password" name="upwd"
                                                                                   placeholder="PASSWORD"></p>

                        <p>

                        <div style="width: 250px; float: right">
                            <input type="submit" value="Login" name="submit_login"
                                   style="padding: 6px 10px; width: 42%">
                            <input type="button" value="Join" onclick="location.href='/Member/join'"
                                   style="padding: 6px 10px; width: 42%">
                        </div>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="http://code.jquery.com/jquery-latest.min.js"></script> -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="http://googledrive.com/host/0B-QKv6rUoIcGREtrRTljTlQ3OTg"></script>
<!-- ie10-viewport-bug-workaround.js -->
<script src="http://googledrive.com/host/0B-QKv6rUoIcGeHd6VV9JczlHUjg"></script>
<!-- holder.js -->


<!-- Main -->
<?php if (!isset($index)) { ?>
<div id="main-wrapper">
    <div id="main" class="container">
        <div class="row">
            <?php } ?>
