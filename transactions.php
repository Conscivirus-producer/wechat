<?php
require_once("config.php");

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>获取订单信息</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Loading Bootstrap -->
<link href="css/vendor/bootstrap.min.css" rel="stylesheet">
<!-- Loading Flat UI -->
<link href="css/flat-ui.min.css" rel="stylesheet">
<script src="js/vendor/jquery.min.js"></script>
<script src="js/jquery.ajaxfileupload.min.js"></script>
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
	<div class="row">
		<div class="col-md-4 col-md-offset-2">
			起始日期(比如: 2015-07-03 18:20):
			<input type="text" name="startDate" value="2015-07-03" id="startDate">
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-4 col-md-offset-2">
			结束日期(比如: 2015-07-04 09:20):<input type="text" name="endDate" value="2015-07-04" id="endDate">
		</div>
	</div>
	
	<div class="row" style="margin-top:30px">
		<div class="col-md-4 col-md-offset-4">
			<button type="button" class="btn btn-info btn-lg btn-block" name="submit" id="submit">提交</button>
		</div>
	</div>
	<div class="row" style="margin-top:30px">
		<div class="col-md-4 col-md-offset-4">
			<button type="button" class="" name="newtrans" id="newtrans">新订单</button>
			<button type="button" class="" name="unapproval" id="unapproval">家长未同意</button>
			<button type="button" class="" name="inprogress" id="inprogress">家长已同意</button>
		</div>
	</div>
	
<div id="tableExcel" style="display:none">  
<table id="test" width="100%" border="1" cellspacing="0" cellpadding="0">  
      <tr>  
          <td colspan="12" align="center">交易记录</td>  
      </tr>  
      <tr>  
          <td>家长openid</td>  
          <td>昵称</td>
          <td>手机号</td>    
          <td>年级</td>  
          <td>科目</td>  
          <td>兴趣</td>
          <td>期望价格</td>
          <td>期望老师性别</td>
          <td>期望地点</td>
          <td>交易时间</td>
          <td>状态</td>
          <td>备注</td>    
      </tr>  
</table>  
</div>

<div id="confirmedExcel" style="display:none">
<table id="confirmedtrans" width="100%" border="1" cellspacing="0" cellpadding="0">  
      <tr>  
          <td colspan="16" align="center">交易记录</td>  
      </tr>  
      <tr>  
          <td>交易时间</td>
          <td>跟踪员</td>
          <td>家长openid</td>  
          <td>昵称</td>
          <td>手机号</td>    
          <td>年级</td>  
          <td>科目</td>  
          <td>兴趣</td>
          <td>老师姓名</td>
          <td>老师手机号</td>
          <td>试教时间</td>
          <td>正式教课时间</td>
          <td>费用</td>
          <td>地点</td>
          <td>状态</td>
          <td>备注</td>    
      </tr>  
</table> 
</div>  
</div>
<!-- /.container -->
<!-- jQuery (necessary for Flat UI's JavaScript plugins) -->
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/vendor/video.js"></script>
<script src="js/flat-ui.min.js"></script>
<script type="text/javascript">
var rootUrl = $("#rootUrl").val();

$("#submit").click(function(){
	$("[id^=resultTr]").each(function(){
		$(this).remove();		
	});
	var startDate = $("#startDate").val();
	var endDate = $("#endDate").val();
	var url = "http://"+rootUrl+"/supporting.php?requestMethod=getTransactions&startDate="+startDate+"&endDate="+endDate;
	$.getJSON(url,function(data){
		var length = data.parentOpenId.length;
		for(var i=0; i<length;i++){
			$tr = $("<tr>", {style: "", class: ""}).attr("id","resultTr" + i);
			$tr.html("<td>"+data.parentOpenId[i]+
			"</td><td>"+data.nickname[i]+
			"</td><td>"+data.mobile[i]+
			"</td><td>"+data.grade[i]+
			"</td><td>"+data.subject[i]+
			"</td><td>"+data.interest[i]+
			"</td><td>"+data.expected_price[i]+
			"</td><td>"+data.expectedTeacherGender[i]+
			"</td><td>"+data.expectedLocation[i]+
			"</td><td>"+data.createdDt[i]+
			"</td><td>"+data.status[i]+
			"</td><td>"+data.comment[i]+
			"</td>");
			$("#test").append($tr);
		}
			//$("$test").html($tr);
		$("#tableExcel").show();
	});
});

$("#inprogress").click(function(){
	$("[id^=resultTr]").each(function(){
		$(this).remove();		
	});
	var startDate = $("#startDate").val();
	var endDate = $("#endDate").val();
	var url = "http://"+rootUrl+"/supporting.php?requestMethod=getConfirmedTransactions";
	$.getJSON(url,function(data){
		var length = data.parentOpenId.length;
		for(var i=0; i<length;i++){
			$tr = $("<tr>", {style: "", class: ""}).attr("id","resultTr" + i);
			$tr.html(
			"<td>"+data.createdDt[i]+
			"</td><td>"+data.follower[i]+
			"</td><td>"+data.parentOpenId[i]+
			"</td><td>"+data.nickname[i]+
			"</td><td>"+data.mobile[i]+
			"</td><td>"+data.grade[i]+
			"</td><td>"+data.subject[i]+
			"</td><td>"+data.interest[i]+
			"</td><td>"+data.teacherName[i]+
			"</td><td>"+data.teacherMobile[i]+
			"</td><td>"+data.trialTime[i]+
			"</td><td>"+data.fixedTime[i]+
			"</td><td>"+data.fee[i]+
			"</td><td>"+data.location[i]+
			"</td><td>"+data.status[i]+
			"</td><td>"+data.comment[i]+
			"</td>");
			$("#confirmedtrans").append($tr);
		}
			//$("$test").html($tr);
		$("#confirmedExcel").show();
	});
});

</script>
</body>
</html>