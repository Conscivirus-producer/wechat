
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>老师数据录入</title>
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
<input type="text" name="openid" id="openid" value="<?php echo $openid; ?>" style="display:none">
<input type="text" name="rootUrl" id="rootUrl" value="<?php echo $rootUrl; ?>" style="display:none">
<input type="text" name="token" id="token" value="<?php echo $token; ?>" style="display:none">

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
				<label for="desc">自我介绍【不少于30个字】</label>
				<!--<input type="text" class="form-control" name="desc" id="desc" placeholder="可介绍自己的性格，经验，优点，获奖经历等">-->
				
				<textarea class="form-control" rows="3" name="desc" id="desc" placeholder="可介绍自己的性格，经验，优点，获奖经历等"></textarea>
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
				<label for="SU">学科辅导【可多选】</label>
				<select name="SU" id="SU" multiple class="form-control">
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-group">
				<label for="A">乐器与舞蹈【可多选】</label>
				<select name="A" id="A" multiple class="form-control">
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-group">
				<label for="B">体育运动【可多选】</label>
				<select name="B" id="B" multiple class="form-control">
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-group">
				<label for="C">书法与美术【可多选】</label>
				<select name="C" id="C" multiple class="form-control">
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-group">
				<label for="D">益智类【可多选】</label>
				<select name="D" id="D" multiple class="form-control">
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
				<select name="F" id="F"multiple class="form-control">
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
				<select name="location" id="location" multiple class="form-control">
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
		<div class="col-md-4 col-md-offset-2">
			<div class="form-group">
				<label for="teachingTime">可教学的时间</label>
				<table class="table table-bordered" id="teachingTime">
				<thead>
					<tr>
						<th><font color="#48C9B0">#</font></th>
						<th><font color="#48C9B0">一</font></th>
						<th><font color="#48C9B0">二</font></th>
						<th><font color="#48C9B0">三</font></th>
						<th><font color="#48C9B0">四</font></th>
						<th><font color="#48C9B0">五</font></th>
						<th><font color="#48C9B0">六</font></th>
						<th><font color="#48C9B0">日</font></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>上</td>
						<td><font color="#48C9B0">√</font></td>
						<td>上</td>
						<td>上</td>
						<td>上</td>
						<td>上</td>
						<td>上</td>
						<td>上</td>
					</tr>
					<tr>
						<td>下</td>
						<td>下</td>
						<td>下</td>
						<td>下</td>
						<td>下</td>
						<td>下</td>
						<td>下</td>
						<td>下</td>
					</tr>
					<tr>
						<td>晚</td>
						<td>晚</td>
						<td>晚</td>
						<td>晚</td>
						<td>晚</td>
						<td>晚</td>
						<td>晚</td>
						<td>晚</td>
					</tr>
				</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-2" id="image_upload_div">
			<label>上传头像(要求本人头像，五官清晰):</label><br>
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
		<div class="col-md-4 col-md-offset-2" id="certificate_upload_div">
			<label for="certificate_desc">上传证书(要求输入证书的名称/描述，可传多张):</label>
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
			<button type="button" class="btn btn-primary btn-lg btn-block" name="submit" id="submit">提交</button>
		</div>
	</div>
	<div class="row" id="interests" style="margin-top:10px">
		<div class="col-md-4 col-md-offset-4">
		</div>
	</div>
</div>
<!-- /.container -->
<!-- jQuery (necessary for Flat UI's JavaScript plugins) -->
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/vendor/video.js"></script>
<script src="js/flat-ui.min.js"></script>
<script src="assets/js/application.js"></script>
<script type="text/javascript">
var rootUrl = $("#rootUrl").val();
var typeCodes = ["A","B","C","D","E","F","SU"];
var url = "http://"+rootUrl+"/service.php?typeCode="+$(this).attr("id");
var optionData;

//openid, 上传图像时用来标记，上传证书时也要用来标记
var openid = $("#openid").val();

var certificateCount = "";
var imageUploaded = false;
var certificateUploaded = false;
var certificateDesc = "";

var postData = {
	"dataType":"getCertificates",
	"openid":""
};
postData["openid"] = openid;
$.post("teacherRegistrationService.php", postData,
   	function(data){
   		jsonObj = $.parseJSON(data);
   		var desc = jsonObj.description;
   		var imgUrl = jsonObj.imageUrl;
   		var length = imgUrl.length;
   		if(length != 0){
   			//certificateCount = length + 1;
   			certificateUploaded = true;
   			for(var k = 0;k < length;k++){
   				$("#certificate_upload_div").append(
					$("<img />").attr("src", imgUrl[k]).attr("class", "img-responsive").attr("style", "margin: 0 auto")
				);
   			}
   		}
   	}
);	

postData = {
	"dataType":"getHead",
	"openid":""
};
postData["openid"] = openid;
$.post("teacherRegistrationService.php", postData,
   	function(data){
   		jsonObj = $.parseJSON(data);
   		var imgUrl = jsonObj.imageUrl;
   		if(imgUrl != ""){
   			imageUploaded = true;
   			$("#image_upload_div").append(
				$("<img />").attr("src", imgUrl).attr("class", "img-responsive").attr("style", "margin: 0 auto")
			);
			$("#head_upload").prop('disabled', true);
   		}
   	}
);	


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
	var price = $("#price").val();					//期望的最低时薪					
	var location = $("#location").val();			//可接受的教学地点		
	var highestGrade = $("#grade").val();			//最高能教的年级
	var otheroptions = $("#otheroptions").val();	//其它能教的学科
	for(var i = 0;i < typeCodes.length;i++){
	 	var options = $("#"+typeCodes[i]).val();
	 	if(options != null){
			allOptions = allOptions.concat(options);
		}
	}
	if(name == ""){
		alert("请输入姓名");
		$("#name").focus();
	}else if(school == ""){
		alert("请输入学院名称");
		$("#school").focus();
	}else if(major == ""){
		alert("请输入专业名称");
		$("#major").focus();
	}else if(studentNumber == "" || studentNumber.length != 10){
		alert("请输入真实的学号");
		$("#studentNumber").focus();
	}else if(!validatePhone(phone)){
		alert("请输入正确的手机号");
		$("#phone").focus();
	}else if(desc == ""){
		alert("请输入自我介绍");
		$("#desc").focus();
	}else if(calculateLength(desc) < 30){
		alert("自我介绍不少于30个字，已经"+calculateLength(desc)+"个字了");
		$("#desc").focus();
	}else if(allOptions.length == 0){
		alert("请至少选择一个可教的课程");
		$("#A").focus();
	}else if(price == ""){
		alert("请输入期望的最低时薪");
		$("#price").focus();
	}else if(location == null){
		alert("请选择可接受的教学地点");
		$("#location").focus();
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
			imgUrl: "",
			options: [],
			otheroptions: [],
			price: "",
			location: [],
			highestGrade:"",
			dataType:"teacherRegistration"
		};
		postData.openid = openid;
		postData.name = name;
		postData.sex = sex;
		postData.school = school;
		postData.major = major;
		postData.studentNumber = studentNumber;
		postData.phone = phone;
		postData.desc = desc;
		postData.imgUrl = "http://7xk9ts.com2.z0.glb.qiniucdn.com/"+openid+"_head";
		postData.options = allOptions;
		
		postData.otheroptions = otheroptions;
		postData.price = price;
		if($.inArray("location0",location) != -1){
			location = ["location0"];
		}
		postData.location = location;
		postData.highestGrade = highestGrade;
		if(imageUploaded == true){
			if(certificateUploaded == true){
				$.post("supporting.php", postData,
   					function(data){
     					alert("老师数据录入成功！");
     					window.location.href = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx9855e946fbde03ac&redirect_uri=http://"+rootUrl+"/showTeacherInformation.php&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
     				}
   				);
   			}else{
   				var choiceOfCertificate = confirm("不上传任何证书吗？上传证书能更好地展示你自己");
   				if(choiceOfCertificate == true){
   					$.post("supporting.php", postData,
   						function(data){
     						alert("老师数据录入成功！");
     						window.location.href = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx9855e946fbde03ac&redirect_uri=http://"+rootUrl+"/showTeacherInformation.php&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
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

function calculateLength(str){
	str=str.replace(/[\ |\~|\`|\！|\@|\#|\$|\%|\^|\&|\*|\(|\)|\-|\_|\+|\=|\||\\|\[|\]|\{|\}|\;|\:|\"|\'|\，|\<|\。|\>|\/|\？]/g,""); 
	return str.length;
}
/*$("#trigger_head_upload").click(function(){
	$("#head_upload").trigger("click");
});
$("#trigger_certificate_upload").click(function(){
	certificateDesc = $("#certificate_desc").val();
	if(certificateDesc != ""){
		$("#certificate_upload").trigger("click");
	}else{
		alert("请先输入输入证书的名称/描述");
		$("#certificate_desc").focus();
	}	
});*/
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
						$("<img />").attr("src", "http://7xk9ts.com2.z0.glb.qiniucdn.com/"+openid+"_head").attr("class", "img-responsive").attr("style", "margin: 0 auto")
					);
					$("#head_upload").prop('disabled', true);
                    //alert("头像上传成功");
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
    	
        //define a upload function
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
                    		//alert("证书上传成功");
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
        
        //action
        var token = $("#token").val();
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
    });
});
$("#location").change(function(){
    if($.inArray("location0",$(this).val()) != -1){
    	$(this).val(["location0"]);
    }
});
</script>
</body>
</html>














