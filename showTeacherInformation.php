<?php
require_once("config.php");
require_once 'vendor/autoload.php';
require_once "jssdk.php";
use Qiniu\Auth;

$jssdk = new JSSDK($appid, $secret);
$signPackage = $jssdk->GetSignPackage();
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

$accessKey = 'k7HBysPt-HoUz4dwPT6SZpjyiuTdgmiWQE-7qkJ4';
$secretKey = 'BuaBzxTxNsNUBSy1ZvFUAfUbj8GommyWbfJ0eQ2R';
$auth = new Auth($accessKey, $secretKey);

$bucket = 'wojiaonixue';
$key = $openid."_head";
$token = $auth->uploadToken($bucket,$key,3600,null,true);

$accessKey = 'k7HBysPt-HoUz4dwPT6SZpjyiuTdgmiWQE-7qkJ4';
$secretKey = 'BuaBzxTxNsNUBSy1ZvFUAfUbj8GommyWbfJ0eQ2R';
$auth2 = new Auth($accessKey, $secretKey);

$bucket2 = 'wojiaonixue';
$certificate_token = $auth2->uploadToken($bucket2,null,3600,null,true);
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
<input type="text" name="rootUrl" id="rootUrl" value="<?php echo $rootUrl; ?>" style="display:none">
<input type="text" name="openid" id="openid" value="<?php echo $openid; ?>" style="display:none">
<input type="text" name="token" id="token" value="<?php echo $token; ?>" style="display:none">
<input type="text" name="certificate_token" id="certificate_token" value="<?php echo $certificate_token; ?>" style="display:none">
<div class="container">
	<!-- showInformationPanel -->
	<div id="showInformationPanel">
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
	<div class="row" id="interests" style="margin-top:5px">
		<div class="col-md-4 col-md-offset-4">
			<button type="button" class="btn btn-primary btn-lg btn-block" name="toModify" id="toModify">修改个人信息</button>
		</div>
	</div>
	</div>
	<!-- showInformationPanel -->
	
	<!-- modifyInformationPanel -->
	<div id="modifyInformationPanel" style="display:none">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<p class="text-left">
				<font color="#48C9B0">【修改个人基本信息】</font>
			</p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-2">
			<div class="form-group">
				<label for="update_name">姓名</label>
				<input type="text" class="form-control" name="update_name" id="update_name" placeholder="请输入姓名">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="update_sex">性别</label>
				<select class="form-control" name="update_sex" id="update_sex">
  					<option value="m">男</option>
  					<option value="f">女</option>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-2">
			<div class="form-group">
				<label for="update_school">学院名称</label>
				<input type="text" class="form-control" name="update_school" id="update_school" placeholder="请输入学院名称">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="update_major">专业名称</label>
				<input type="text" class="form-control" name="update_major" id="update_major" placeholder="请输入专业名称">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-2">
			<div class="form-group">
				<label for="update_studentNumber">学号</label>
				<input type="text" class="form-control" name="update_studentNumber" id="update_studentNumber" placeholder="请输入真实的学号">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-2">
			<div class="form-group">
				<label for="update_phone">手机号</label>
				<input type="text" class="form-control" name="update_phone" id="update_phone" placeholder="请输入手机号码">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="update_desc">自我介绍【不少于30个字】</label>
				<!--<input type="text" class="form-control" name="desc" id="desc" placeholder="可介绍自己的性格，经验，优点，获奖经历等">-->
				
				<textarea class="form-control" rows="3" name="update_desc" id="update_desc" placeholder="可介绍自己的性格，经验，优点，获奖经历等"></textarea>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<p class="text-left">
				<font color="#48C9B0">【修改可教的课程（多选）】</font>
			</p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-group">
				<label for="SU">学科辅导【可多选】</label>
				<select name="SU" id="SU" multiple="multiple" class="form-control">
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-group">
				<label for="A">乐器与舞蹈【可多选】</label>
				<select name="A" id="A" multiple="multiple" class="form-control">
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-group">
				<label for="B">体育运动【可多选】</label>
				<select name="B" id="B" multiple="multiple" class="form-control">
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-group">
				<label for="C">书法与美术【可多选】</label>
				<select name="C" id="C" multiple="multiple" class="form-control">
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-group">
				<label for="D">益智类【可多选】</label>
				<select name="D" id="D" multiple="multiple" class="form-control">
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-group">
				<label for="E">演讲与口才【可多选】</label>
				<select name="E" id="E" multiple class="form-control">
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-group">
				<label for="F">趣味课程【可多选】</label>
				<select name="F" id="F" multiple class="form-control">
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-group">
				<label for="otheroptions">其它</label>
				<input type="text" class="form-control" name="otheroptions" id="otheroptions" placeholder="其它你能教的,以空格分格">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<p class="text-left">
				<font color="#48C9B0">【修改其它期望值】</font>
			</p>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label for="update_grade">最高能教的年级</label>
				<select class="form-control" name="update_grade" id="update_grade">
  					<option value="grade12">高三</option>
  					<option value="grade11">高二</option>
  					<option value="grade10">高一</option>
  					<option value="grade9">初三</option>
  					<option value="grade8">初二</option>
  					<option value="grade7">初一</option>
  					<option value="grade6">小学六年级</option>
  					<option value="grade5">小学五年级</option>
  					<option value="grade4">小学四年级</option>
  					<option value="grade3">小学三年级</option>
  					<option value="grade2">小学二年级</option>
  					<option value="grade1">小学一年级</option>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-2">
			<div class="form-group">
				<label for="update_price">期望的最低时薪</label>
				<input type="text" class="form-control" name="update_price" id="update_price" placeholder="请输入时薪">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-2">
			<div class="form-group">
				<label for="update_location">可接受的地点</label>
				<select name="update_location" id="update_location" multiple class="form-control">
					<option value="location0">不限</option>
  					<option value="location1">南山区</option>
  					<option value="location2">福田区</option>
  					<option value="location3">罗湖区</option>
  					<option value="location4">宝安区</option>
  					<option value="location5">龙岗区</option>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-2" id="image_upload_div">
			<label>上传新头像(要求本人头像，五官清晰):</label><br>
			<span class="sl-custom-file">
    			<button type="button" class="btn btn-default btn-lg" id="trigger_head_upload">
  					<span class="fui-user"></span>
  					<span class="fui-plus"></span>
				</button>
   			 	<input type="file" name="head_upload" id="head_upload" class="ui-input-file"/>
			</span>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-2" id="certificate_delete">
			<label>删除/修改证书:</label><br>
			<!--<input class="form-control" id="disabledInput" type="text" placeholder="Disabled input here..." disabled>
			<button type="button" class="btn btn-default">
  				<span class="fui-new">
			</button>
			<button type="button" class="btn btn-default" style="margin-left:1px">
				<span class="fui-trash"></span>
			</button>-->
			
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-2" id="certificate_upload_div">
			<label for="certificate_desc">添加证书(要求输入证书的名称/描述，可传多张):</label>
			<input type="text" class="form-control" name="certificate_desc" id="certificate_desc" placeholder="请输入证书的名称/描述" style="margin-bottom:5px">
			<span class="sl-custom-file">
    			<button type="button" class="btn btn-default btn-lg" id="trigger_certificate_upload">
  					<span class="fui-document"></span>
  					<span class="fui-plus"></span>
				</button>
   			 	<input type="file" name="certificate_upload" id="certificate_upload" class="ui-input-file"/>
			</span>
		</div>
	</div>
	
	
	<div class="row" id="interests" style="margin-top:5px">
		<div class="col-md-4 col-md-offset-4">
			<button type="button" class="btn btn-primary btn-lg btn-block" name="update_submit" id="update_submit">提交</button>
		</div>
	</div>
	<div class="row" style="margin-top:5px">
		<div class="col-md-4 col-md-offset-4">
			<button type="button" class="btn btn-primary btn-lg btn-block" name="backToInformation" id="backToInformation">返回</button>
		</div>
	</div>
	</div>
	<!-- modifyInformationPanel -->
	<!-- footer -->
	<div class="row" style="margin-top:10px">
		<div class="col-md-4 col-md-offset-4">
		
		</div>
	</div>
	<!-- footer -->
	<script src="js/flat-ui.min.js"></script>
	<script src="assets/js/application.js"></script>
	<script type="text/javascript">
	var rootUrl = $("#rootUrl").val();
	var typeCodes = ["A","B","C","D","E","F","SU"];
	var openid = $("#openid").val();
	var certificateCount = "";
	
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
				var deleteid = imgUrl[i];
				$("#certificate").append(
					$("<p />").attr("class", "text-left").text(desc[i])
				);
				$("#certificate").append(
					$("<img />").attr("src", imgUrl[i]).attr("class", "img-responsive").attr("style", "margin: 0 auto")
				);
				$("#certificate_delete").append(
					$("<input>").attr("class","form-control").attr("type","text").attr("value",desc[i])
				);
				$("<button>").appendTo($("#certificate_delete")).attr("type","button").attr("class","btn btn-default").html("<span style='display:none' class='deleteid'>"+imgUrl[i]+"</span>"+"<span class='fui-new'></span>").bind({
					click:function(e){
						var updateVal = $(this).prev().val();
						var updateId = $(this).children(".deleteid").text();
						var postData = {
							"updateId" : "",
							"updateVal" : "",
							"dataType" : "updateCertificateDesc"
						};
						postData["updateId"] = updateId;
						postData["updateVal"] = updateVal;
						$.post("teacherRegistrationService.php", postData,
   							function(data){
   								alert("证书名称/描述修改成功");
     						}
   						);
					}
				});
				$("<button>").appendTo($("#certificate_delete")).attr("type","button").attr("class","btn btn-default").attr("style","margin-left:1px").html("<span style='display:none' class='deleteid'>"+imgUrl[i]+"</span>"+"<span class='fui-trash'></span>").bind({
					click:function(e){
						var $button = $(this);
						var r=confirm("真的要删除这个证书吗？");
  						if (r==true){
  							var deleteId = $(this).children(".deleteid").text();
  							var postData = {
								"deleteId" : "",
								"dataType" : "deleteCertificate"
							};
							postData["deleteId"] = deleteId;
							$.post("teacherRegistrationService.php", postData,
   								function(data){
   									alert("证书删除成功");
   									$button.prev().remove();
									$button.prev().remove();
									$button.remove();
     							}
   							);
  						}
					}
				});
			}
			
			$('img[name*="initLoading"]').remove();
			
			var newHeadUrl = imageUrl+"?imageView2/1/w/500/h/500/q/100"+"/timestamp="+new Date().getTime();
			
			$("#head").append(
				$("<img />").attr("src", newHeadUrl).attr("class", "img-responsive img-circle").attr("width", "50%").attr("style", "margin: 0 auto")
			);
			
			$("#block1").show();$("#block2").show();$("#block3").show();
			
			//initialize the modifyInformationPanel
			$("#update_name").val(name);$("#update_sex").val(sex);$("#update_school").val(faculty);
			$("#update_major").val(major);$("#update_studentNumber").val(studentNumber);$("#update_phone").val(phone);
			$("#update_desc").val(selfDesc);$("#update_grade").val(highestGrade);$("#update_price").val(price);
			$("#update_location").val(place.split(","));
			function createOptions(typeCode, optionId, selectedOptions){
				var url = "http://"+rootUrl+"/service.php?typeCode="+typeCode;
				$.getJSON(url,function(data){
					//存储所有option data
					optionData = data;
					var code = data.code;
					var name = data.name;
					var length = code.length;
					var choosedOptions = new Array();
					for(var i = 0;i < length;i++){
						var optionCode = code[i];
						var optionName = name[i];
						$("#"+optionId).append("<option value='"+optionCode+"'>"+optionName+"</option>");
						if($.inArray(optionCode,selectedOptions) != -1){
							choosedOptions.push(optionCode);
						}
					}
					$("#"+typeCode).val(choosedOptions);
				});
			}
			for(var i = 0;i < typeCodes.length;i++){
				createOptions(typeCodes[i],typeCodes[i], jsonObj.options.code);
			}
			
     	}
   	);
   	$("#toModify").click(function(){
   		$("#showInformationPanel").hide();
   		$("#modifyInformationPanel").show();
   	});
   	$("#update_submit").click(function(){
   		var name = $("#update_name").val();
		var sex = $("#update_sex").val();
		var school = $("#update_school").val();
		var major = $("#update_major").val();
		var studentNumber = $("#update_studentNumber").val();
		var phone = $("#update_phone").val();
		var desc = $("#update_desc").val();
		var allOptions = new Array();
		var price = $("#update_price").val();					//期望的最低时薪					
		var location = $("#update_location").val();			//可接受的教学地点		
		var highestGrade = $("#update_grade").val();			//最高能教的年级
		var otheroptions = $("#otheroptions").val();	//其它能教的学科
		
		for(var i = 0;i < typeCodes.length;i++){
	 		var options = $("#"+typeCodes[i]).val();
	 		if(options != null){
				allOptions = allOptions.concat(options);
			}
		}
		if(name == ""){
			alert("请输入姓名");
			$("#update_name").focus();
		}else if(school == ""){
			alert("请输入学院名称");
			$("#update_school").focus();
		}else if(major == ""){
			alert("请输入专业名称");
			$("#update_major").focus();
		}else if(studentNumber == ""){
			alert("请输入真实的学号");
			$("#update_studentNumber").focus();
		}else if(!validatePhone(phone)){
			alert("请输入正确的手机号");
			$("#update_phone").focus();
		}else if(desc == ""){
			alert("请输入自我介绍");
			$("#update_desc").focus();
		}else if(calculateLength(desc) < 30){
			alert("自我介绍不少于30个字，已经"+calculateLength(desc)+"个字了");
			$("#update_desc").focus();
		}else if(allOptions.length == 0){
			alert("请至少选择一个可教的课程");
			$("#A").focus();
		}else if(price == ""){
			alert("请输入期望的最低时薪");
			$("#update_price").focus();
		}else if(location == null){
			alert("请选择可接受的教学地点");
			$("#update_location").focus();
		}else{
			var postData = {
				openid:"",
				name: "",
				sex: "",
				school: "",
				major: "",
				studentNumber: "",
				phone: "",
				desc: "",
				options: [],
				otheroptions: [],
				price: "",
				location: [],
				highestGrade:"",
				dataType:"updateTeacherInformation"
			};
			postData.openid = openid;
			postData.name = name;
			postData.sex = sex;
			postData.school = school;
			postData.major = major;
			postData.studentNumber = studentNumber;
			postData.phone = phone;
			postData.desc = desc;
			postData.options = allOptions;
		
			postData.otheroptions = otheroptions;
			postData.price = price;
			if($.inArray("location0",location) != -1){
				location = ["location0"];
			}
			postData.location = location;
			postData.highestGrade = highestGrade;
			$.post("teacherRegistrationService.php", postData,
   				function(data){
     				alert("数据修改成功！");
     				//$("#modifyInformationPanel").hide();
   					//$("#showInformationPanel").show();
   					window.location.href = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx9855e946fbde03ac&redirect_uri=http://"+rootUrl+"/showTeacherInformation.php"+"?timestamp="+new Date().getTime()+"&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
     				//window.location.href = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx9855e946fbde03ac&redirect_uri=http://www.ilearnnn.com/showTeacherInformation.php&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
     			}
   			);
		}
   	});
   	function validatePhone(phone){
		var reg = /^(13[0-9]|14[0-9]|15[0-9]|18[0-9])\d{8}$/;
		if (reg.test(phone)) {
			return true;
		}else{
			return false;
		}
	}
	function calculateLength(str){
		str=str.replace(/[\ |\~|\`|\！|\@|\#|\$|\%|\^|\&|\*|\(|\)|\-|\_|\+|\=|\||\\|\[|\]|\{|\}|\;|\:|\"|\'|\，|\<|\。|\>|\/|\？]/g,""); 
		return str.length;
	}
   	$("#backToInformation").click(function(){
   		$("#modifyInformationPanel").hide();
   		$("#showInformationPanel").show();
   	});
   	
   	$("#certificate_upload").click(function(){
		certificateDesc = $("#certificate_desc").val();
		if(certificateDesc == ""){
			alert("请先输入输入证书的名称/描述");
			$("#certificate_desc").focus();
			return false;
		}	
	});
	
   	$(document).ready(function() {
    var Qiniu_UploadUrl = "http://up.qiniu.com";
    //var progressbar = $("#progressbar"),
    //    progressLabel = $(".progress-label");
   /* progressbar.progressbar({
        value: false,
        change: function() {
            progressLabel.text(progressbar.progressbar("value") + "%");
        },
        complete: function() {
            progressLabel.text("Complete!");
        }
    });*/
    $("#head_upload").change(function() {
        //普通上传
        var Qiniu_upload = function(f, token, key) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', Qiniu_UploadUrl, true);
            var formData, startDate;
            formData = new FormData();
            if (key !== null && key !== undefined) formData.append('key', key);
            formData.append('token', token);
            formData.append('file', f);
            var taking;
            /*xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    var nowDate = new Date().getTime();
                    taking = nowDate - startDate;
                    var x = (evt.loaded) / 1024;
                    var y = taking / 1000;
                    var uploadSpeed = (x / y);
                    var formatSpeed;
                    if (uploadSpeed > 1024) {
                        formatSpeed = (uploadSpeed / 1024).toFixed(2) + "Mb\/s";
                    } else {
                        formatSpeed = uploadSpeed.toFixed(2) + "Kb\/s";
                    }
                    var percentComplete = Math.round(evt.loaded * 100 / evt.total);
                    //progressbar.progressbar("value", percentComplete);
                    $(".progress-bar").css("width",percentComplete);
                    // console && console.log(percentComplete, ",", formatSpeed);
                }
            }, false);*/

            xhr.onreadystatechange = function(response) {
                if (xhr.readyState == 4 && xhr.status == 200 && xhr.responseText != "") {
                    var blkRet = JSON.parse(xhr.responseText);
                    console && console.log(blkRet);
                    //$("#dialog").html(xhr.responseText).dialog();
                    imageUploaded = true;
                    $('img[src*="loading_normal.gif"]').remove();
                    $("#image_upload_div").append(
						$("<img />").attr("src", "http://7xk9ts.com2.z0.glb.qiniucdn.com/"+openid+"_head"+"?imageView2/1/w/500/h/500/q/100"+"/timestamp="+new Date().getTime()).attr("class", "img-responsive").attr("width", "50%").attr("style", "margin: 0 auto")
					);
					$("#head_upload").prop('disabled', true);
                    alert("头像修改成功");
                } else if (xhr.status != 200 && xhr.responseText) {
					alert("头像上传失败，请重新上传");
					$('img[src*="loading_normal.gif"]').remove();
                }
            };
            startDate = new Date().getTime();
            //$("#progressbar").show();
            xhr.send(formData);
        };
        var token = $("#token").val();
        if ($("#head_upload")[0].files.length > 0 && token != "") {
        	$("#image_upload_div").append($("<br />"));
        	$("#image_upload_div").append(
				$("<img />").attr("src", "image/loading_normal.gif").attr("class", "img-responsive").attr("style", "margin: 0 auto")
			);
            Qiniu_upload($("#head_upload")[0].files[0], token, openid+"_head");
        } else {
            console && console.log("form input error");
        }
    });
    
     $("#certificate_upload").change(function() {
        //普通上传
        var Qiniu_upload = function(f, token, key) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', Qiniu_UploadUrl, true);
            var formData, startDate;
            formData = new FormData();
            if (key !== null && key !== undefined) formData.append('key', key);
            formData.append('token', token);
            formData.append('file', f);
            var taking;
            /*xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    var nowDate = new Date().getTime();
                    taking = nowDate - startDate;
                    var x = (evt.loaded) / 1024;
                    var y = taking / 1000;
                    var uploadSpeed = (x / y);
                    var formatSpeed;
                    if (uploadSpeed > 1024) {
                        formatSpeed = (uploadSpeed / 1024).toFixed(2) + "Mb\/s";
                    } else {
                        formatSpeed = uploadSpeed.toFixed(2) + "Kb\/s";
                    }
                    var percentComplete = Math.round(evt.loaded * 100 / evt.total);
                    //progressbar.progressbar("value", percentComplete);
                    $(".progress-bar").css("width",percentComplete);
                    // console && console.log(percentComplete, ",", formatSpeed);
                }
            }, false);*/

            xhr.onreadystatechange = function(response) {
                if (xhr.readyState == 4 && xhr.status == 200 && xhr.responseText != "") {
                    var blkRet = JSON.parse(xhr.responseText);
                    console && console.log(blkRet);
                    
                    var postData = {
                    	dataType: "certificateRecord",
                    	teacherOpenId: "",
                    	description: "",
                    	imageUrl: ""
                    };
                    postData.teacherOpenId = openid;
                    postData.description = certificateDesc;
                    postData.imageUrl = "http://7xk9ts.com2.z0.glb.qiniucdn.com/"+openid+"_certificate"+"_"+certificateCount;
                    
                    $.post("teacherRegistrationService.php", postData,
   						function(data){
   							$('img[name*="loading'+certificateCount+'"]').remove();
   							$("#certificate_upload_div").append(
								$("<img />").attr("src", "http://7xk9ts.com2.z0.glb.qiniucdn.com/"+openid+"_certificate"+"_"+certificateCount).attr("class", "img-responsive").attr("style", "margin: 0 auto")
							);
     						certificateUploaded = true;
                    		//certificateCount++;
                    		$("#certificate_desc").val("");
                    		alert("证书添加成功");
     					}
   					);
                } else if (xhr.status != 200 && xhr.responseText) {
					alert("证书上传失败，请重新上传");
					$('img[name*="loading'+certificateCount+'"]').remove();
                }
            };
            startDate = new Date().getTime();
            //$("#progressbar").show();
            xhr.send(formData);
        };
        var token = $("#certificate_token").val();
        if ($("#certificate_upload")[0].files.length > 0 && token != "") {
        	//certificateCount使得删除图片不方便，修改成unix时间戳
        	certificateCount = new Date().getTime();
        	$("#certificate_upload_div").append($("<br />"));
        	$("#certificate_upload_div").append(
				$("<img />").attr("src", "image/loading_normal.gif").attr("class", "img-responsive").attr("style", "margin: 0 auto").attr("name", "loading"+certificateCount)
			);
            Qiniu_upload($("#certificate_upload")[0].files[0], token, openid+"_certificate"+"_"+certificateCount);
        } else {
            console && console.log("form input error");
        }
    })
    });
    
    $("#update_location").change(function(){
    	if($.inArray("location0",$(this).val()) != -1){
    		$(this).val(["location0"]);
    	}
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



















































