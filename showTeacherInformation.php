<?php
require_once("config.php");
if (isset($_GET['code'])){
    $code = $_GET['code'];
    $access_token_get_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";
    $access_token_json = file_get_contents($access_token_get_url); 
    $json_obj = json_decode($access_token_json,true);
    $openid = $json_obj["openid"];
}else{
	//need to be modified to show hint and qrcode image
    exit("NO CODE");
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
<script src="js/jquery.ajaxfileupload.js"></script>
<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
<script src="js/vendor/html5shiv.js"></script>
<script src="js/vendor/respond.min.js"></script>
<![endif]-->
</head>
<body>
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
		<div class="col-md-4 col-md-offset-4" id="head">
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
	<div class="row" style="margin-top:10px">
		<div class="col-md-4 col-md-offset-4">
		
		</div>
	</div>
	<script src="js/flat-ui.min.js"></script>
	<script src="assets/js/application.js"></script>
	<script type="text/javascript">
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
	var desc = "";
	var options = "";
	var highestGrade = "";
	var price = "";
	var place = "";
	var certificate = "";
	var imageUrl = "";
	
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
   			sex = jsonObj.gender;
   			faculty = jsonObj.faculty;
   			major = jsonObj.major;
   			studentNumber = jsonObj.studentNumber;
   			phone = jsonObj.mobile;
   			desc = jsonObj.description;
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
			$("#desc").text("自我描述："+desc);
			
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

			for(var i = 0;i < length;i++){
				$("#certificate").append(
					$("<p />").attr("class", "text-left").text(desc[i])
				);
				$("#certificate").append(
					$("<img />").attr("src", imgUrl[i]).attr("class", "img-responsive img-circle").attr("style", "margin: 0 auto")
				);
			}
			
			$('img[name*="initLoading"]').remove();
			
			$("#head").append(
				$("<img />").attr("src", imageUrl).attr("class", "img-responsive").attr("style", "margin: 0 auto")
			);
			
			$("#block1").show();
			$("#block2").show();
			$("#block3").show();
     	}
   	);
	</script>
</div>
</body>
</html>



















































