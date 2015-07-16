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
<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
<script src="js/vendor/html5shiv.js"></script>
<script src="js/vendor/respond.min.js"></script>
<![endif]-->
</head>
<body>
<input type="text" name="rootUrl" id="rootUrl" value="<?php echo $rootUrl; ?>" style="display:none">
<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<p class="text-center">
				后台管理
			</p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-2">
			<div class="form-group">
				<label ="startDate">起始日期(比如: 2015-07-03 18:20):</label>
				<input type="text" class="form-control" name="startDate" value="2015-07-03" id="startDate">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label ="endDate">结束日期(比如: 2015-07-04 09:20):</label>
				<input type="text" class="form-control" name="endDate" value="2015-07-04" id="endDate">
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<button type="button" class="btn btn-info btn-lg btn-block" name="submit" id="submit">提交</button>
		</div>
	</div>
	<div class="row" style="margin-top:10px">
		<div class="col-md-2 col-md-offset-3">
			<button type="button" class="btn btn-primary btn-lg btn-block" name="newtrans" id="newtrans">新订单</button>
		</div>
		<div class="col-md-2">
			<button type="button" class="btn btn-primary btn-lg btn-block" name="unapproval" id="unapproval">家长未同意</button>
		</div>
		<div class="col-md-2">
			<button type="button" class="btn btn-primary btn-lg btn-block" name="inprogress" id="inprogress">家长已同意</button>
		</div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-md-12">
			<div id="tableExcel" style="display:none" class="table-responsive">  
				<table id="test" class="table table-hover table-bordered" width="100%">
					<caption>所有交易记录</caption>  
      				<thead>
        				<tr>
          					<th>家长openid</th>  
          					<th>昵称</th>
          					<th>手机号</th>    
          					<th>年级</th>  
          					<th>科目</th>  
          					<th>兴趣</th>
          					<th>期望价格</th>
          					<th>期望老师性别</th>
          					<th>期望地点</th>
          					<th>交易时间</th>
          					<th>状态</th>
          					<th>备注</th> 
        				</tr>
      				</thead>
    				<tbody>
      				</tbody> 
				</table>  
			</div>
		</div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-md-12">
			<div id="confirmedExcel" class="table-responsive">  
				<table id="confirmedtrans" class="table table-hover table-bordered" width="100%">
					<caption>家长已同意交易记录</caption>  
      				<thead>
        				<tr>
          					<th>交易时间</th>
          					<th>跟踪员</th>
          					<th>家长openid</th>  
          					<th>昵称</th>
          					<th>手机号</th>    
          					<th>年级</th>  
          					<th>科目</th>  
          					<th>兴趣</th>
          					<th>老师姓名</th>
          					<th>老师手机号</th>
          					<th>试教时间</th>
          					<th>正式教课时间</th>
          					<th>费用</th>
          					<th>地点</th>
          					<th>状态</th>
          					<th>备注</th>  
        				</tr>
      				</thead>
    				<tbody>
      				</tbody> 
				</table>  
			</div>
		</div>
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
			$("#test > tbody").append($tr);
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
			$("#confirmedtrans > tbody").append($tr);
		}
			//$("$test").html($tr);
		$("#confirmedExcel").show();
	});
});

</script>
</body>
</html>