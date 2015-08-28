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
<title>订单查询管理后台</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Loading Bootstrap -->
<link href="http://www.ilearnnn.com/timepicker/sample in bootstrap v3/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="http://www.ilearnnn.com/timepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<style>
*{
	font-size:10px;
}
</style>
<link rel="shortcut icon" href="http://7xk9ts.com2.z0.glb.qiniucdn.com/logo.ico">
</head>
<body>
<input type="text" name="rootUrl" id="rootUrl" value="<?php echo $rootUrl; ?>" style="display:none">
<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<p class="text-center">
				订单查询管理后台
			</p>
		</div>
		<div class="col-md-2 col-md-offset-5">
			<a href="login.php?action=logout" class="btn btn-info btn-sm btn-block" role="button">注销登录</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2 col-md-offset-1">
			<div class="form-group">
				<label for="startDate">起始日期:</label>
				<input type="text" class="form-control input-sm" name="startDate" value="" id="startDate" data-date-format="yyyy-mm-dd hh:ii">
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label for="endDate">结束日期:</label>
				<input type="text" class="form-control input-sm" name="endDate" value="" id="endDate" data-date-format="yyyy-mm-dd hh:ii">
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label for="openid">家长openId:</label>
				<input type="text" class="form-control input-sm" name="openid" value="" id="openid">
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label for="status">状态</label>
				<select class="form-control input-sm" name="status" id="status">
					<option value='1'>1.新订单</option>
					<option value='2'>2.客服已联系家长,家长未确定</option>
					<option value='3'>3.家长已同意,安排试教中</option>
					<option value='4'>4.已试教</option>
					<option value='5'>5.订单正式确定</option>
					<option value='E'>E.订单中途结束</option>
					<option value='S'>S.优质订单</option>
				</select>
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label for="follower">跟踪人员</label>
				<select class="form-control input-sm" name="follower" id="follower">
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
		<div class="col-md-2 col-md-offset-5">
			<button type="button" class="btn btn-info btn-sm btn-block" name="submit" id="submit">提交</button>
			<button type="button" class="btn btn-info btn-sm btn-block" name="back" id="back">返回</button>
		</div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-md-12">
			<div id="confirmedExcel" class="table-responsive">  
				<table id="confirmedtrans" class="table table-hover table-bordered" width="100%">
					<caption>交易记录 (数量:<span id="transCount" name="transCount"></span>)</caption>  
      				<thead>
        				<tr>
        					<th width="8.33%">交易号</th>
          					<th width="8.33%">交易时间</th>
          					<th width="8.33%">老师姓名</th>
          					<th width="8.33%">老师手机号</th>
          					<th width="8.33%">试教时间</th>
          					<th width="8.33%">开始上课时间</th>
          					<th width="7.69%">每周上课时间</th>
          					<th width="8.33%">费用</th>
          					<th width="8.33%">地点</th>
          					<th width="8.33%">跟踪员</th>
          					<th width="8.33%">状态</th>
          					<th width="8.33%">备注</th>  
          					<th width="8.33%">家长信息</th>
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
<script type="text/javascript" src="http://www.ilearnnn.com/timepicker/sample in bootstrap v3/jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="http://www.ilearnnn.com/timepicker/sample in bootstrap v3/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="timepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="timepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
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
	var openid = $("#openid").val();
	var url = "http://"+rootUrl+"/supporting.php?requestMethod=getTransactionsByStatus&startDate="
		+startDate+"&endDate="+endDate+"&status="+status+"&follower="+follower+"&openid="+openid;
	$.getJSON(url,function(data){
		var length = data.parentOpenId.length;
		$("#transCount").text(length);
		for(var i=0; i<length;i++){
			$tr = $("<tr>", {style: "", class: ""}).attr("id","resultTr" + i);
			$tr.html("<td class='transactionId' id="+data.transactionId[i]+">"+data.transactionId[i]+
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
								transactionId = transactionId.substring(2)
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
			
			
			
			//开始上课时间
			$("<td>").appendTo($tr).html("<span>"+data.fixedTime[i]+"</span>").bind({
				click: function(e){
					$td = $(this);
					$(this).children("span").hide();
					if($(this).children("input").length == 0){
						$("<input>").appendTo($(this)).attr("class","form-control input-sm").attr("data-date-format","yyyy-mm-dd").datetimepicker({
        					language:  'zh-CN',
       						weekStart: 1,
        					todayBtn:  1,
							autoclose: 1,
							todayHighlight: 1,
							startView: 2,
							minView: 2,
							forceParse: 0
    					});
						$("<button>").attr("class","btn btn-info btn-block btn-xs").attr("style","margin-top:5px").appendTo($(this)).html("提交").bind({
							click: function(e){
								var transactionId = $td.prevAll(".transactionId").text();
								var fixedTime = $td.children("input").val();
								var url = "transactionService.php?dataType=updateFixedTime&transactionId="+transactionId+"&fixedTime="+fixedTime;
								$.getJSON(url, function(json){
  									if(json.status == "ok"){
  										$td.children("input").hide();
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
						$(this).children("input").show();
						$(this).children("button").show();
					}
				}
			});
			
			//每周上课时间
			$("<td>").appendTo($tr).html("<span>"+data.teachingFrequency[i]+"</span>").bind({
				click: function(e){
					$td = $(this);
					$(this).children("span").hide();
					if($(this).children("div").length == 0){
						$("<div class='checkbox'><label><input type='checkbox' value='1'>周一</label></div>").appendTo($(this));
						$("<div class='checkbox'><label><input type='checkbox' value='2'>周二</label></div>").appendTo($(this));
						$("<div class='checkbox'><label><input type='checkbox' value='3'>周三</label></div>").appendTo($(this));
						$("<div class='checkbox'><label><input type='checkbox' value='4'>周四</label></div>").appendTo($(this));
						$("<div class='checkbox'><label><input type='checkbox' value='5'>周五</label></div>").appendTo($(this));
						$("<div class='checkbox'><label><input type='checkbox' value='6'>周六</label></div>").appendTo($(this));
						$("<div class='checkbox'><label><input type='checkbox' value='7'>周日</label></div>").appendTo($(this));
						$("<button>").attr("class","btn btn-info btn-block btn-xs").attr("style","margin-top:5px").appendTo($(this)).html("提交").bind({
							click: function(e){
								var transactionId = $td.prevAll(".transactionId").text();
								var checkboxes = $td.find("input[type='checkbox']");
								var teachingFrequencyArray = new Array();
								checkboxes.each(function(){
									if($(this).is(':checked')){
										teachingFrequencyArray.push($(this).attr("value"));
									}
								});
								var teachingFrequency = teachingFrequencyArray.join(",");
								var url = "transactionService.php?dataType=updateTeachingFrequency&transactionId="+transactionId+"&teachingFrequency="+teachingFrequency;
								$.getJSON(url, function(json){
  									if(json.status == "ok"){
  										$td.children("div").hide();
  										$td.children("button").hide();
  										$td.children("span").html(teachingFrequency);
  										$td.children("span").show();
  									}
								});
								
								e.stopPropagation();
							}
						});
					}else{
						$(this).children("span").hide();
						$(this).children("div").show();
						$(this).children("button").show();
					}
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
				"<option value='5'>5.订单正式确定</option>"+
				"<option value='E'>E.订单中途结束</option>"+
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
$('#startDate').datetimepicker({
    language:  'zh-CN',
    weekStart: 1,
    todayBtn:  1,
	autoclose: 1,
	todayHighlight: 1,
	startView: 2,
	minView: 1,
	forceParse: 0
});
$('#endDate').datetimepicker({
    language:  'zh-CN',
    weekStart: 1,
    todayBtn:  1,
	autoclose: 1,
	todayHighlight: 1,
	startView: 2,
	minView: 1,
	forceParse: 0
});
</script>
</body>
</html>