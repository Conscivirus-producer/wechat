<?php
if (isset($_GET['code'])){
    $code = $_GET['code'];
    $access_token_get_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx9855e946fbde03ac&secret=a185dd60de19330b8eaaadf4d8ae00ef&code=".$code."&grant_type=authorization_code";
    $access_token_json = file_get_contents($access_token_get_url); 
    $json_obj = json_decode($access_token_json,true);
    $openid = $json_obj["openid"];
}else{
	//need to be modified to show hint and qrcode image
    //echo "NO CODE";
    $openid = "11111111";
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>寻找老师</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Loading Bootstrap -->
<link href="css/vendor/bootstrap.min.css" rel="stylesheet">
<!-- Loading Flat UI -->
<link href="css/flat-ui.min.css" rel="stylesheet">
<link href="css/default.css" rel="stylesheet">
<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
<script src="js/vendor/html5shiv.js"></script>
<script src="js/vendor/respond.min.js"></script>
<![endif]-->
</head>
<body>
<div style="width:100%; background-color: #48C9B0; color: white; height: 40px; border-bottom: 1px solid #1B9C83"><span style="position: absolute; left: 10px; top:5px">我教你学</span></div>
<input type="text" name="openid" id="openid" value="<?php echo $openid; ?>" style="display:none">
<div class="container">
	<div class="row" id="q0">
		<div class="col-md-4 col-md-offset-4">
			<p class="text-left introduction">
				欢迎来到我教你学，四个步骤找到老师:
			</p>
			<ol style="font-size: 16px;">
			  <li>回答几个简单的问题</li>
			  <li>留下您的联系方式</li>
			  <li>我们在24小时之内将老师信息通过微信或短信发送给您</li>
			  <li>老师联系您商量试教时间及地点</li>
			</ol>
			<p class="text-left introduction">赶紧开启发现老师之旅吧！</p>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="start" id="start">开始</button>
		</div>
	</div>
	
	<div class="row" style="display:none" id="q1">
		<div class="col-md-4 col-md-offset-4">
			<p class="question text-left">
				您的小孩目前在读？
			</p>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="section1" id="section1">小学</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="section2" id="section2">初中</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="section3" id="section3">高中</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-infor laststep" name="laststep1" id="laststep1">上一步</button>
		</div>
	</div>
	
	<div class="row" style="display:none" id="q11">
		<div class="col-md-4 col-md-offset-4">
			<p class="question text-left">
				您小孩的年级是？
			</p>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="grade1" id="grade1">一年级</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="grade2" id="grade2">二年级</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="grade3" id="grade3">三年级</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="grade4" id="grade4">四年级</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="grade5" id="grade5">五年级</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="grade6" id="grade6">六年级</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-infor laststep" name="laststep11" id="laststep11">上一步</button>
		</div>
	</div>
	
	<div class="row" style="display:none" id="q12">
		<div class="col-md-4 col-md-offset-4">
			<p class="question text-left">
				您小孩的年级是？
			</p>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="grade7" id="grade7">一年级</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="grade8" id="grade8">二年级</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="grade9" id="grade9">三年级</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-infor laststep" name="laststep12" id="laststep12">上一步</button>
		</div>
	</div>
	
	<div class="row" style="display:none" id="q13">
		<div class="col-md-4 col-md-offset-4">
			<p class="question text-left">
				您小孩的年级是？
			</p>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="grade10" id="grade10">一年级</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="grade11" id="grade11">二年级</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="grade12" id="grade12">三年级</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-infor laststep" name="laststep13" id="laststep13">上一步</button>
		</div>
	</div>
	
	<div class="row" style="display:none" id="q2">
		<div class="col-md-4 col-md-offset-4">
			<p class="question text-left">
				您希望小孩的学习内容是什么?
			</p>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="contentsub" id="contentsub">课程辅导</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="contentinte" id="contentinte">学习兴趣培养</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="contentboth" id="contentboth">二者都选</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-infor laststep" name="laststep2" id="laststep2">上一步</button>
		</div>
	</div>
	
	<div class="row" style="display:none" id="q3">
		<div class="col-md-4 col-md-offset-4">		
			<p class="question text-left">
				您的小孩哪个科目最需要提高？
			</p>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="su3" id="su3">语文</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="su2" id="su2">英语</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="su1" id="su1">数学</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-infor laststep" name="laststep3" id="laststep3">上一步</button>
		</div>
	</div>
	
	<div class="row" style="display:none" id="q4">
		<div class="col-md-4 col-md-offset-4">		
			<p class="question text-left">
				您希望您的孩子培养哪些兴趣？
			</p>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="inteA" id="A">乐器与舞蹈</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="inteB" id="B">体育运动</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="inteC" id="C">书法与美术</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="inteD" id="D">益智类</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="inteE" id="E">演讲与口才</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="inteF" id="F">趣味课程</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-infor laststep" name="laststep4" id="laststep4">上一步</button>
		</div>
	</div>
	
	<div class="row" style="display:none" id="q5">
		<div class="col-md-4 col-md-offset-4">		
			<p class="question text-left">
				请您选择具体的兴趣
			</p>
		</div>
	</div>
	
	<div class="row" style="display:none" id="teacherGender">
		<div class="col-md-4 col-md-offset-4">		
			<p class="question text-left">
				您期望的老师性别:
			</p>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="gender1" id="gender1">男生</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="gender2" id="gender2">女生</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="gender3" id="gender3">不限</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-infor laststep" name="laststep5" id="laststep5">上一步</button>
		</div>
	</div>
	
	<div class="row" style="display:none" id="price">
		<div class="col-md-4 col-md-offset-4">		
			<p class="question text-left">
				您接受的价格区间(每小时):
			</p>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="price1" id="price1">初级: 50 ~ 100</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="price2" id="price2">中级: 100 ~ 150</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="price3" id="price3">高级: 150以上</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-infor laststep" name="laststep6" id="laststep6">上一步</button>
		</div>
	</div>
	
	<div class="row" style="display:none" id="resultNotification">
		<div class="col-md-4 col-md-offset-4">
			<p class="text-left question">
				谢谢您的选择，我们会在24小时找到匹配您的老师并把结果发送给您，您希望以什么方式接收我们的消息?
			</p>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-primary btn-lg btn-block" name="notifywechat" id="notifywechat">微信</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-primary btn-lg btn-block" name="notifymessage" id="notifymessage">短信</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-infor laststep" name="laststep_notify" id="laststep_notify">上一步</button>
		</div>
	</div>
	
	<div class="row" style="display:none" id="q6">
		<div class="col-md-4 col-md-offset-4">
			<p class="text-left question">
				请您留下您的联系方式:
			</p>
			<div class="form-group">
				<input type="text" value="" class="form-control" name="contact" id="contact" placeholder="請輸入联系方式">
			</div>
		</div>
		<div class="col-md-2 col-md-offset-6">
			<button type="button" class="btn btn-primary btn-lg btn-block" name="save" id="save">提交</button>
		</div>
	</div>
	
	<div class="row" style="display:none" id="q7">
		<div class="col-md-4 col-md-offset-4">		
			<p class="text-left">
				为您找到的老师信息如下:
			</p>
		</div>
	</div>
	
	<div class="row" style="display:none" id="q8">
		<div class="teacher-info" style="margin-top: 30px">
			<div class="teacher-photo">
				<img id="teacherImgUrl" alt="empty" class="img-circle center-block">
			</div>
			<h6 class="username center-block text-center" id="teacherName">Anderson</h6>
			<div class="center-block text-center teacher-price"><span id="teacherPrice">50</span>元/小时</div>
			<div class="row school-info">
				<div class="col-xs-1"></div>
				<div class="col-xs-10 text-center"><span id="teacherDescription">“您好，我是来自深圳大学 计算机学院 计算机科学与技术专业的李超超, 我擅长创业，希望我能帮到你和你的孩子”</span></div>
				<div class="col-xs-1"></div>
			</div>
			<div class="row interests" id="interestsRow">
				<div class="col-xs-1"></div>
				<div class="col-xs-10">
					<div class="col-xs-3"></div>
					<div class="col-xs-6 text-center subjects_label"><span>特长与经历</span></div>
					<div class="col-xs-3"></div>
					<!-- <div class="col-xs-12 text-center interests_label">特长</div> -->
					<div class="col-xs-12" style="padding: 0px" id="availableInterests">
						
					</div>
				</div>
				<div class="col-xs-1"></div>
			</div>
		</div>
		<div class="row accept">
			<div class="btn btn-lg btn-primary col-xs-8 col-xs-offset-2" name="compeleteRecord" id="compeleteRecord">预约试听</div>
		</div>
		<div class="row back-to-list">
			<div class="btn btn-lg laststep col-xs-8 col-xs-offset-2" name="laststep1" id="laststep1">返回列表</div>
		</div>
	</div>
	
	<div class="row" style="display:none" id="q9">
		<div class="col-md-4 col-md-offset-4">		
			<p class="text-left">
				恭喜您，老师选择成功，您可以去我的记录里查看状态.
			</p>
		</div>

		<div class="col-md-2 col-md-offset-6">
			<button type="button" class="btn btn-primary btn-lg btn-block" name="myrecord" id="myrecord">我的记录</button>
		</div>
	</div>
	
	<div class="row" style="display:none" id="q10">
		<div class="col-md-4 col-md-offset-4 question">		
			<p class="text-left">
				订单已提交，敬请留意我们的消息，谢谢您的使用。
			</p>
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
//rootUrl = "localhost";
var gender="";
var section;
var grade;
var choice;
var subject;
var interest;
var divArray = new Array();
var childId;
var price;
var teacherGender;
var teacherOpenId;
var notifyMethod;
var mobile = "";

function showDiv($div){
	$div.show();
	divArray.push($div);
}

function insertParentAndChild(){
	var url = "http://"+rootUrl+"/service.php?requestMethod=insertParentAndChild&parentOpenId="+
	$("#openid").val()+"&choice="+choice+"&gender="+gender+"&grade="+grade+"&section="+section+"&teacherGender="+teacherGender+"&price="+price;
	if(choice == "contentsub"){
		url += "&subject="+subject.toUpperCase();
	}else if(choice == "contentinte"){
		url += "&interest="+interest;
	}else if(choice == "contentboth"){
		url += "&subject="+subject.toUpperCase()+"&interest="+interest;
	}
	$.getJSON(url,function(data){
		childId = data.childId;
		$("#openid").val(data.parentOpendId);
	});
}


/*$("#start").click(function(){
$.confirm({
	msg: 'See?',
	stopAfter: 'ok',
	eventType: 'mouseover',
	timeout: 3000,
	buttons: {
		ok: 'Sure',
		cancel: 'No thanks',
		separator: ' '
	}
});
});*/
/*$("#start").click(function(){
    $.confirm({
        'title': 'Delete Confirmation',
        'message': 'You are about to delete this item. It cannot be restored at a later time! Continue?',
        'buttons': {
            'Yes': {
                'class': 'blue',
                'action': function(){
                    alert(1);
                }
            },
            'No': {
                'class': 'gray',
                'action': function(){}// Nothing to do in this case. You can as well omit the action property.
            }
        }
    });
});*/

$(".btn.btn-lg.btn-block").click(function(){
	$("button:visible").removeClass("active");
	$(this).addClass("active");
	var itemname = $(this).attr("name");
	if(itemname == "start"){
		$("#q0").hide("normal",function(){
			divArray.push($("#q0"));
			showDiv($("#q1"));
		});
	}else if(itemname.indexOf("section") >= 0){
		section = itemname;
		$("#q1").hide("normal",function(){
			if(itemname == "section1"){
				showDiv($("#q11"));
			}else if(itemname == "section2"){
				showDiv($("#q12"));
			}else if(itemname == "section3"){
				showDiv($("#q13"));
			}
		});
	}else if(itemname.indexOf("grade") >= 0){
		grade = itemname;
		var $hidDiv;
		if(section == "section1"){
			$hidDiv = $("#q11"); 
		}else if(section == "section2"){
			$hidDiv = $("#q12"); 
		}else if(section == "section3"){
			$hidDiv = $("#q13"); 
		}
		$hidDiv.hide("normal",function(){
			showDiv($("#q2"));
		});
	}else if(itemname.indexOf("content") >= 0){
		choice = itemname;
		$("#q2").hide("normal",function(){
			if (choice == "contentinte"){
				showDiv($("#q4"));
			} else{
				showDiv($("#q3"));
			}
		});
	}else if(itemname.indexOf("su") >= 0){
		subject = itemname;
		$("#q3").hide("normal",function(){
			if(choice == "contentsub"){
				showDiv($("#teacherGender"));
			} else if(choice == "contentboth"){
				showDiv($("#q4"));
			}
		});
	}else if(itemname.indexOf("inte") >= 0){
		var url = "http://"+rootUrl+"/service.php?typeCode="+$(this).attr("id");
		$.getJSON(url,function(data){
			var code = data.code;
			var name = data.name;
			var length = code.length;
			for(var i = 0;i < length;i++){
				var $div = $("<div>", {style: "margin-top:2px", class: "col-md-2 col-md-offset-6"});
				var $button = $("<button>", {type: "button", name: "specifici", class: "btn btn-lg btn-block btn-primary"}).attr("id",code[i]).text(name[i]);
				$button.click(function(){
					interest = $(this).attr("id");
					$("#q5").hide("normal",function(){
						showDiv($("#teacherGender"));
					});
				});
				$div.append($button);
				$("#q5").append($div);
			}
			$nextdiv = $("<div>", {style: "margin-top:2px", class: "col-md-2 col-md-offset-6"});
			$nextbutton = $("<button>", {type: "button", name: "laststep5", class: "btn btn-lg btn-block btn-infor laststep"}).attr("id","laststep5").text("上一步");
			$nextdiv.append($nextbutton);
			$("#q5").append($nextdiv);
			$("#q4").hide("normal",function(){
				showDiv($("#q5"));
				$("#laststep5").click(function(){
					var length = divArray.length;
					if(divArray[length - 1].attr('id') == "q5"){
						divArray[length - 1].find('div.col-md-offset-6').remove();
					}
					divArray[length - 1].hide("normal",function(){
						divArray[length - 2].show();
					});		
					divArray.pop();
				});
			});
		});
	}else if(itemname.indexOf("gender") >= 0){
		teacherGender = itemname;
		$("#teacherGender").hide("normal",function(){
			showDiv($("#price"));
		});
	}else if(itemname.indexOf("price") >= 0){
		price = itemname;
		$("#price").hide("normal",function(){
			insertParentAndChild();
			//showDiv($("#resultNotification"));
			//showDiv($("#q6"));
			findTeacher();
			//showDiv($("#q7"));
		});
	}
});

$("[id^=laststep]").click(function(){
	var length = divArray.length;
	//$("p").remove(".italic");
	if(divArray[length - 1].attr('id') == "q5"){
		divArray[length - 1].find('div.col-md-offset-6').remove();
	}
	if(divArray[length - 1].attr('id') == "q7"){
		divArray[length - 1].find('div.col-md-offset-6').remove();
	}
	if(divArray[length - 1].attr('id') == "q8"){
		$('#availableInterests').find('div.col-xs-6.subjects_value').remove();
	}
	divArray[length - 1].hide("normal",function(){
		divArray[length - 2].show();
	});		
	divArray.pop();
});

$("#compeleteRecord").click(function(){
	var url = "http://"+rootUrl+"/service.php?requestMethod=saveTransaction&parentOpenId="+$("#openid").val()+"&teacherOpenId="+teacherOpenId+"&childId="+childId;
	$.getJSON(url,function(data){
		
	});
	$("#q8").hide("normal",function(){
		showDiv($("#q9"));
	});	
});

$("#myrecord").click(function(){
	window.location.href='https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx9855e946fbde03ac&redirect_uri=http://'+rootUrl+'/myRecord.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect';
});

function findTeacher(){
	var url = "http://"+rootUrl+"/service.php?requestMethod=matchTeacher&parentOpenId="+
	$("#openid").val()+"&choice="+choice+"&mobile="+mobile+"&gender="+gender+"&grade="+grade+"&section="+section;
	if(choice == "contentsub"){
		url += "&subject="+subject.toUpperCase();
	}else if(choice == "contentinte"){
		url += "&interest="+interest;
	}else if(choice == "contentboth"){
		url += "&subject="+subject.toUpperCase()+"&interest="+interest;
	}
	$.getJSON(url,function(data){
		teacherOpenId = data.teacherOpenId;
		childId = data.childId[0];
		var name = data.name;
		var length = teacherOpenId.length;
		var $ulGroup = $("<ul>", {class : "list-group", style: "margin-left: 10px;margin-right: 10px"});
		for(var i = 0;i < length;i++){
			var value = teacherOpenId[i]; 
			var $a = $("<a>", {class: "list-group-item", id: value, href:"#"}).html('<img class="img-circle listHeader" src="'+data.imageUrl[i]+'"></img>'+
			'<span style="margin-left:10px">'+name[i]+'</span><span style="margin-top:8px;float:right">' + data.major[i]+'</span>');
			$a.click(function(){
				var value = $(this).attr("id");
				teacherOpenId = value;
				//var text = $(this).text();
				url = "http://"+rootUrl+"/service.php?requestMethod=teacherDetails&teacherOpenId="+teacherOpenId;
				$.getJSON(url, function(data){
					var studentName = data.name;
					var interests = data.interests;
					var interestName = interests.name;
					var inteNameStr = "";
					var description = data.description;
					$("#teacherName").html(data.name);
					$("#teacherPrice").html(data.price);
					$("#teacherImgUrl").attr("src", data.imageUrl);
					var length = interestName.length;
					if(length == 0){
						$('#interestsRow').hide();
					}else{
						$('#interestsRow').show();
						for(var j=0; j < length;j++){
							$parentDiv = $("<div>", {class: "col-xs-6 subjects_value"});
							$childDiv = $("<div>", {class: "text-center btn-info btn-doc"}).text(interests.name[j]);
							$parentDiv.append($childDiv);
							$("#availableInterests").append($parentDiv);
							inteNameStr += interests.name[j];
							if(j < length - 1){
								inteNameStr += ",";
							}
						}
					}
					description = description.replace("TBC", inteNameStr);
					$("#teacherDescription").html(description);
	 				$("#q7").hide("normal",function(){
						showDiv($("#q8"));
					});
				});
			});
			$ulGroup.append($a);
		}
		$("#q7").append($ulGroup);
		showDiv($("#q7"));
		/*$("#q6").hide("normal",function(){
			showDiv($("#q7"));
		});*/
	});	
}

</script>
</body>
</html>