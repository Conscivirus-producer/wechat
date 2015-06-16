<?php
if (isset($_GET['code'])){
    $code = $_GET['code'];
    $access_token_get_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxff8be5bff1233b99&secret=5b2185614933a05097a0b0bbc224e83a&code=".$code."&grant_type=authorization_code";
    $access_token_json = file_get_contents($access_token_get_url); 
    $json_obj = json_decode($access_token_json,true);
    $openid = $json_obj["openid"];
}else{
	//need to be modified to show hint and qrcode image
    echo "NO CODE";
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
<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
<script src="js/vendor/html5shiv.js"></script>
<script src="js/vendor/respond.min.js"></script>
<![endif]-->
</head>
<body>
<input type="text" name="openid" id="openid" value="<?php echo $openid; ?>" style="display:none">
<div class="container">
	<div class="row" id="q1">
		<div class="col-md-4 col-md-offset-4">
			<p class="text-left">
				欢迎来到你教我学！请完成下面的几个简单问题来找到跟您匹配的老师。
			</p>
			<p class="text-left">
			问题1：您的孩子是男生还是女生？
			</p>
			<div class="form-group">
				<select class="form-control" name="sex" id="sex">
					<option value="sex" selected="selected">性别</option>
  					<option value="boy">男生</option>
  					<option value="girl">女生</option>
				</select>
			</div>
		</div>
	</div>
	
	<div class="row" style="display:none" id="q2">
		<div class="col-md-4 col-md-offset-4">
			<p class="text-left">
				问题2：年级是？
			</p>
			<div class="form-group">
				<select class="form-control" name="grade" id="grade">
					<option value="grade" selected="selected">年级</option>
  					<option value="g1">1</option>
  					<option value="g2">2</option>
  					<option value="g3">3</option>
  					<option value="g4">4</option>
  					<option value="g5">5</option>
  					<option value="g6">6</option>
				</select>
			</div>
		</div>
	</div>
	
	<div class="row" style="display:none" id="q3">
		<div class="col-md-4 col-md-offset-4">		
			<p class="text-left">
				问题3：他/她哪个科目最需要提高？
			</p>
			<div class="form-group">
				<select class="form-control" name="subject" id="subject">
					<option value="subject" selected="selected">科目</option>
  					<option value="chi">语文</option>
  					<option value="eng">英语</option>
  					<option value="mat">数学</option>
  					<option value="all">上面所有</option>
				</select>
			</div>
		</div>
	</div>
	
	<div class="row" style="display:none" id="q4">
		<div class="col-md-4 col-md-offset-4">		
			<p class="text-left">
				问题4：您还希望您的孩子学什么？
			</p>
			<div class="form-group">
				<select class="form-control" name="course" id="course">
					<option value="course" selected="selected">课外课程</option>
  					<option value="sci">科学</option>
  					<option value="eco">经济</option>
  					<option value="spo">运动</option>
  					<option value="art">艺术</option>
  					<option value="mus">音乐</option>
				</select>
			</div>
		</div>
	</div>
	
	<div class="row" style="display:none" id="q5">
		<div class="col-md-4 col-md-offset-4">
			<p class="text-left">
				恭喜！我们会在24小时内找到匹配您的课程。我们会把结果推送给您，或者您也可以在我的记录里面查找。请留下您的联系方式。
			</p>
			<div class="form-group">
				<input type="text" value="" class="form-control" name="contact" id="contact" placeholder="請輸入联系方式">
			</div>
		</div>
		<div class="col-md-6 col-md-offset-2">
			<button type="button" class="btn btn-primary btn-lg btn-block" name="save" id="save">提交</button>
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
$("#sex").change(function(){
	if($("#sex").val() != "sex"){
		$("#q1").hide("fast",function(){
			$("#q2").show();
		});
	}
});

$("#grade").change(function(){
	if($("#grade").val() != "grade"){
		$("#q2").hide("fast",function(){
			$("#q3").show();
		});
	}
});

$("#subject").change(function(){
	if($("#subject").val() != "subject"){
		$("#q3").hide("fast",function(){
			$("#q4").show();
		});
	}
});

$("#course").change(function(){
	if($("#course").val() != "course"){
		$("#q4").hide("fast",function(){
			$("#q5").show();
		});
	}
});
</script>
</body>
</html>















