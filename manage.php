<?php
if (isset($_GET['code'])){
    $code = $_GET['code'];
    $access_token_get_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx9855e946fbde03ac&secret=a185dd60de19330b8eaaadf4d8ae00ef&code=".$code."&grant_type=authorization_code";
    $access_token_json = file_get_contents($access_token_get_url); 
    $json_obj = json_decode($access_token_json,true);
    $openid = $json_obj["openid"];
}else{
	//need to be modified to show hint and qrcode image
    //exit("NO CODE");
    $openid = 'obS35vk9Hqwl4WZXsosjxm_hckKQ';
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>老师数据录入</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
				老师数据录入
			</p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<p class="text-left">
				<font color="#48C9B0">【个人基本信息】</font>
			</p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-2">
			<div class="form-group">
				<label for="name">姓名</label>
				<input type="text" class="form-control" name="name" id="name" placeholder="请输入姓名">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="sex">性别</label>
				<select class="form-control" name="sex" id="sex">
  					<option value="m">男</option>
  					<option value="f">女</option>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-2">
			<div class="form-group">
				<label for="school">学院名称</label>
				<input type="text" class="form-control" name="school" id="school" placeholder="请输入学院名称">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="major">专业名称</label>
				<input type="text" class="form-control" name="major" id="major" placeholder="请输入专业名称">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-2">
			<div class="form-group">
				<label for="studentNumber">学号</label>
				<input type="text" class="form-control" name="studentNumber" id="studentNumber" placeholder="请输入真实的学号">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-2">
			<div class="form-group">
				<label for="phone">手机号</label>
				<input type="text" class="form-control" name="phone" id="phone" placeholder="请输入手机号码">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="desc">自我介绍</label>
				<input type="text" class="form-control" name="desc" id="desc" placeholder="简短的自我介绍，以及获奖证书，过往成绩之类 的">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<p class="text-left">
				<font color="#48C9B0">【选择可教的课程（多选）】</font>
			</p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-group">
				<label for="SU">学科辅导</label>
				<select class="form-control" name="SU" id="SU" multiple="multiple">
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-group">
				<label for="A">乐器与舞蹈</label>
				<select class="form-control" name="A" id="A" multiple="multiple">
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-group">
				<label for="B">体育运动</label>
				<select class="form-control" name="B" id="B" multiple="multiple">
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-group">
				<label for="C">书法与美术</label>
				<select class="form-control" name="C" id="C" multiple="multiple">
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-group">
				<label for="D">益智类</label>
				<select class="form-control" name="D" id="D" multiple="multiple">
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-group">
				<label for="E">演讲与口才</label>
				<select class="form-control" name="E" id="E" multiple="multiple">
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-group">
				<label for="F">趣味课程</label>
				<select class="form-control" name="F" id="F" multiple="multiple">
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
				<font color="#48C9B0">【选择其它期望值】</font>
			</p>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label for="grade">最高能教的年级</label>
				<select class="form-control" name="grade" id="grade">
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
				<label for="price">期望的最低时薪</label>
				<input type="text" class="form-control" name="price" id="price" placeholder="请输入时薪">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-2">
			<div class="form-group">
				<label for="location">可接受的地点</label>
				<select class="form-control" name="location" id="location" multiple="multiple">
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
		<div class="col-md-4 col-md-offset-2">
			<form method="post" action="" enctype="multipart/form-data">
				<label>上传头像(要求本人头像，五官清晰): <input type="file" name="file" id="image_upload" /></label>
				<div id="uploads">

				</div>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-2">
			<form method="post" action="" enctype="multipart/form-data">
				<label for="demo1">上传证书: <input type="file" name="file" id="certificate_upload" /></label>
				<div id="uploads">

				</div>
			</form>
		</div>
	</div>
	<div class="row" id="interests" style="margin-top:5px">
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
var rootUrl = "www.hehe.life";
//rootUrl = "localhost";
var typeCodes = ["A","B","C","D","E","F","SU"];
var url = "http://"+rootUrl+"/service.php?typeCode="+$(this).attr("id");
var optionData;

//openid, 上传图像时用来标记，上传证书时也要用来标记
var openid = $("#openid").val();

var certificateCount = 1;
var imageUploaded = false;
var certificateUploaded = false;


function createOptions(typeCode, optionId){
	var url = "http://"+rootUrl+"/service.php?typeCode="+typeCode;
	$.getJSON(url,function(data){
		//存储所有option data
		optionData = data;
		var code = data.code;
		var name = data.name;
		var length = code.length;
		for(var i = 0;i < length;i++){
			var optionCode = code[i];
			var optionName = name[i];
			$("#"+optionId).append("<option value='"+optionCode+"'>"+optionName+"</option>");
			//<input type="text" class="form-control" name="studentNumber" id="studentNumber" placeholder="你能教，但是在上面的选项找不到的">
		}
	});
}
for(var i = 0;i < typeCodes.length;i++){
	createOptions(typeCodes[i],typeCodes[i]);
}
$("#submit").click(function(){
	var name = $("#name").val();
	var sex = $("#sex").val();
	var school = $("#school").val();
	var major = $("#major").val();
	var studentNumber = $("#studentNumber").val();
	var phone = $("#phone").val();
	var desc = $("#desc").val();
	var allOptions = new Array();
	var price = $("#price").val();
	var location = $("#location").val();
	var highestGrade = $("#grade").val();
	var otheroptions = $("#otheroptions").val();
	alert(otheroptions);
	//var imageName = $("#file").val();
	for(var i = 0;i < typeCodes.length;i++){
	 	var options = $("#"+typeCodes[i]).val();
	 	if(options != null){
			allOptions = allOptions.concat(options);
		}
	}
	if(name == ""){
		alert("请输入姓名");
	}else if(school == ""){
		alert("请输入学院名称");
	}else if(major == ""){
		alert("请输入专业名称");
	}else if(studentNumber == ""){
		alert("请输入真实的学号");
	}else if(!validatePhone(phone)){
		alert("请输入正确的手机号");
	}else if(desc == ""){
		alert("请输入简短的描述");
	}else if(allOptions.length == 0){
		alert("请至少选择一个可教的课程");
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
			imgUrl: ".jpg",
			options: [],
			otheroptions,
			price: "",
			location: "",
			highestGrade:""
		};
		/*if(imageName.indexOf("jpeg") >= 0){
			postData.imgUrl = ".jpeg";
		}else if(imageName.indexOf("png") >= 0){
			postData.imgUrl = ".png";
		}else if(imageName.indexOf("JPG") >= 0){
			postData.imgUrl = ".JPG";
		}else if(imageName.indexOf("PNG") >= 0){
			postData.imgUrl = ".PNG";
		}*/
		postData.openid = openid;
		postData.name = name;
		postData.sex = sex;
		postData.school = school;
		postData.major = major;
		postData.studentNumber = studentNumber;
		postData.phone = phone;
		postData.desc = desc;
		postData.options = allOptions;
		postData.price = price;
		postData.location = location;
		postData.highestGrade = highestGrade;
		if(imageUploaded == true){
			if(certificateUploaded == true){
				$.post("service.php", postData,
   					function(data){
     					//$("#imagename").val(openid);
     					//$("#imageform").submit();
     					alert("老师数据录入成功！");
     				}
   				);
   			}else{
   				var choiceOfCertificate = confirm("不上传任何证书吗？");
   				if(choiceOfCertificate == true){
   					$.post("service.php", postData,
   						function(data){
     						//$("#imagename").val(openid);
     						//$("#imageform").submit();
     						alert("老师数据录入成功！");
     					}
   					);
   				}else{
   					$("#certificate_upload").trigger("click");
   				}
   			}
   		}else{
   			alert("请先上传自己的头像");
   		}
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

function validateImage(imageName){
	var reg = /\.(jpg|jpeg|png|JPG|PNG)$/;
	if (reg.test(imageName)) {
		return true;
	}else{
		return false;
	}
}

$(document).ready(function() {
			var interval;

			function applyAjaxFileUpload(element) {
				$(element).AjaxFileUpload({
					action: "upload.php",
					onChange: function(filename) {
						// Create a span element to notify the user of an upload in progress
						//$("<br>").appendTo($(this));
						var $span = $("<span />")
							.attr("class", $(this).attr("id"))
							.text("上传中")
							.insertAfter($(this));

						$(this).remove();

						interval = window.setInterval(function() {
							var text = $span.text();
							if (text.length < 13) {
								$span.text(text + ".");
							} else {
								$span.text("上传中");
							}
						}, 200);
					},
					onSubmit: function(filename) {
						// Return false here to cancel the upload
						/*var $fileInput = $("<input />")
							.attr({
								type: "file",
								name: $(this).attr("name"),
								id: $(this).attr("id")
							});

						$("span." + $(this).attr("id")).replaceWith($fileInput);

						applyAjaxFileUpload($fileInput);

						return false;*/

						// Return key-value pair to be sent along with the file
						var sent_along_data = {"openid":"","type":"image","count":"1"};
						sent_along_data["openid"] = openid;
						return sent_along_data;
					},
					onComplete: function(filename, response) {
						window.clearInterval(interval);
						var $span = $("span." + $(this).attr("id")).text(filename + " "),
							$fileInput = $("<input />")
								.attr({
									type: "file",
									name: $(this).attr("name"),
									id: $(this).attr("id")
								});
						if (typeof(response.error) === "string") {
							$span.replaceWith($fileInput);

							applyAjaxFileUpload($fileInput);

							alert(response.error);
							
							return;
						}
						
						imageUploaded = true;
					}
				});
			}

			applyAjaxFileUpload("#image_upload");
		});
		
		$(document).ready(function() {
			var interval;

			function applyAjaxFileUpload(element) {
				$(element).AjaxFileUpload({
					action: "upload.php",
					onChange: function(filename) {
						$("#iopenid_for_certificate").val(openid);
						// Create a span element to notify the user of an upload in progress
						//$("<br>").appendTo($(this));
						var $span = $("<span />")
							.attr("class", $(this).attr("id"))
							.text("上传中")
							.insertAfter($(this));

						$(this).remove();

						interval = window.setInterval(function() {
							var text = $span.text();
							if (text.length < 13) {
								$span.text(text + ".");
							} else {
								$span.text("上传中");
							}
						}, 200);
					},
					onSubmit: function(filename) {
						// Return false here to cancel the upload
						/*var $fileInput = $("<input />")
							.attr({
								type: "file",
								name: $(this).attr("name"),
								id: $(this).attr("id")
							});

						$("span." + $(this).attr("id")).replaceWith($fileInput);

						applyAjaxFileUpload($fileInput);

						return false;*/

						// Return key-value pair to be sent along with the file
						var sent_along_data = {"openid":"","type":"certificate","count":"1"};
						sent_along_data["openid"] = openid;
						sent_along_data["count"] = ""+certificateCount;
						return sent_along_data;
					},
					onComplete: function(filename, response) {
						window.clearInterval(interval);
						var $span = $("span." + $(this).attr("id")).text(filename + " "),
							$fileInput = $("<input />")
								.attr({
									type: "file",
									name: $(this).attr("name"),
									id: $(this).attr("id")
								});

						if (typeof(response.error) === "string") {
							$span.replaceWith($fileInput);

							applyAjaxFileUpload($fileInput);

							alert(response.error);

							return;
						}

						$("<br><a />")
							.attr("href", "#")
							.text("继续上传")
							.bind("click", function(e) {
								$span.replaceWith($fileInput);
								certificateCount++;
								applyAjaxFileUpload($fileInput);
							})
							.appendTo($span);
						
						certificateUploaded = true;
					}
				});
			}

			applyAjaxFileUpload("#certificate_upload");
		});
</script>
</body>
</html>














