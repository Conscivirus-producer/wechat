<?php
if (isset($_GET['code'])){
    $code = $_GET['code'];
    $access_token_get_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";
    $access_token_json = file_get_contents($access_token_get_url); 
    $json_obj = json_decode($access_token_json,true);
    $openid = $json_obj["openid"];
}else{
	//$openid = "11111111";
	//need to be modified to show hint and qrcode image
    //echo "NO CODE";
    $openid = 'obS35vk9Hqwl4WZXsosjxm_hckKQ';
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>我的记录</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Loading Bootstrap -->
<link href="css/vendor/bootstrap.min.css" rel="stylesheet">
<!-- Loading Flat UI -->
<link href="css/flat-ui.min.css" rel="stylesheet">
<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
<script src="js/vendor/html5shiv.js"></script>
<script src="js/vendor/respond.min.js"></script>
<![endif]-->
</head>
<body>
<input type="text" name="openid" id="openid" value="<?php echo $openid; ?>" style="display:none">
<div class="container">
	<div class="row" style="" id="q0">
		<div id="information" class="col-md-4 col-md-offset-4" style="text-align:left">		
			我的记录详情
		</div>
	</div>
	<div class="row" style="" id="q1">
		<div id="information" class="col-md-4 col-md-offset-4" style="text-align:right">		
			
		</div>
	</div>
	
</div>
<!-- /.container -->
<!-- jQuery (necessary for Flat UI's JavaScript plugins) -->
<script src="js/vendor/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/vendor/video.js"></script>
<script src="js/flat-ui.min.js"></script>
<script type="text/javascript">
var rootUrl = "www.hehe.life";
rootUrl = "localhost";

$(document).ready(function(){
	var openId = $("#openid").val();
	var url = "http://"+rootUrl+"/service.php?requestMethod=myRecord&parentOpenId="+openId;
	$.getJSON(url,function(data){
		
	});
});


function GetQueryString(name)
{
     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
     var r = window.location.search.substr(1).match(reg);
     if(r!=null)return  unescape(r[2]); return null;
}
</script>
</body>
</html>