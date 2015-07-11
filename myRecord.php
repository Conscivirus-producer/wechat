<?php
if (isset($_GET['code'])){
    $code = $_GET['code'];
    $access_token_get_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";
    $access_token_json = file_get_contents($access_token_get_url); 
    $json_obj = json_decode($access_token_json,true);
    $openid = $json_obj["openid"];
}else{
	$openid = "11111111";
	//need to be modified to show hint and qrcode image
    //echo "NO CODE";
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
		transactionId = data.transactionId;
		transactionDt = data.createdDt;
		var name = data.name;
		var length = transactionId.length;
		if(length == 0){
			$("#information").html("您当前还没有选择老师");
		}
		var $ulGroup = $("<ul>", {class : "list-group"});
		for(var i = 0;i < length;i++){
			var $li = $("<li>", {class: "list-group-item"}).text(name[i] + " " + getStatus(data.status[i]) );
			if(data.status[i] == 'I' || data.status[i] == 'S'){
				var $button = $("<button>", {type: "button", style:"text-align:right"}).attr("id",data.transactionId[i]).text("取消记录");
				$li.append($button);
				$button.click(function(){
					var value = $(this).attr("id");
					if(window.confirm("您确定要取消交易吗？")){
						cancelUrl = "http://"+rootUrl+"/service.php?requestMethod=cancelTransaction&transactionId="+value;
						$.getJSON(cancelUrl,function(data){
						});
						window.location = "https://open.weixin.qq.com/connect/oauth2/authorize?appid="+$appid+"&redirect_uri="+
						"http://"+rootUrl+"/myRecord.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
							//window.location.reload();
					}
				});
			}
			$ulGroup.append($li);
		}
		$("#q1").append($ulGroup);
	});
});

function getStatus(code){
	if(code == "I"){
		return "订单建立";
	} else if(code == "C"){
		return "订单取消";
	} else if(code == "S"){
		return "订单成功开始";
	} else if(code == "E"){
		return "订单结束";
	}
	
}
</script>
</body>
</html>
