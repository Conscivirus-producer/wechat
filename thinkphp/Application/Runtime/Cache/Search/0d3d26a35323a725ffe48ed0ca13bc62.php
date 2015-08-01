<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>老师信息查询</title>
<link href="http://localhost/timepicker/sample in bootstrap v3/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="http://localhost/timepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<style>
*{
	font-size:10px;
}
</style>
</head>
<body>
<div class="container">
<div class="row">
	<div class="col-md-2 col-md-offset-5">
		<h5 class="text-center">老师信息查询</h5>
	</div>	
</div>
<form method="post" action="">
<div class="row">
  <div class="col-md-2">
  	<div class="form-group">
    	<label for="name">姓名：</label>
    	<input type="text" class="form-control input-sm" id="name" name="name">
  	</div>
  </div>
  <div class="col-md-2">
  	<div class="form-group">
    	<label for="studentNumber">学号：</label>
    	<input type="text" class="form-control input-sm" id="studentNumber" name="studentNumber">
  	</div>
  </div>
  <div class="col-md-2">
  	<div class="form-group">
    	<label for="faculty">学院：</label>
    	<input type="text" class="form-control input-sm" id="faculty" name="faculty">
  	</div>
  </div>
  <div class="col-md-2">
  	<div class="form-group">
    	<label for="major">专业：</label>
    	<input type="text" class="form-control input-sm" id="major" name="major">
  	</div>
  </div>
	<div class="col-md-2">
  	<div class="form-group">
    	<label for="gender">性别：</label>
    	<select class="form-control input-sm" id="gender" name="gender">
  			<option value="">不限</option>
  			<option value="m">男</option>
  			<option value="f">女</option>
		</select>
  	</div>
  </div>
  <div class="col-md-2">
  	<div class="form-group">
    	<label for="mobile">手机：</label>
    	<input type="text" class="form-control input-sm" id="mobile" name="mobile">
  	</div>
  </div>
</div>
<div class="row">
	<div class="col-md-2">
  		<div class="form-group">
    		<label for="typeCode">科目大类：</label>
    		<select class="form-control input-sm" id="typeCode" name="typeCode">
			</select>
  		</div>
  	</div>
  	<div class="col-md-2">
  		<div class="form-group">
    		<label for="code">科目小类：</label>
    		<select class="form-control input-sm" id="code" name="code">
			</select>
  		</div>
  	</div>
  	<div class="col-md-2">
  		<div class="form-group">
    		<label for="starttime">注册开始时间：</label>
    		<input class="form-control input-sm" id="starttime" name="starttime" readonly>
  		</div>
  	</div>
  	<div class="col-md-2">
  		<div class="form-group">
    		<label for="endtime">注册结束时间：</label>
    		<input class="form-control input-sm" id="endtime" name="endtime" readonly>
  		</div>
  	</div>
  	<div class="col-md-2">
  		<div class="form-group">
    		<label for="highestGrade">最高可教年级：</label>
    		<select class="form-control input-sm" id="highestGrade" name="highestGrade">
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
  	<div class="col-md-2">
  		<div class="form-group">
    		<label for="address">可教地点：</label>
    		<select class="form-control input-sm" id="address" name="address">
    			<option value="">不限</option>
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
	<div class="col-md-2 col-md-offset-5">
		<input type="submit" class="btn btn-info btn-block" name="search" id="search" value="查询">
	</div>
</div>
</form>
<div class="row" style="margin-top:10px">
	<div class="col-md-12">
	<div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th width="12.5">基本信息</th>
            <th width="12.5">注册时间</th>
            <th width="12.5">个人描述</th>
            <th width="12.5">可教科目</th>
            <th width="12.5">时薪</th>
            <th width="12.5">年级</th>
            <th width="12.5">地点</th>
            <th width="12.5">证书</th>
          </tr>
        </thead>
        <tbody>
           <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
		<td width="12.5">姓名：<?php echo ($vo["name"]); ?><br>学院：<?php echo ($vo["faculty"]); ?><br>专业：<?php echo ($vo["major"]); ?><br>性别：<?php echo ($vo["gender"]); ?><br>手机号：<?php echo ($vo["mobile"]); ?><br>学号：<?php echo ($vo["studentnumber"]); ?><br></td>
		<td width="12.5"><?php echo ($vo["created_dt"]); ?></td>
		<td width="12.5"><?php echo ($vo["description"]); ?></td>
		<td width="12.5">
		 <?php if(is_array($vo['offer'])): $i = 0; $__LIST__ = $vo['offer'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$offer): $mod = ($i % 2 );++$i; echo ($offer["name"]); ?><br><?php endforeach; endif; else: echo "" ;endif; ?>  
		</td>
		<td width="12.5"><?php echo ($vo["price"]); ?></td>
		<td width="12.5"><?php echo ($vo["highestgrade"]); ?></td>
		<td width="12.5"><?php echo ($vo["address"]); ?></td>
		<td width="12.5">
		 <?php if(is_array($vo['certificate'])): $i = 0; $__LIST__ = $vo['certificate'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$certificate): $mod = ($i % 2 );++$i; echo ($certificate["description"]); ?><br><?php endforeach; endif; else: echo "" ;endif; ?>
		</td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
      </table>
    </div><!-- /.table-responsive -->
	</div>
</div>
</div>
<script type="text/javascript" src="http://localhost/timepicker/sample in bootstrap v3/jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="http://localhost/timepicker/sample in bootstrap v3/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="http://localhost/timepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="http://localhost/timepicker/js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
<script type="text/javascript">
$('#starttime').datetimepicker({
    language:  'en',
    weekStart: 1,
    todayBtn:  1,
	autoclose: 1,
	todayHighlight: 1,
	startView: 2,
	minView: 2,
	forceParse: 0
});
$('#endtime').datetimepicker({
    language:  'en',
    weekStart: 1,
    todayBtn:  1,
	autoclose: 1,
	todayHighlight: 1,
	startView: 2,
	minView: 2,
	forceParse: 0
});

</script>
</body>
</html>