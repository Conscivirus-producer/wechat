<?php
require_once("config.php");
require_once("processUtil.php");
$codeParser = new CodeParser();
session_start();
if (isset($_GET['code'])){
    $code = $_GET['code'];
    $access_token_get_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";
    $access_token_json = file_get_contents($access_token_get_url); 
    $json_obj = json_decode($access_token_json,true);
    $openid = $json_obj["openid"];
}else if($_SESSION['openid'] == ''){
	//$openid = "11111111";
	//need to be modified to show hint and qrcode image
    //echo "NO CODE";
    //$openid = 'obS35vtzdcSdflfnVKJDhy74apiI';
    exit("no openid provided!");
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
<link href="css/myRecordDetail.css" rel="stylesheet" />
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
		<table class="table table-striped my-record-detail" style="box-shadow:0 0 10px #333;font-size:12px;background-color: #2cb298;border-radius: 5px;margin-top:20px">
			<thead>
				<tr>
		          <td style="color:white">订单详情</td>
		        </tr>
			</thead>
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
			<tr>
				<td>
					状态
				</td>
				<td id="status">
				</td>
			</tr>
		</table>

		<table class="table table-striped my-record-detail" style="box-shadow:0 0 10px #333;font-size:12px;background-color: #2cb298;border-radius: 5px;margin-top:20px;margin-bottom: 60px">
			<thead>
				<tr>
		          <td style="color:white" id="teacher-info">老师信息</td>
		        </tr>
			</thead>
			<!-- avatar -->
			<tr id="recordDetailAvatar" style="display: none">
				<td colspan="2" align="center">
					<img id="recordAvatarImg" class="img-circle" />
				</td>
			</tr>
			<tr>
				<td>
					姓名:
				</td>
				<td id="teacherName">
				</td>
			</tr>
			<tr>
				<td>
					专业:
				</td>
				<td id="teacherMajor">
				</td>
			</tr>
			<tr>
				<td>
					所获荣誉:
				</td>
				<td id="certifications">
				</td>
			</tr>
			<tr>
				<td>
					特质:
				</td>
				<td id="teacherDescription" style="width: 70%">
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
	
	<!-- <div class="row">
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="back" id="back">返回</button>
			<button type="button" class="btn btn-lg btn-block options" name="cancel" id="cancel" style="display:none">取消订单</button>
		</div>
	</div> -->
	
	<div class="button-group">
		<div class="col-xs-6 line">
			<button type="button" class="btn btn-lg btn-block"  name="back" id="back">返回</button>
		</div>
		<div class="col-xs-6">
			<button type="button" class="btn btn-lg btn-block" name="cancel" id="cancel" >取消订单</button>
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
var transactionId;
var rootUrl = $("#rootUrl").val();
var openId = $("#openid").val();

$(document).ready(function(){
	transactionId = GetQueryString("transactionId");
	var url = "http://"+rootUrl+"/service.php?requestMethod=trandactionDetail&transactionId="+transactionId;
	$.getJSON(url,function(data){
		$("#createdDt").html(data.createdDt);
		$("#status").html(data.statusDescription.substring(2));
		if(data.status != 'C'){
			$("#cancel").attr("style", "");
		}
		$("#studyContent").html(data.subject + " " +data.interest);
		if(data.price == null){
			var price = "待定";
		}
		$("#price").html(price);
		$("#address").html(data.expectedLocation);
		if(data.name == null){
			$("#teacher-info").text("教师.待定");
		}
		//if teacher has been confirmed
		if(data.openid != null){
			$("#recordDetailAvatar").show();
			var avatarUrl= "http://7xk9ts.com2.z0.glb.qiniucdn.com/"+data.openid+"_head?imageView2/1/w/65/h/65/q/100"
			$("#recordAvatarImg").attr("src", avatarUrl);
		}
		$("#teacherName").html(data.name);
		$("#teacherMajor").html(data.major);
		$("#teacherDescription").html(data.description);
		$("#certifications").html(data.certifications);
		$("#mobile").html(data.mobile);
		//老师头像地址为: data.imageUrl
	});
});

$("#back").click(function(){
	//self.location=document.referrer;
	history.back();
});

$("#cancel").click(function(){
	if(window.confirm('你确定要取消交易吗？')){
		var url = "http://"+rootUrl+"/service.php?requestMethod=cancelTransaction&transactionId="+transactionId;
		$.getJSON(url,function(data){
			//self.location=document.referrer;
			history.back();	
		});
	}
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
