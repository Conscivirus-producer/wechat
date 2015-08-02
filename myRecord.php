<?php
require_once("config.php");
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
    $openid = 'obS35vtzdcSdflfnVKJDhy74apiI';
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
<link href="css/myrecord.css" rel="stylesheet">
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
	<div class="row" style="" id="q0">
	</div>
	<div class="col-xs-12 text-center" style="height: 40px;margin-top: 20px;color: #2cb298;"><div style="font-size: 16px">我的纪录</div></div>
	<table class="table table-striped my-record-table" style="box-shadow:0 0 10px #333;font-size:12px;background-color: #2cb298;border-radius: 5px">
      <thead style="color: white;">
        <tr>
          <th>订单号</th>
          <th>课程</th>
          <th>价格</th>
          <th>时间</th>
          <th>状态</th>
        </tr>
      </thead>
      <tbody id="records">
      </tbody>
    </table>
	
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
	var url = "http://"+rootUrl+"/service.php?requestMethod=myRecord&parentOpenId="+openId;
	$.getJSON(url,function(data){
		var transactionId = data.transactionId;
		var length = transactionId.length;
		for(var i = 0;i < length;i++){
			var course;
			if(data.subject[i] != "" && data.interest[i] != ""){
				course = data.interest[i]+','+data.subject[i];
			}else if(data.interest[i] != ""){
				course = data.interest[i];
			}else if(data.subject[i] != ""){
				course =data.subject[i];
			}
			var prize;
			if(data.fee[i]!=""){
				prize = data.fee[i];
			}else{
				prize = "待定";
			};
			var createdDate = data.createdDt[i].substring(0,10);
			var status = data.status[i].substring(2);
			
			var tableContent = $("<tr></tr>");
			var th = $("<th>").attr("scope", "row").text(data.transactionId[i]);
			var td1 = $("<td>").text(course);
			var td2 = $("<td>").text(prize);
			var td3 = $("<td>").text(createdDate);
			var td4 = $("<td>").text(status);
			td4.append("<div class='arrow'></div>");
			tableContent.append(th, td1, td2, td3, td4);
			tableContent.click(function(){
				window.location.href="myRecordDetail.php?transactionId="+$(this).find('th').text();
			});
			$("#records").append(tableContent);
		};
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
