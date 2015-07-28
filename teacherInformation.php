<?php
require_once("config.php");
if(isset($_GET["openid"])){
	$openid = trim($_GET["openid"]);
}else{
	exit();
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>老师个人信息</title>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
<!-- Loading Bootstrap -->
<link href="css/vendor/bootstrap.min.css" rel="stylesheet">
<!-- Loading Flat UI -->
<link href="css/flat-ui.min.css" rel="stylesheet">
<script src="js/vendor/jquery.min.js"></script>
<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
<script src="js/vendor/html5shiv.js"></script>
<script src="js/vendor/respond.min.js"></script>
<![endif]-->
<style>
</style>
</head>
<body>
<input type="text" name="rootUrl" id="rootUrl" value="<?php echo $rootUrl; ?>" style="display:none">
<input type="text" name="openid" id="openid" value="<?php echo $openid; ?>" style="display:none">
<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<p class="text-center">
				<font color="#48C9B0">老师个人信息</font>
			</p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4" id="head" class="text-center">
			<img src="image/loading_normal.gif" class="img-responsive" style="margin: 0 auto" name="initLoading"/>
		</div>
	</div>
	<div class="row" id="block1" style="display:none">
		<div class="col-md-4 col-md-offset-4">
			<p class="text-left">
				<font color="#48C9B0">【个人基本信息】</font>
			</p>
			<p class="text-left" id="name">	
			</p>
			<p class="text-left" id="sex">	
			</p>
			<p class="text-left" id="faculty">	
			</p>
			<p class="text-left" id="major">	
			</p>
			<p class="text-left" id="studentNumber">	
			</p>
			<p class="text-left" id="phone">	
			</p>
			<p class="text-left" id="desc">	
			</p>
		</div>
	</div>
	<div class="row" id="block2" style="display:none">
		<div class="col-md-4 col-md-offset-4">
			<p class="text-left">
				<font color="#48C9B0">【教学信息】</font>
			</p>
			<p class="text-left" id="options">	
			</p>
			<p class="text-left" id="highestGrade">	
			</p>
			<p class="text-left" id="price">	
			</p>
			<p class="text-left" id="location">	
			</p>
		</div>
	</div>
	<div class="row" id="block3" style="display:none">
		<div class="col-md-4 col-md-offset-4" id="certificate">
			<p class="text-left">
				<font color="#48C9B0">【证书】</font>
			</p>
		</div>
	</div>
	<!-- footer -->
	<!-- footer -->
	
	<!-- follow up image -->
	<div class="row" style="margin-top:10px">
		<div class="col-md-4 col-md-offset-4">
			<button type="button" class="btn btn-primary btn-lg btn-block" name="signup" id="signup">报名成为老师</button>
		</div>
	</div>
	<div class="row" id="followUpImage" style="display:none">
		<div class="col-md-4 col-md-offset-4" id="head" class="text-center">
			<img src="image/showqrcode6.jpeg" class="img-responsive" style="margin: 0 auto" name="initLoading" width="50%"/>
		</div>
	</div>
	<!-- follow up image -->
	
</div>
	<script src="js/flat-ui.min.js"></script>
	<script src="assets/js/application.js"></script>
	<script type="text/javascript">
	var rootUrl = $("#rootUrl").val();
	var typeCodes = ["A","B","C","D","E","F","SU"];
	var openid = $("#openid").val();
	
	var postData = {
		"dataType":"getTeacherInformation",
		"openid":""
	};	
	var jsonObj = "";
	var name = "";
	var sex = "";
	var faculty = "";
	var major = "";
	var studentNumber = "";
	var phone = "";
	var selfDesc = "";
	var options = "";
	var highestGrade = "";
	var price = "";
	var place = "";
	var certificate = "";
	var imageUrl = "";
	var teacherName = "";
	var sexArray = {
		"m":"男",
		"f":"女"
	};
	
	var gradeArray = {
		"grade1":"小学一年级",
		"grade2":"小学二年级",
		"grade3":"小学三年级",
		"grade4":"小学四年级",
		"grade5":"小学五年级",
		"grade6":"小学六年级",
		"grade7":"初一",
		"grade8":"初二",
		"grade9":"初三",
		"grade10":"高一",
		"grade11":"高二",
		"grade12":"高三"
	};
	
	var locationArray = {
		"location0":"不限",
		"location1":"南山区",
		"location2":"福田区",
		"location3":"罗湖区",
		"location4":"宝安区",
		"location5":"龙岗区"
	};
	var placeArray;
	var placeText = "";
	
	postData["openid"] = openid;
	$.post("teacherRegistrationService.php", postData,
   		function(data){
   			
   			jsonObj = $.parseJSON(data);
   			
   			name = jsonObj.name;
   			teacherName = jsonObj.name;
   			sex = jsonObj.gender;
   			faculty = jsonObj.faculty;
   			major = jsonObj.major;
   			studentNumber = jsonObj.studentNumber;
   			phone = jsonObj.mobile;
   			selfDesc = jsonObj.description;
   			highestGrade = jsonObj.highestGrade;
   			price = jsonObj.price;
   			place = jsonObj.address;
   			certificate = jsonObj.certificate;
   			options = jsonObj.options;
   			imageUrl = jsonObj.imageUrl;
   			
			
			$("#name").text("姓名："+name);
			$("#sex").text("性别："+sexArray[sex]);
			$("#faculty").text("学院名称："+faculty);
			$("#major").text("专业名称："+major);
			$("#studentNumber").text("学号："+studentNumber);
			$("#phone").text("手机号："+phone);
			$("#desc").text("自我描述："+selfDesc);
			
			$("#options").text("可教科目："+options.name);
			$("#highestGrade").text("能教的最高年级："+gradeArray[highestGrade]);
			$("#price").text("最低时薪："+price);
			placeArray = place.split(",");
			for(var j = 0;j < placeArray.length;j++){
				if(j == 0){
					placeText = placeText + locationArray[placeArray[j]];
				}else{
					placeText = placeText + "," + locationArray[placeArray[j]];
				}
			}
			$("#location").text("能教区域："+placeText);
			
			
			var desc = certificate.desc;
			var imgUrl = certificate.imgUrl;
			var length = desc.length;
			//certificateCount = length+1;

			for(var i = 0;i < length;i++){
				$("#certificate").append(
					$("<p />").attr("class", "text-left").text(desc[i])
				);
				$("#certificate").append(
					$("<img />").attr("src", imgUrl[i]).attr("class", "img-responsive").attr("style", "margin: 0 auto")
				);
			}
			
			$('img[name*="initLoading"]').remove();
			
			var newHeadUrl = imageUrl+"?imageView2/1/w/500/h/500/q/100"+"/timestamp="+new Date().getTime();
			
			$("#head").append(
				$("<img />").attr("src", newHeadUrl).attr("class", "img-responsive img-circle").attr("width", "50%").attr("style", "margin: 0 auto")
			);
			
			$("#block1").show();$("#block2").show();$("#block3").show();
			
			for(var i = 0;i < typeCodes.length;i++){
				createOptions(typeCodes[i],typeCodes[i], jsonObj.options.code);
			}
			
     	}
   	);
   	$("#signup").click(function(){
   		$(this).text("点击识别下方二维码关注我教你学");
   		$("#followUpImage").show();
   	});
	</script>
</div>
</body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
wx.config({
    debug: false,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
    'onMenuShareTimeline',
    'onMenuShareAppMessage'
    ]
});
wx.ready(function () {
    wx.onMenuShareAppMessage({
		title: "我教你学老师信息",
		desc: '你教我学老师信息',
		link: "http://www.ilearnnn.com/teacherInformation.php?openid=" + openid,
		imgUrl: "http://7xk9ts.com2.z0.glb.qiniucdn.com/"+openid+"_head"+"?imageView2/1/w/500/h/500/q/100"
	});
	wx.onMenuShareTimeline({
		title: "我教你学老师信息",
		desc: '我教你学老师信息',
		link: "http://www.ilearnnn.com/teacherInformation.php?openid=" + openid,
		imgUrl: "http://7xk9ts.com2.z0.glb.qiniucdn.com/"+openid+"_head"+"?imageView2/1/w/500/h/500/q/100"
	});
});
	
</script>
</html>



















































