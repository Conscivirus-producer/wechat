<?php
session_start();
if(!(isset($_SESSION['wojiaonixue_internal_login_status']) AND $_SESSION['wojiaonixue_internal_login_status'] == 'active')){
    header("Location:login.html");
    exit();
}
require_once("config.php");

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>回复家长后台</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Loading Bootstrap -->
<link href="css/vendor/bootstrap.min.css" rel="stylesheet">
<!-- Loading Flat UI -->
<link href="css/flat-ui.min.css" rel="stylesheet">
<script src="js/vendor/jquery.min.js"></script>
<script src="js/jquery.ajaxfileupload.min.js"></script>
<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
<script src="js/vendor/html5shiv.js"></script>
<script src="js/vendor/respond.min.js"></script>
<![endif]-->
<link rel="shortcut icon" href="http://7xk9ts.com2.z0.glb.qiniucdn.com/logo.ico">
</head>
<body>
	<input type="text" name="rootUrl" id="rootUrl" value="<?php echo $rootUrl; ?>" style="display:none">
<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<p class="text-center">
				回复家长后台
			</p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-group">
				<label for="openid">家长openId:</label>
				<input type="text" name="openid" value="" id="openid" class="form-control input-sm" placeholder="请输入家长openId">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2 col-md-offset-4">
			<button type="button" class="btn btn-info btn-sm btn-block" name="reset" id="reset">默认</button>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-group">
				<label for="responseContent">微信内容:</label>
				<textarea class="form-control" rows="12" style="font-size:12px" id="responseContent" placeholder="推送老师图文信息请输入老师的openId，推送其它文本信息请直接输入信息"></textarea>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<button type="button" class="btn btn-info btn-sm btn-block" name="txtReply" id="txtReply">推送其它文本信息</button>
			<button type="button" class="btn btn-success btn-sm btn-block" name="imgMsgReply" id="imgMsgReply">根据openId推送老师图文信息</button>
			<button type="button" class="btn btn-info btn-sm btn-block" name="back" id="back">返回</button>
		</div>
	</div>
</div>
<!-- /.container -->
<!-- jQuery (necessary for Flat UI's JavaScript plugins) -->
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/vendor/video.js"></script>
<script src="js/flat-ui.min.js"></script>
<script type="text/javascript">
var rootUrl = $("#rootUrl").val();
$("#reset").click(function(){
	$("#openid").val("obS35vk9Hqwl4WZXsosjxm_hckKQ");
});

$("#back").click(function(){
	window.location.href="login.php";
});
	
$("#txtReply").click(function(){
	var openid = $("#openid").val();
	var responseContent = $("#responseContent").val();
	var url = "http://"+rootUrl+"/messageService.php?requestMethod=replyTextToUser&openid="+openid+"&content="+responseContent;
	$.getJSON(url,function(data){
		if(data.errcode == "45015"){
			alert("发送失败，错误信息为: " + data.errmsg);
		}else if(data.errcode == "0"){
			alert("发送成功");
		}else {
			alert("发送失败，请联系管理员。");
		}
	});
});

$("#imgMsgReply").click(function(){
	var openid = $("#openid").val();
	var teacherOpenId = $("#responseContent").val();
	var url = "http://"+rootUrl+"/messageService.php?requestMethod=replyImageAndTextInformation&openid="+openid+"&teacherOpenId="+teacherOpenId;
	$.getJSON(url,function(data){
		if(data.errcode == "NOTEXIST"){
			alert("发送失败，原因是: " + data.errmsg);
		}else if(data.errcode == "45015"){
			alert("发送失败，原因是: 家长已取消关注");
		}else if(data.errcode == "0"){
			alert("发送成功");
		}else {
			alert("发送失败，请联系管理员。");
		}
	});
});

</script>
</body>
</html>