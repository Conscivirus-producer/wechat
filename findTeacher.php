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
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="boy" id="boy">男生</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-primary" name="girl" id="girl">女生</button>
		</div>
	</div>
	
	<div class="row" style="display:none" id="q2">
		<div class="col-md-4 col-md-offset-4">
			<p class="text-left">
				问题2：年级是？
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
	</div>
	
	<div class="row" style="display:none" id="q3">
		<div class="col-md-4 col-md-offset-4">		
			<p class="text-left">
				问题3：他/她哪个科目最需要提高？
			</p>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-default" name="chi" id="chi">语文</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-default" name="eng" id="eng">英语</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-default" name="mat" id="mat">数学</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:5px">
			<button type="button" class="btn btn-lg btn-block btn-info" name="gradenext" id="gradenext">下一项</button>
		</div>
	</div>
	
	<div class="row" style="display:none" id="q4">
		<div class="col-md-4 col-md-offset-4">		
			<p class="text-left">
				问题4：您还希望您的孩子学什么？
			</p>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-default" name="sci" id="sci">科学</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-default" name="eco" id="eco">经济</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-default" name="spo" id="spo">运动</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-default" name="art" id="art">艺术</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:2px">
			<button type="button" class="btn btn-lg btn-block btn-default" name="mus" id="mus">音乐</button>
		</div>
		<div class="col-md-2 col-md-offset-6" style="margin-top:5px">
			<button type="button" class="btn btn-lg btn-block btn-info" name="interestnext" id="interestnext">下一项</button>
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
		<div class="col-md-2 col-md-offset-6">
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
$(".btn.btn-lg.btn-block").click(function(){
	if($(this).attr("name") == "boy" || $(this).attr("name") == "girl"){
		$("#q1").hide("fast",function(){
			$("#q2").show();
		});
	}else if($(this).attr("name").indexOf("grade") >= 0){
		$("#q2").hide("fast",function(){
			$("#q3").show();
		});
	}else if($(this).attr("name") != "save"){
		$(this).toggleClass("btn-primary");
		$(this).toggleClass("btn-default");
	}
});
$("#gradenext").click(function(){
	$("#q3").hide("fast",function(){
		$("#q4").show();
	});
});
$("#interestnext").click(function(){
	$("#q4").hide("fast",function(){
		$("#q5").show();
	});
});
</script>
</body>
</html>















