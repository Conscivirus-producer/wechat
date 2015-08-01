<?php
session_start();
$_SESSION['wojiaonixue_internal_login_status'] = "active";
require_once("config.php");
require_once("globalData.php");
require_once 'vendor/autoload.php';
use Qiniu\Auth;

$openid = "";
if (isset($_GET['code'])){
    $code = $_GET['code'];
    $access_token_get_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";
    $access_token_json = file_get_contents($access_token_get_url); 
    $json_obj = json_decode($access_token_json,true);
    $openid = $json_obj["openid"];
}else{
    //exit("NO CODE");
    $openid = "obS35vk9Hqwl4WZXsosjxm_hckKQ";
}

$globalData = new GlobalData();
if (strpos($globalData->getWhiteList(),$openid) == ''){
	exit("该功能目前尚未开放.");
}

$accessKey = 'k7HBysPt-HoUz4dwPT6SZpjyiuTdgmiWQE-7qkJ4';
$secretKey = 'BuaBzxTxNsNUBSy1ZvFUAfUbj8GommyWbfJ0eQ2R';
$auth = new Auth($accessKey, $secretKey);

$bucket = 'wojiaonixue';
$token = $auth->uploadToken($bucket);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>手工录入订单</title>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
<!-- Loading Bootstrap -->
<link href="css/vendor/bootstrap.min.css" rel="stylesheet">
<!-- Loading Flat UI -->
<link href="css/flat-ui.min.css" rel="stylesheet">
<script src="js/vendor/jquery.min.js"></script>
<script src="js/jquery.ajaxfileupload.js"></script>
<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
<script src="js/vendor/html5shiv.js"></script>
<script src="js/vendor/respond.min.js"></script>
<![endif]-->
<style>
.sl-custom-file{display:inline-block;
	text-align:center;
	overflow:hidden;
	position:relative;
}
.ui-input-file{opacity:0;
	filter:alpha(opacity=0);
	position:absolute;
	top:0;
	right:0;
}
</style>
</head>
<body>
<input type="text" name="openid" id="openid" value="<?php echo $openid; ?>" style="display:none">
<input type="text" name="token" id="token" value="<?php echo $token; ?>" style="display:none">

<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<p class="text-center">
				手工创建订单
			</p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-2">
			<div class="form-group">
				<label for="name">手机号</label>
				<input type="text" class="form-control" name="mobile" id="mobile" placeholder="手机号">
			</div>
		</div>
		<div class="col-md-4 col-md-offset-2">
			<div class="form-group">
				<label for="name">称呼</label>
				<input type="text" class="form-control" name="nickname" id="nickname" placeholder="称呼">
			</div>
		</div>
		<div class="col-md-4 col-md-offset-2">
			<div class="form-group">
				<label for="name">年级</label>
				<input type="text" class="form-control" name="grade" id="grade" placeholder="年级">
			</div>
			<div class="form-group">
				<label for="name">科目</label>
				<input type="text" class="form-control" name="subject" id="subject" placeholder="科目">
			</div>
			<div class="form-group">
				<label for="name">兴趣</label>
				<input type="text" class="form-control" name="interest" id="interest" placeholder="兴趣">
			</div>
			<div class="form-group">
				<label for="name">期望地点</label>
				<input type="text" class="form-control" name="address" id="address" placeholder="地点">
			</div>
			<div class="form-group">
				<label for="name">备注</label>
				<input type="text" class="form-control" name="remark" id="remark" placeholder="备注">
			</div>
		</div
	</div>
	
	<div class="row" style="margin-top:5px">
		<div class="col-md-4 col-md-offset-4">
			<button type="button" class="btn btn-primary btn-lg btn-block" name="submit" id="submit">提交</button>
		</div>
	</div>
	<div class="row" style="margin-top:10px">
		<div class="col-md-4 col-md-offset-4">
		</div>
	</div>
</div>
<!-- /.container -->
<!-- jQuery (necessary for Flat UI's JavaScript plugins) -->
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/vendor/video.js"></script>
<script src="js/flat-ui.min.js"></script>
<script src="assets/js/application.js"></script>
<script type="text/javascript">

$("#submit").click(function(){
	mobile = $("#mobile").val();
	if(!validatePhone(mobile)){
		alert("请输入正确的手机号");
		return;
	}
	var url = "supporting.php?requestMethod=manualCreateTransaction&mobile="+mobile+"&nickname="+$("#nickname").val()
	+"&grade="+$("#grade").val()+"&subject="+$("#subject").val()+"&interest="+$("#interest").val()+"&address="+$("#address").val()
	+"&remark="+$("#remark").val();
	$.getJSON(url, function(data){
		alert(data.message);
		//alert(data);
	});	
});

function validatePhone(phone){
	var reg = /^(13[0-9]|14[0-9]|15[0-9]|18[0-9])\d{8}$/;
	if (reg.test(phone)) {
		return true;
	}else{
		return false;
	}
}
</script>
</body>
</html>