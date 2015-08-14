<?php
session_start();
//检测是否登录，若没登录则转向登录界面
if(!(isset($_SESSION['wojiaonixue_internal_login_status']) AND $_SESSION['wojiaonixue_internal_login_status'] == 'active')){
    header("Location:login.html");
    exit();
}
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
			<p class="text-center">
				<a href="login.php?action=logout">注销登录</a>
			</p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-2">
			<div class="form-group">
				<label ="startDate">起始日期(比如: 2015-07-03 18:20):</label>
				<input type="text" class="form-control" name="startDate" value="2015-07-04" id="startDate">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label ="endDate">结束日期(比如: 2015-07-04 09:20):</label>
				<input type="text" class="form-control" name="endDate" value="2015-07-05" id="endDate">
			</div>
		</div>
		<div class="col-md-4 col-md-offset-2">
			<div class="form-group">
				<label for="status">状态</label>
				<select class="form-control" name="status" id="status">
					<option value='1'>1.新订单</option>
					<option value='2'>2.客服已联系家长,家长未确定</option>
					<option value='3'>3.家长已同意,安排试教中</option>
					<option value='4'>4.已试教</option>
					<option value='5'>5.订单正式确定</option>
					<option value='S'>S.优质订单</option>
				</select>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="follower">跟踪人员</label>
				<select class="form-control" name="follower" id="follower">
					<option value='All'>All</option>
					<option value='超超'>超超</option>
					<option value='王劼'>王劼</option>
					<option value='姚燕'>姚燕</option>
					<option value='刘楠'>刘楠</option>
				</select>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<button type="button" class="btn btn-info btn-lg btn-block" name="submit" id="submit">提交</button>
			<button type="button" class="btn btn-info btn-lg btn-block" name="back" id="back">返回</button>
		</div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-md-12">
			<div id="confirmedExcel" class="table-responsive">  
				<table id="confirmedtrans" class="table table-hover table-bordered" width="100%">
					<caption>交易记录</caption>  
      				<thead>
        				<tr>
          					<th>交易时间</th>
          					<th>老师姓名</th>
          					<th>老师手机号</th>
          					<th>试教时间</th>
          					<th>正式教课时间</th>
          					<th>费用</th>
          					<th>地点</th>
          					<th>跟踪员</th>
          					<th>状态</th>
          					<th>备注</th>  
          					<th>家长信息</th>
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
	renderData($("#status").val(), $("#follower").val());
});

$("#back").click(function(){
	window.location.href="login.php";
});

function renderData(status, follower){
	$("[id^=resultTr]").each(function(){
		$(this).remove();		
	});
	var startDate = $("#startDate").val();
	var endDate = $("#endDate").val();
	var url = "http://"+rootUrl+"/supporting.php?requestMethod=getTransactionsByStatus&startDate="
		+startDate+"&endDate="+endDate+"&status="+status+"&follower="+follower;
	$.getJSON(url,function(data){
		var length = data.parentOpenId.length;
		for(var i=0; i<length;i++){
			$tr = $("<tr>", {style: "", class: ""}).attr("id","resultTr" + i);
			$tr.html("<td class='transactionId' style='display:none'>"+data.transactionId[i]+
			"</td><td>"+data.createdDt[i]+
			"</td><td class='teacherName'>"+data.teacherName[i]+
			"</td>");
			$("<td>").appendTo($tr).html("<span>"+data.teacherMobile[i]+"</span>").bind({
				click: function(e){
					$td = $(this);
					$(this).children("span").hide();
					if($(this).children("textarea").length == 0){
						$("<textarea>").appendTo($(this)).html($(this).children("span").html());
						$("<button>").appendTo($(this)).html("提交").bind({
							click: function(e){
								var transactionId = $td.prevAll(".transactionId").text();
								var mobile = $td.children("textarea").val();
								var url = "transactionService.php?dataType=findTeacherByMobile&mobile="+mobile;
								$.getJSON(url, function(json){
  									if(json.status == "ok"){
										var newTeacherOpenId = json.openId;
										var newTeacherName = json.name;
										var newTeacherMobile = json.mobile;
										var newUrl = "transactionService.php?dataType=updateTeacher&transactionId="+transactionId+"&openId="+newTeacherOpenId;
										$.getJSON(newUrl, function(json){
  											if(json.status == "ok"){
  												 $td.prevAll(".teacherName").text(newTeacherName);
  												 $td.children("textarea").hide();
												 $td.children("button").hide();
												 $td.children("span").html(newTeacherMobile);
												 $td.children("span").show();
  											}
										});
  									}else{
  										alert("此手机号不存在！");
  									}
								});
								e.stopPropagation();
							}
						});
					}else{
						$(this).children("span").hide();
						$(this).children("textarea").show();
						$(this).children("button").show();
					}
				},
				mouseleave: function(e) {
					$(this).children("textarea").hide();
					$(this).children("button").hide();
					$(this).children("span").show();
				}
			});
			
			$("<td>").appendTo($tr).html("<span>"+data.trialTime[i]+"</span>").bind({
				click: function(e){
					$td = $(this);
					$(this).children("span").hide();
					if($(this).children("textarea").length == 0){
						$("<textarea>").appendTo($(this)).html($(this).children("span").html());
						$("<button>").appendTo($(this)).html("提交").bind({
							click: function(e){
								var transactionId = $td.prevAll(".transactionId").text();
								var trialTime = $td.children("textarea").val();
								var url = "transactionService.php?dataType=updateTrialTime&transactionId="+transactionId+"&trialTime="+trialTime;
								$.getJSON(url, function(json){
  									if(json.status == "ok"){
  										$td.children("textarea").hide();
  										$td.children("button").hide();
  										$td.children("span").html(trialTime);
  										$td.children("span").show();
  									}
								});
								e.stopPropagation();
							}
						});
					}else{
						$(this).children("span").hide();
						$(this).children("textarea").show();
						$(this).children("button").show();
					}
				},
				mouseleave: function(e) {
					$(this).children("textarea").hide();
					$(this).children("button").hide();
					$(this).children("span").show();
				}
			});
			
			$("<td>").appendTo($tr).html("<span>"+data.fixedTime[i]+"</span>").bind({
				click: function(e){
					$td = $(this);
					$(this).children("span").hide();
					if($(this).children("textarea").length == 0){
						$("<textarea>").appendTo($(this)).html($(this).children("span").html());
						$("<button>").appendTo($(this)).html("提交").bind({
							click: function(e){
								var transactionId = $td.prevAll(".transactionId").text();
								var fixedTime = $td.children("textarea").val();
								var url = "transactionService.php?dataType=updateFixedTime&transactionId="+transactionId+"&fixedTime="+fixedTime;
								$.getJSON(url, function(json){
  									if(json.status == "ok"){
  										$td.children("textarea").hide();
  										$td.children("button").hide();
  										$td.children("span").html(fixedTime);
  										$td.children("span").show();
  									}
								});
								e.stopPropagation();
							}
						});
					}else{
						$(this).children("span").hide();
						$(this).children("textarea").show();
						$(this).children("button").show();
					}
				},
				mouseleave: function(e) {
					$(this).children("textarea").hide();
					$(this).children("button").hide();
					$(this).children("span").show();
				}
			});
			$("<td>").appendTo($tr).html("<span>"+data.fee[i]+"</span>").bind({
				click: function(e){
					$td = $(this);
					$(this).children("span").hide();
					if($(this).children("textarea").length == 0){
						$("<textarea>").appendTo($(this)).html($(this).children("span").html());
						$("<button>").appendTo($(this)).html("提交").bind({
							click: function(e){
								var transactionId = $td.prevAll(".transactionId").text();
								var fee = $td.children("textarea").val();
								var url = "transactionService.php?dataType=updateFee&transactionId="+transactionId+"&fee="+fee;
								$.getJSON(url, function(json){
  									if(json.status == "ok"){
  										$td.children("textarea").hide();
  										$td.children("button").hide();
  										$td.children("span").html(fee);
  										$td.children("span").show();
  									}
								});
								e.stopPropagation();
							}
						});
					}else{
						$(this).children("span").hide();
						$(this).children("textarea").show();
						$(this).children("button").show();
					}
				},
				mouseleave: function(e) {
					$(this).children("textarea").hide();
					$(this).children("button").hide();
					$(this).children("span").show();
				}
			});
			$("<td>").appendTo($tr).html("<span>"+data.location[i]+"</span>").bind({
				click: function(e){
					$td = $(this);
					$(this).children("span").hide();
					if($(this).children("textarea").length == 0){
						$("<textarea>").appendTo($(this)).html($(this).children("span").html());
						$("<button>").appendTo($(this)).html("提交").bind({
							click: function(e){
								var transactionId = $td.prevAll(".transactionId").text();
								var location = $td.children("textarea").val();
								var url = "transactionService.php?dataType=updateLocation&transactionId="+transactionId+"&location="+location;
								$.getJSON(url, function(json){
  									if(json.status == "ok"){
  										$td.children("textarea").hide();
  										$td.children("button").hide();
  										$td.children("span").html(location);
  										$td.children("span").show();
  									}
								});
								e.stopPropagation();
							}
						});
					}else{
						$(this).children("span").hide();
						$(this).children("textarea").show();
						$(this).children("button").show();
					}
				},
				mouseleave: function(e) {
					$(this).children("textarea").hide();
					$(this).children("button").hide();
					$(this).children("span").show();
				}
			});
			$("<td>").appendTo($tr).html("<span>"+data.follower[i]+"</span>").bind({
				click: function(e){
					$td = $(this);
					$(this).children("span").hide();
					if($(this).children("textarea").length == 0){
						$("<textarea>").appendTo($(this)).html($(this).children("span").html());
						$("<button>").appendTo($(this)).html("提交").bind({
							click: function(e){
								var transactionId = $td.prevAll(".transactionId").text();
								var follower = $td.children("textarea").val();
								var url = "transactionService.php?dataType=updateFollower&transactionId="+transactionId+"&follower="+follower;
								$.getJSON(url, function(json){
  									if(json.status == "ok"){
  										$td.children("textarea").hide();
  										$td.children("button").hide();
  										$td.children("span").html(follower);
  										$td.children("span").show();
  									}
								});
								e.stopPropagation();
							}
						});
					}else{
						$(this).children("span").hide();
						$(this).children("textarea").show();
						$(this).children("button").show();
					}
				},
				mouseleave: function(e) {
					$(this).children("textarea").hide();
					$(this).children("button").hide();
					$(this).children("span").show();
				}
			});
			$("<td>").appendTo($tr).html("<span>"+data.status[i]+"</span>").bind({
				click : function(e) {
					// Hover event handler
					var $clickedtd = $(this);
					$(this).children("span").hide();
					if($(this).children("select").length == 0){
				$("<select>"+
				"<option value='1'>1.新订单</option>"+
				"<option value='2'>2.客服已联系家长,家长未确定</option>"+
				"<option value='3'>3.家长已同意,安排试教中</option>"+
				"<option value='4'>4.已试教</option>"+
				"<option value='4'>5.订单正式确定</option>"+
				"<option value='S'>S.优质订单</option>"+
				"<option value='C'>C.取消</option></select>").appendTo($(this)).bind({
					change: function(e){
						var selectedOptionValue = $(this).children('option:selected').val();
						var selectedValue = $(this).children('option:selected').text(); 
						var transactionId = $clickedtd.prevAll(".transactionId").text();
						var url = "transactionService.php?dataType=updateTransactionStatus&transactionId="+transactionId+"&status="+selectedOptionValue;
						$.getJSON(url, function(json){
  							if(json.status == "ok"){
  								$clickedtd.children("select").hide();
  								$clickedtd.children("span").html(selectedValue);
  								$clickedtd.children("span").show();
  							}
						});
						
						e.stopPropagation();
					}
				});
				}else{
					$(this).children("select").show();
				}
				
				},
				mouseleave: function(e) {
					// Hover event handler
					$(this).children("select").hide();
					$(this).children("span").show();
				}
				
			});
			$("<td>").appendTo($tr).html("<span>"+data.comment[i]+"</span>").bind({
				click : function(e){
					var $clickedtd = $(this);
					$(this).children("span").hide();
					if($(this).children("textarea").length == 0){
						$("<textarea></textarea>").appendTo($(this)).html($(this).children("span").html());
						$("<button>").appendTo($(this)).html("提交").bind({
							click:function(e){
								var comment = $clickedtd.children("textarea").val();
								var transactionId = $clickedtd.prevAll(".transactionId").text();
								var url = "transactionService.php?dataType=updateComment&transactionId="+transactionId+"&comment="+comment;
								$.getJSON(url, function(json){
  									if(json.status == "ok"){
  										$clickedtd.children("textarea").hide();
  										$clickedtd.children("button").hide();
  										$clickedtd.children("span").html(comment);
  										$clickedtd.children("span").show();
  									}
								});
							}
						});
					}else{
						$(this).children("textarea").show();
						$(this).children("button").show();
					}
				},
				mouseleave: function(e) {
					$(this).children("textarea").hide();
					$(this).children("button").hide();
					$(this).children("span").show();
				}
			});
			$("<td>").appendTo($tr).html(data.parentOpenId[i] + "</br>" + "手机: " + data.mobile[i] + "</br>" + "年级: " + data.grade[i] 
				+ "</br>" + "呢称: " + data.nickname[i] + "</br>" + "科目: " + data.subject[i] + "</br>" + "兴趣: " + data.interest[i]
				+ "</br>" + "期望价格: " + data.expected_price[i] + "</br>" + "期望性别: " + data.expectedTeacherGender[i] + "</br>" + "期望地点: " + data.expectedLocation[i]);
			$("#confirmedtrans > tbody").append($tr);
		}
		$("#confirmedExcel").show();
	});
}

</script>
</body>
</html>