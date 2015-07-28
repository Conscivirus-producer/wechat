<?php
require_once("../config.php");

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>获取订单信息</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Loading Bootstrap -->
<link href="../css/vendor/bootstrap.min.css" rel="stylesheet">
<!-- Loading Flat UI -->
<link href="../css/flat-ui.min.css" rel="stylesheet">
<script src="../js/vendor/jquery.min.js"></script>
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
		<div class="col-md-4 col-md-offset-4">
			<a href="index.php?logout">test</a>
			<button type="button" class="btn btn-info btn-lg btn-block" name="mgt_transactions" id="mgt_transactions">管理订单</button>
			<button type="button" class="btn btn-info btn-lg btn-block" name="rpt_users" id="rpt_users">回复用户</button>
			<button type="button" class="btn btn-info btn-lg btn-block" name="mgt_teachers" id="mgt_teachers">管理老师</button>
		</div>
	</div>
 
</div>
<!-- /.container -->
<!-- jQuery (necessary for Flat UI's JavaScript plugins) -->
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../js/vendor/video.js"></script>
<script src="../js/flat-ui.min.js"></script>
<script type="text/javascript">
$("#mgt_transactions").click(function(){
	window.location.href="views/transactions.php";
});
</script>
</body>
</html>