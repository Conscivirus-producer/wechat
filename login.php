<?php
//注销登录
if($_GET['action'] == "logout"){
	session_start();
    unset($_SESSION['userid']);
    unset($_SESSION['username']);
	unset($_SESSION['wojiaonixue_internal_login_status']);
	session_destroy();
    echo '注销登录成功！点击此处 <a href="login.html">登录</a>';
    exit;
}
//登录
if(isset($_POST['submit'])){
	$username = htmlspecialchars($_POST['username']);
	$userPwd = MD5($_POST['password']);
	
	//包含数据库连接文件
	include('conn.php');
	//检测用户名及密码是否正确
	$query = "set names utf8";
	$result = $conn->query($query);
	$query = "select user_id from is_users where user_name='$username' and user_password_hash='$userPwd' limit 1";
	$result = $conn->query($query);
	$successLogin;
	if($result->num_rows > 0){
	    //登录成功
	    session_start();
		$row = $result->fetch_assoc();
	    $_SESSION['username'] = $username;
	    $_SESSION['userid'] = $row['user_id'];
		$_SESSION['wojiaonixue_internal_login_status'] = 'active';
		$successLogin = "1";
	    /*echo '登录成功！<br /><a href="my.php">订单管理</a><br />';
		echo '<a href="replyToParent.php">回复家长</a><br />';
	    echo '点击此处 <a href="login.php?action=logout">退出</a> 登录！<br />';*/
	} else {
		$successLogin = "0";
	    exit('登录失败！点击此处 <a href="javascript:history.back(-1);">返回</a> 重试');
	}
}else{
	session_start();
	if(!(isset($_SESSION['wojiaonixue_internal_login_status']) AND $_SESSION['wojiaonixue_internal_login_status'] == 'active')){
	    header("Location:login.html");
	}
}

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>后台管理</title>
<link href="css/vendor/bootstrap.min.css" rel="stylesheet">
<!-- Loading Flat UI -->
<link href="css/flat-ui.min.css" rel="stylesheet">
<script src="js/vendor/jquery.min.js"></script>
<link rel="shortcut icon" href="http://7xk9ts.com2.z0.glb.qiniucdn.com/logo.ico">
</head>
<body>
<input type="text" name="successLogin" id="successLogin" value="<?php echo $successLogin; ?>" style="display:none">
<div class="container">
	<div class="row" style="margin-top: 50px">
		<div class="col-md-2 col-md-offset-5">
			<span style="">登录成功</span>
			<div class="form-group">
				<a href="transactions.php" target="_blank">订单管理</a><br />
				<a href="thinkphp/?m=Search&c=Teacher&a=read" target="_blank">老师查询</a><br />
				<a href="replyToParent.php" target="_blank">回复家长</a><br />
				<a href="login.php?action=logout">退出登录</a> 
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$("#mgt_trans").click(function(){
	window.location.href="transactions.php";
});

$("#rpt_parent").click(function(){
	window.location.href="replyToParent.php";
});

$("#fnd_teacher").click(function(){
	window.location.href="thinkphp/?m=Search&c=Teacher&a=read";
});
</script>
</body>
</html>