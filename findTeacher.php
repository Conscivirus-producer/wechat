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
    //echo "NO CODE";
    $openid = "obS35vk9Hqwl4WZXsosjxm_hckKQ";
	
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>寻找老师</title>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
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
	
	<div class="row" id="q0">
		<div class="find-header col-xs-12">
			<img class="center-block" src="http://7xk9ts.com2.z0.glb.qiniucdn.com/LogoForHeader.svg" />
			<div class="col-xs-6 col-xs-offset-3 text-center">
				ShenZhen UltraBravo Tech Ltd.
			</div>
		</div>
		<!-- <div class="col-md-4 col-md-offset-4">
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
		</div> -->
			<div class="col-xs-12 text-center company-name"><strong>我教你学</strong></div>
			
			<div class="col-xs-10 col-xs-offset-1 text-center company-details">
				我教你学由深港高校联合创办，旨在打造一个人人乐用的家教平台，做到更精准，更智能，更高效地择优匹配师生资源。
			</div>
			
			
				<div class="col-xs-4">
					<img class="star-photo img-circle center-block" id="star-one" src="http://7xk9ts.com2.z0.glb.qiniucdn.com/obS35voyc3uPs4bNzTR9hdWBBeuk_head?imageView2/1/w/65/h/65/q/100" alt="empty">
					<div class="star-name text-center">夏丽婷</div>
					<div class="star-skill text-center">英语师范专业</div>
				</div>
				<div class="col-xs-4">
					<img class="star-photo img-circle center-block" id="star-two" src="http://7xk9ts.com2.z0.glb.qiniucdn.com/1183252454.jpg?imageView2/1/w/65/h/65/q/100" alt="empty">
					<div class="star-name text-center">刘楠</div>
					<div class="star-skill text-center">声乐专业</div>
				</div>
				<div class="col-xs-4">
					<img class="star-photo img-circle center-block" id="star-three" src="http://7xk9ts.com2.z0.glb.qiniucdn.com/历程.jpg?imageView2/1/w/65/h/65/q/100" alt="empty">
					<div class="star-name text-center">厉程</div>
					<div class="star-skill text-center">产品设计专业</div>
				</div>
			
			<div class="col-xs-8 col-xs-offset-2"><img src="http://7xk9ts.com2.z0.glb.qiniucdn.com/seperator.png?imageView2/1/w/150/h/30/q/100" class="center-block" /></div>
			<div class="col-xs-6 col-xs-offset-3 steps text-center">简单四步找到您的家教</div>
			<div class="col-xs-6 col-xs-offset-3 step-one text-center">
				<div class="col-xs-12 text-center step-title">第一步</div>
				<div class="col-xs-8 col-xs-offset-2"><img src="http://7xk9ts.com2.z0.glb.qiniucdn.com/step1.svg" style="width: 38px; height: 56px" /></div>
				<div class="col-xs-12 text-center step-desc">"回答一些相关问题"</div>
			</div>
			<div class="col-xs-2 col-xs-offset-5"><img class="arrow-down center-block" src="http://7xk9ts.com2.z0.glb.qiniucdn.com/DOWNARROW.svg" style="width: 20px; height: 20px"/></div>
			
			<div class="col-xs-6 col-xs-offset-3 step-two text-center">
				<div class="col-xs-12 text-center step-title">第二步</div>
				<div class="col-xs-8 col-xs-offset-2"><img src="http://7xk9ts.com2.z0.glb.qiniucdn.com/phonenumber.svg" style="width: 56px; height: 56px"/></div>
				<div class="col-xs-12 text-center step-desc">"填写您的手机号码"</div>
			</div>
			<div class="col-xs-2 col-xs-offset-5"><img class="arrow-down center-block" src="http://7xk9ts.com2.z0.glb.qiniucdn.com/DOWNARROW.svg" style="width: 20px; height: 20px"/></div>
			
			<div class="col-xs-6 col-xs-offset-3 step-three text-center">
				<div class="col-xs-12 text-center step-title">第三步</div>
				<div class="col-xs-8 col-xs-offset-2"><img src="http://7xk9ts.com2.z0.glb.qiniucdn.com/clock.svg" style="width: 56px; height: 56px"/></div>
				<div class="col-xs-12 text-center step-desc">"我们在24小时内帮您找到最适合的家教"</div>
			</div>
			<div class="col-xs-2 col-xs-offset-5"><img class="arrow-down center-block" src="http://7xk9ts.com2.z0.glb.qiniucdn.com/DOWNARROW.svg" style="width: 20px; height: 20px"/></div>
			
			<div class="col-xs-6 col-xs-offset-3 step-four text-center">
				<div class="col-xs-12 text-center step-title">第四步</div>
				<div class="col-xs-8 col-xs-offset-2"><img src="http://7xk9ts.com2.z0.glb.qiniucdn.com/contact.svg" style="width: 56px; height: 56px" /></div>
				<div class="col-xs-12 text-center step-desc">"我们的客服会电话联络您，确认细节"</div>
			</div>
	<div class="bottom start text-center" name="start" id="start">开始</div>
	</div>
	
	<div class="row" style="display:none" id="q2">
		<div class="find-header col-xs-12">
			<img class="center-block" src="http://7xk9ts.com2.z0.glb.qiniucdn.com/logo.png?imageView2/1/w/65/h/65/q/100" />
			<div class="col-xs-6 col-xs-offset-3 text-center">
				ShenZhen UltraBravo Tech Ltd.
			</div>
		</div>
		<div class="col-xs-8 col-xs-offset-2 text-center">
			<p class="question text-center lead">
				您希望小孩的学习内容是什么?
			</p>
		</div>
		<div class="col-xs-2"></div>
		<div class="col-xs-8 col-xs-offset-2"><img src="http://7xk9ts.com2.z0.glb.qiniucdn.com/seperator.svg" class="center-block" style="width: 150px; height: 30px" /></div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="contentsub" id="contentsub">课程辅导</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="contentinte" id="contentinte">学习兴趣培养</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="contentboth" id="contentboth">二者都选</button>
		</div>
		<button type="button" class="btn btn-lg btn-block btn-info laststep" name="laststep2" id="laststep2">上一步</button>
	</div>
	
	<div class="row" style="display:none" id="q3">
		<div class="find-header col-xs-12">
			<img class="center-block" src="http://7xk9ts.com2.z0.glb.qiniucdn.com/logo.png?imageView2/1/w/65/h/65/q/100" />
			<div class="col-xs-6 col-xs-offset-3 text-center">
				ShenZhen UltraBravo Tech Ltd.
			</div>
		</div>
		<div class="col-xs-8 col-xs-offset-2 text-center">		
			<p class="question text-center lead">
				您的小孩哪个科目最需要提高？
			</p>
		</div>
		<div class="col-xs-2"></div>
		<div class="col-xs-8 col-xs-offset-2"><img src="http://7xk9ts.com2.z0.glb.qiniucdn.com/seperator.png?imageView2/1/w/150/h/30/q/100" class="center-block" /></div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="su3" id="su3">语文</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="su2" id="su2">英语</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="su1" id="su1">数学</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="su4" id="su4">全科</button>
		</div>
		<button type="button" class="btn btn-lg btn-block btn-info laststep" name="laststep3" id="laststep3">上一步</button>
	</div>
	
	<div class="row" style="display:none" id="q4">
		<div class="find-header col-xs-12">
			<img class="center-block" src="http://7xk9ts.com2.z0.glb.qiniucdn.com/logo.png?imageView2/1/w/65/h/65/q/100" />
			<div class="col-xs-6 col-xs-offset-3 text-center">
				ShenZhen UltraBravo Tech Ltd.
			</div>
		</div>
		<div class="col-xs-8 col-xs-offset-2 text-center">		
			<p class="question text-center lead">
				您希望您的孩子培养哪些兴趣？
			</p>
		</div>
		<div class="col-xs-2"></div>
		<div class="col-xs-8 col-xs-offset-2"><img src="http://7xk9ts.com2.z0.glb.qiniucdn.com/seperator.png?imageView2/1/w/150/h/30/q/100" class="center-block" /></div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="inteA" id="A">器乐与声乐</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="inteB" id="B">体育运动</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="inteC" id="C">书法与美术</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="inteD" id="D">棋类与编程软件应用</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="inteE" id="E">演讲与播音主持</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="inteF" id="F">人文科学与小语种</button>
		</div>
		<button type="button" class="btn btn-lg btn-block btn-info laststep" name="laststep4" id="laststep4">上一步</button>
	</div>
	
	<div class="row" style="display:none" id="q5">
		<div class="find-header col-xs-12">
			<img class="center-block" src="http://7xk9ts.com2.z0.glb.qiniucdn.com/logo.png?imageView2/1/w/65/h/65/q/100" />
			<div class="col-xs-6 col-xs-offset-3 text-center">
				ShenZhen UltraBravo Tech Ltd.
			</div>
		</div>
		<div class="col-xs-10 col-xs-offset-1 text-center">		
			<p class="question text-center">
				请您选择具体的兴趣
			</p>
		</div>
		<div class="col-xs-2"></div>
		<div class="col-xs-10 col-xs-offset-1"><img src="http://7xk9ts.com2.z0.glb.qiniucdn.com/seperator.png?imageView2/1/w/150/h/30/q/100" class="center-block" /></div>
	</div>
	
	<div class="row" style="display:none" id="teacherGender">
		<div class="find-header col-xs-12">
			<img class="center-block" src="http://7xk9ts.com2.z0.glb.qiniucdn.com/logo.png?imageView2/1/w/65/h/65/q/100" />
			<div class="col-xs-6 col-xs-offset-3 text-center">
				ShenZhen UltraBravo Tech Ltd.
			</div>
		</div>
		<div class="col-xs-8 col-xs-offset-2 text-center">		
			<p class="question text-center">
				您期望的老师性别:
			</p>
		</div>
		<div class="col-xs-2"></div>
		<div class="col-xs-8 col-xs-offset-2"><img src="http://7xk9ts.com2.z0.glb.qiniucdn.com/seperator.png?imageView2/1/w/150/h/30/q/100" class="center-block" /></div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="gender3" id="gender3">不限</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="gender1" id="gender1">男生</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="gender2" id="gender2">女生</button>
		</div>
		<button type="button" class="btn btn-lg btn-block btn-info laststep" name="laststep5" id="laststep5">上一步</button>
	</div>
	
	<div class="row" style="display:none" id="address">
		<div class="find-header col-xs-12">
			<img class="center-block" src="http://7xk9ts.com2.z0.glb.qiniucdn.com/logo.png?imageView2/1/w/65/h/65/q/100" />
			<div class="col-xs-6 col-xs-offset-3 text-center">
				ShenZhen UltraBravo Tech Ltd.
			</div>
		</div>
		<div class="col-xs-8 col-xs-offset-2 text-center">		
			<p class="question text-center">
				您期望的教学地点是哪？
			</p>
		</div>
		<div class="col-xs-2"></div>
		<div class="col-xs-8 col-xs-offset-2"><img src="http://7xk9ts.com2.z0.glb.qiniucdn.com/seperator.png?imageView2/1/w/150/h/30/q/100" class="center-block" /></div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="address1" id="address1">南山区</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="address2" id="address2">福田区</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="address3" id="address3">罗湖区</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="address4" id="address4">宝安区</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="address5" id="address5">龙岗区</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="address6" id="address6">其它</button>
		</div>
		<button type="button" class="btn btn-lg btn-block btn-info laststep" name="laststep_add" id="laststep_add">上一步</button>
	</div>
	
	<div class="row" style="display:none" id="price">
		<div class="find-header col-xs-12">
			<img class="center-block" src="http://7xk9ts.com2.z0.glb.qiniucdn.com/logo.png?imageView2/1/w/65/h/65/q/100" />
			<div class="col-xs-6 col-xs-offset-3 text-center">
				ShenZhen UltraBravo Tech Ltd.
			</div>
		</div>
		<div class="col-xs-8 col-xs-offset-2 text-center">		
			<p class="question text-center">
				您接受的价格区间(每小时):
			</p>
		</div>
		<div class="col-xs-2"></div>
		<div class="col-xs-8 col-xs-offset-2"><img src="http://7xk9ts.com2.z0.glb.qiniucdn.com/seperator.png?imageView2/1/w/150/h/30/q/100" class="center-block" /></div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="price1" id="price1">初级: 50 ~ 100</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="price2" id="price2">中级: 100 ~ 150</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="price3" id="price3">高级: 150以上</button>
		</div>
		<button type="button" class="btn btn-lg btn-block btn-info laststep" name="laststep6" id="laststep6">上一步</button>
	</div>
	
	<div class="row" style="display:none" id="q1">
		<div class="find-header col-xs-12">
			<img class="center-block" src="http://7xk9ts.com2.z0.glb.qiniucdn.com/logo.png?imageView2/1/w/65/h/65/q/100" />
			<div class="col-xs-6 col-xs-offset-3 text-center">
				ShenZhen UltraBravo Tech Ltd.
			</div>
		</div>
		<div class="col-xs-8 col-xs-offset-2 text-center">
			<p class="question text-center">
				您的小孩目前在读？
			</p>
		</div>
		<div class="col-xs-2"></div>
		<div class="col-xs-8 col-xs-offset-2"><img src="http://7xk9ts.com2.z0.glb.qiniucdn.com/seperator.png?imageView2/1/w/150/h/30/q/100" class="center-block" /></div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="section1" id="section1">小学</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="section2" id="section2">初中</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="section3" id="section3">高中</button>
		</div>
		<button type="button" class="btn btn-lg btn-block btn-info laststep" name="laststep1" id="laststep1">上一步</button>
	</div>
	
	<div class="row" style="display:none" id="q11">
		<div class="find-header col-xs-12">
			<img class="center-block" src="http://7xk9ts.com2.z0.glb.qiniucdn.com/logo.png?imageView2/1/w/65/h/65/q/100" />
			<div class="col-xs-6 col-xs-offset-3 text-center">
				ShenZhen UltraBravo Tech Ltd.
			</div>
		</div>
		<div class="col-xs-8 col-xs-offset-2 text-center">
			<p class="question text-center">
				您小孩的年级是？
			</p>
		</div>
		<div class="col-xs-2"></div>
		<div class="col-xs-8 col-xs-offset-2"><img src="http://7xk9ts.com2.z0.glb.qiniucdn.com/seperator.png?imageView2/1/w/150/h/30/q/100" class="center-block" /></div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="grade1" id="grade1">小学一年级</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="grade2" id="grade2">小学二年级</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="grade3" id="grade3">小学三年级</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="grade4" id="grade4">小学四年级</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="grade5" id="grade5">小学五年级</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="grade6" id="grade6">小学六年级</button>
		</div>
		<button type="button" class="btn btn-lg btn-block btn-info laststep" name="laststep11" id="laststep11">上一步</button>
	</div>
	
	<div class="row" style="display:none" id="q12">
		<div class="find-header col-xs-12">
			<img class="center-block" src="http://7xk9ts.com2.z0.glb.qiniucdn.com/logo.png?imageView2/1/w/65/h/65/q/100" />
			<div class="col-xs-6 col-xs-offset-3 text-center">
				ShenZhen UltraBravo Tech Ltd.
			</div>
		</div>
		<div class="col-xs-8 col-xs-offset-2 text-center">
			<p class="question text-center">
				您小孩的年级是？
			</p>
		</div>
		<div class="col-xs-2"></div>
		<div class="col-xs-8 col-xs-offset-2"><img src="http://7xk9ts.com2.z0.glb.qiniucdn.com/seperator.png?imageView2/1/w/150/h/30/q/100" class="center-block" /></div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="grade7" id="grade7">初中一年级</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="grade8" id="grade8">初中二年级</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="grade9" id="grade9">初中三年级</button>
		</div>
		<button type="button" class="btn btn-lg btn-block btn-info laststep" name="laststep12" id="laststep12">上一步</button>
	</div>
	
	<div class="row" style="display:none" id="q13">
		<div class="find-header col-xs-12">
			<img class="center-block" src="http://7xk9ts.com2.z0.glb.qiniucdn.com/logo.png?imageView2/1/w/65/h/65/q/100" />
			<div class="col-xs-6 col-xs-offset-3 text-center">
				ShenZhen UltraBravo Tech Ltd.
			</div>
		</div>
		<div class="col-xs-8 col-xs-offset-2 text-center">
			<p class="question text-center">
				您小孩的年级是？
			</p>
		</div>
		<div class="col-xs-2"></div>
		<div class="col-xs-8 col-xs-offset-2"><img src="http://7xk9ts.com2.z0.glb.qiniucdn.com/seperator.png?imageView2/1/w/150/h/30/q/100" class="center-block" /></div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="grade10" id="grade10">高中一年级</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="grade11" id="grade11">高中二年级</button>
		</div>
		<div class="col-xs-10 col-xs-offset-1" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block options" name="grade12" id="grade12">高中三年级</button>
		</div>
		<button type="button" class="btn btn-lg btn-block btn-info laststep" name="laststep13" id="laststep13">上一步</button>
	</div>
	
	<div class="row" style="display:none" id="preview">
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<table>
			<tr><td>您选择的信息如下:</td></tr>
			<tr>
				<td>
					想学的课程
				</td>
				<td id="preview_subject">
				</td>
			</tr>
			<tr>
				<td>
					想学的兴趣
				</td>
				<td id="preview_interest">
				</td>
			</tr>
			<tr>
				<td>
					期望老师性别
				</td>
				<td id="preview_teacher_gender">
				</td>
			</tr>
			<tr>
				<td>
					期望教学地点
				</td>
				<td id="preview_location">
				</td>
			</tr>
			<tr>
				<td>
					接受的时薪范围
				</td>
				<td id="preview_price">
				</td>
			</tr>
			<tr>
				<td>
					小孩年级
				</td>
				<td id="preview_grade">
				</td>
			</tr>
			</table>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="preview_done" id="preview_done">完成</button>
			<button type="button" class="btn btn-lg btn-block btn-infor laststep" name="laststep_pre" id="laststep13">上一步</button>
		</div>
	</div>
	
	<div class="row" style="display:none" id="resultNotification">
		<div class="col-md-4 col-md-offset-4">
			<p class="text-left question">
				谢谢您的选择，我们会在24小时找到匹配您的老师并把结果发送给您，请输入您的手机号:
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
			<div class="row school-info">
				<div class="col-xs-1"></div>
				<div class="col-xs-10 text-center"><span>深圳大学</span><span id="teacherMajor">计算机学院</span></div>
				<div class="col-xs-1"></div>
			</div>
			<div class="row subjects">
				<div class="col-xs-1"></div>
				<div class="col-xs-10">
					<div class="col-xs-12 text-center subjects_label">课程</div>
					<div class="col-xs-12" style="padding: 0px">
						<div class="col-xs-6 subjects_value"><div class="text-center btn-info btn-doc">语文</div></div>
						<div class="col-xs-6 subjects_value"><div class="text-center btn-info">数学</div></div>
						<div class="col-xs-6 subjects_value"><div class="text-center btn-info">英语</div></div>
					</div>
				</div>
				<div class="col-xs-1"></div>
			</div>
			<div class="row interests" id="interestsRow">
				<div class="col-xs-1"></div>
				<div class="col-xs-10">
					<div class="col-xs-12 text-center interests_label">特长</div>
					<div class="col-xs-12" style="padding: 0px" id="availableInterests">
						
					</div>
				</div>
				<div class="col-xs-1"></div>
			</div>
		</div>
		<div class="row accept">
			<div class="btn btn-lg btn-primary col-xs-8 col-xs-offset-2" name="compeleteRecord" id="compeleteRecord">免费预约</div>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-infor laststep" name="laststep7" id="laststep7">上一步</button>
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
var rootUrl = $("#rootUrl").val();
var gender="";
var section;
var grade;
var choice;
var subject;
var interest;
var divArray = new Array();
var price;
var teacherGender;
var teacherOpenId;
var notifyMethod;
var mobile = "";
var address;

function showDiv($div){
	$div.show();
	divArray.push($div);
}

function insertParentAndChild(){
	var url = "http://"+rootUrl+"/service.php?requestMethod=insertParentAndChild&parentOpenId="+
	$("#openid").val()+"&choice="+choice+"&gender="+gender+"&grade="+grade+"&section="+
	section+"&teacherGender="+teacherGender+"&price="+price+"&address="+address;
	if(choice == "contentsub"){
		url += "&subject="+subject.toUpperCase();
	}else if(choice == "contentinte"){
		url += "&interest="+interest;
	}else if(choice == "contentboth"){
		url += "&subject="+subject.toUpperCase()+"&interest="+interest;
	}
	$.getJSON(url,function(data){
	});
}

$("#start").click(function(){
	$("#q0").hide("normal",function(){
		divArray.push($("#q0"));
		showDiv($("#q2"));
	});
});

$(".btn.btn-lg.btn-block").click(function(){
	$("button:visible").removeClass("clicked");
	$(this).addClass("clicked");
	var itemname = $(this).attr("name");
	if(itemname.indexOf("content") >= 0){
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
				var $div = $("<div>", {style: "margin-top:2px", class: "col-xs-8 col-xs-offset-2"});
				var $button = $("<button>", {type: "button", name: "specifici", class: "btn btn-lg btn-block options"}).attr("id",code[i]).text(name[i]);
				$button.click(function(){
					interest = $(this).attr("id");
					$("#q5").hide("normal",function(){
						showDiv($("#teacherGender"));
					});
				});
				$div.append($button);
				$("#q5").append($div);
			}
			$nextdiv = $("<div>", {style: "margin-top:2px", class: "col-xs-8 col-xs-offset-2"});
			$nextbutton = $("<button>", {type: "button", name: "laststep5", class: "btn btn-lg btn-block btn-infor laststep"}).attr("id","laststep5").text("上一步");
			$nextdiv.append($nextbutton);
			$("#q5").append($nextdiv);
			$("#q4").hide("normal",function(){
				showDiv($("#q5"));
				$("#laststep5").click(function(){
					var length = divArray.length;
					if(divArray[length - 1].attr('id') == "q5"){
						divArray[length - 1].find('div.col-xs-8.col-xs-offset-2').remove();
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
			showDiv($("#address"));
		});
	}else if(itemname.indexOf("address") >= 0){
		address = itemname;
		$("#address").hide("normal",function(){
			showDiv($("#price"));
		});
	}else if(itemname.indexOf("price") >= 0){
		price = itemname;
		$("#price").hide("normal",function(){
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
			parseCodeForDisplay();
		});
	}else if(itemname.indexOf("preview_done") >= 0){
		$("#preview").hide("normal",function(){
			insertParentAndChild();
			showDiv($("#resultNotification"));
		});	
	}
});

function parseCodeForDisplay(){
	var url = "http://"+rootUrl+"/service.php?requestMethod=parseCodeForDisplay&interest="+interest+"&grade="+grade+"&subject="+
	subject+"&teacherGender="+teacherGender+"&price="+price+"&address="+address;
	$.getJSON(url, function(data){
		$("#preview_subject").html(data.subject);
		$("#preview_interest").html(data.interest);
		$("#preview_teacher_gender").html(data.teacherGender);
		$("#preview_location").html(data.address);
		$("#preview_price").html(data.price);
		$("#preview_grade").html(data.grade);
	});	
	showDiv($("#preview"));
}

$("[id^=laststep]").click(function(){
	var length = divArray.length;
	//$("p").remove(".italic");
	if(divArray[length - 1].attr('id') == "q5"){
		divArray[length - 1].find('div.col-xs-8.col-xs-offset-2').remove();
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
	if(divArray[length - 2].attr('id') == "q2"){
		subject = "";
		interest = "";
	}
	divArray.pop();
});

/*$("#compeleteRecord").click(function(){
	var url = "http://"+rootUrl+"/service.php?requestMethod=saveTransaction&parentOpenId="+$("#openid").val()+"&teacherOpenId="+teacherOpenId+"&childId="+childId;
	$.getJSON(url,function(data){
		
	});
	$("#q8").hide("normal",function(){
		showDiv($("#q9"));
	});	
});*/

$("#myrecord").click(function(){
	window.location.href='https://open.weixin.qq.com/connect/oauth2/authorize?appid='+$appid+'&redirect_uri=http://'+rootUrl+'/myRecord.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect';
});

$("#save").click(function(){
	mobile = $("#contact").val();
	if(!validatePhone(mobile)){
		alert("请输入正确的手机号");
		return;
	}
	saveRecord($("#resultNotification"));
});

function saveRecord($hideDiv){
	var url = "http://"+rootUrl+"/service.php?requestMethod=updateParentMobile&parentOpenId="+$("#openid").val()+"&mobile="+mobile;
	$.getJSON(url, function(data){
	});	
	$hideDiv.hide("normal",function(){
		showDiv($("#q10"));
	});
}

function validatePhone(phone){
	var reg = /^(13[0-9]|14[0-9]|15[0-9]|18[0-9])\d{8}$/;
	if (reg.test(phone)) {
		return true;
	}else{
		return false;
	}
}
</script>
</body>
</html>