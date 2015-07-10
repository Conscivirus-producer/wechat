<?php
require_once("config.php");

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>获取订单信息</title>
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
</head>
<body>
	<input type="text" name="rootUrl" id="rootUrl" value="<?php echo $rootUrl; ?>" style="display:none">
<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-2">
			老师openid:
			<input type="text" name="openid" value="" id="openid">
			<button type="button" class="btn" name="reset" id="reset">默认</button>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-4 col-md-offset-2">
			微信内容:
		</br>
			<textarea rows="12" cols="35" style="font-size:12px" id="responseContent"></textarea>
		</div>
	</div>
	
	<div class="row" style="margin-top:30px">
		<div class="col-md-4 col-md-offset-4">
			<button type="button" class="btn btn-info btn-lg btn-block" name="submit" id="submit">提交</button>
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
	
$("#submit").click(function(){
	var openid = $("#openid").val();
	var responseContent = $("#responseContent").val();
	var url = "http://"+rootUrl+"/supporting.php?requestMethod=replyToUser&openid="+openid+"&content="+responseContent;
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

</script>
</body>
</html>