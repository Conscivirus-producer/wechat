<?php
require_once("config.php");
require_once("processUtil.php");
$codeParser = new CodeParser();
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
<link href="css/default.css" rel="stylesheet">
<link href="css/start.css" rel="stylesheet">
<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
<script src="js/vendor/html5shiv.js"></script>
<script src="js/vendor/respond.min.js"></script>
<![endif]-->
</head>
<body>
<input type="text" name="openid" id="openid" value="<?php echo $openid; ?>" style="display:none">
<input type="text" name="rootUrl" id="rootUrl" value="<?php echo $rootUrl; ?>" style="display:none">
<div class="container">
	<div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<table width="100%">
			<tr><td colspan="2">您选择的信息如下:</td></tr>
			<tr>
				<td width="30%">
					日期
				</td>
				<td id="createdDt">
				</td>
			</tr>
			<tr>
				<td>
					学习内容
				</td>
				<td id="studyContent">
				</td>
			</tr>
			<tr>
				<td>
					价位
				</td>
				<td id="price">
				</td>
			</tr>
			<tr>
				<td>
					教学地点
				</td>
				<td id="address">
				</td>
			</tr>
			</table>
		</div>
		<br>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<table>
			<tr><td colspan="2">老师信息如下:</td></tr>
			<tr>
				<td width="30%">
					姓名:
				</td>
				<td id="teacherName">
				</td>
			</tr>
			<tr>
				<td valign="top">
					专业:
				</td>
				<td id="teacherMajor">
				</td>
			</tr>
			<tr>
				<td valign="top">
					所获荣誉:
				</td>
				<td id="certifications">
				</td>
			</tr>
			<tr>
				<td valign="top">
					特质:
				</td>
				<td id="teacherDescription">
				</td>
			</tr>
			<tr>
				<td>
					手机号:
				</td>
				<td id="mobile">
				</td>
			</tr>
			</table>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="back" id="back">返回</button>
			<button type="button" class="btn btn-lg btn-block options" name="cancel" id="cancel">取消订单</button>
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

$(document).ready(function(){
	var rootUrl = $("#rootUrl").val();
	var openId = $("#openid").val();
	var url = "http://"+rootUrl+"/service.php?requestMethod=trandactionDetail&transactionId="+GetQueryString("transactionId");
	$.getJSON(url,function(data){
		$("#createdDt").html(data.createdDt);
		$("#studyContent").html(data.subject + " " +data.interest);
		$("#price").html(data.price);
		$("#address").html(data.expectedLocation);
		$("#teacherName").html(data.name);
		$("#teacherMajor").html(data.major);
		$("#teacherDescription").html(data.description);
		$("#certifications").html(data[0]);
		$("#mobile").html(data.mobile);
		//老师头像地址为: data.imageUrl
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
