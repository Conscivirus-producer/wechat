<?php
	require_once("config.php");
	header('Access-Control-Allow-Origin:*');
	$conn = new mysqli($host, $user, $password, $database);
	
	function updateTransactionStatus($conn,$transactionId,$status){
		$query = "set names utf8";
		$result = $conn->query($query);
		$query = "update T_transaction set status = '$status' where transactionId = '$transactionId'";
		$result = $conn->query($query);
		$jsonArray = array(
			"status" => "ok"
		);
		echo json_encode($jsonArray);
	}
	
	function updateComment($conn,$transactionId,$comment){
		$query = "set names utf8";
		$result = $conn->query($query);
		$query = "update T_transaction set comment = '$comment' where transactionId = '$transactionId'";
		$result = $conn->query($query);
		$jsonArray = array(
			"status" => "ok"
		);
		echo json_encode($jsonArray);
	}
	
	function findTeacherByMobile($conn,$mobile){
		$query = "set names utf8";
		$result = $conn->query($query);
		$query = "select openId, name, mobile from T_teacher where mobile = '$mobile'";
		$result = $conn->query($query);
		$jsonArray = array();
		if($result->num_rows != 0){
			$row = $result->fetch_assoc();
			$jsonArray["openId"] = $row["openId"];
			$jsonArray["name"] = $row["name"];
			$jsonArray["mobile"] = $row["mobile"];
			$jsonArray["status"] = "ok";
			echo json_encode($jsonArray);
		}else{
			$jsonArray["openId"] = "";
			$jsonArray["name"] = "";
			$jsonArray["mobile"] = "";
			$jsonArray["status"] = "fail";
			echo json_encode($jsonArray);
		}
	}
	
	function updateTeacher($conn,$transactionId,$openId){
		$query = "set names utf8";
		$result = $conn->query($query);
		$query = "update T_transaction set teacherOpenId = '$openId' where transactionId = '$transactionId'";
		$result = $conn->query($query);
		$jsonArray = array(
			"status" => "ok"
		);
		echo json_encode($jsonArray);
	}
	
	function updateTrialTime($conn,$transactionId,$trialTime){
		$query = "set names utf8";
		$result = $conn->query($query);
		$query = "update T_transaction set trialTime = '$trialTime' where transactionId = '$transactionId'";
		$result = $conn->query($query);
		$jsonArray = array(
			"status" => "ok"
		);
		echo json_encode($jsonArray);
	}
	
	function updateFixedTime($conn,$transactionId,$fixedTime){
		$query = "set names utf8";
		$result = $conn->query($query);
		$query = "update T_transaction set fixedTime = '$fixedTime' where transactionId = '$transactionId'";
		$result = $conn->query($query);
		$jsonArray = array(
			"status" => "ok"
		);
		echo json_encode($jsonArray);
	}
	
	function updateFee($conn,$transactionId,$fee){
		$query = "set names utf8";
		$result = $conn->query($query);
		$query = "update T_transaction set fee = '$fee' where transactionId = '$transactionId'";
		$result = $conn->query($query);
		$jsonArray = array(
			"status" => "ok"
		);
		echo json_encode($jsonArray);
	}
	
	function updateLocation($conn,$transactionId,$location){
		$query = "set names utf8";
		$result = $conn->query($query);
		$query = "update T_transaction set location = '$location' where transactionId = '$transactionId'";
		$result = $conn->query($query);
		$jsonArray = array(
			"status" => "ok"
		);
		echo json_encode($jsonArray);
	}
	
	function updateFollower($conn,$transactionId,$follower){
		$query = "set names utf8";
		$result = $conn->query($query);
		$query = "update T_transaction set follower = '$follower' where transactionId = '$transactionId'";
		$result = $conn->query($query);
		$jsonArray = array(
			"status" => "ok"
		);
		echo json_encode($jsonArray);
	}
	
	
	
	
	if($_GET){
		$dataType = trim($_GET["dataType"]);
		if($dataType == "updateTransactionStatus"){
			$transactionId = trim($_GET["transactionId"]);
			$status = trim($_GET["status"]);
			updateTransactionStatus($conn,$transactionId,$status);
		}
		else if($dataType == "updateComment"){
			$transactionId = trim($_GET["transactionId"]);
			$comment = trim($_GET["comment"]);
			updateComment($conn,$transactionId,$comment);
		}
		else if($dataType == "findTeacherByMobile"){
			$mobile = trim($_GET["mobile"]);
			findTeacherByMobile($conn,$mobile);
		}
		else if($dataType == "updateTeacher"){
			$transactionId = trim($_GET["transactionId"]);
			$openId = trim($_GET["openId"]);
			updateTeacher($conn,$transactionId,$openId);
		}
		else if($dataType == "updateTrialTime"){
			$transactionId = trim($_GET["transactionId"]);
			$trialTime = trim($_GET["trialTime"]);
			updateTrialTime($conn,$transactionId,$trialTime);
		}
		else if($dataType == "updateFixedTime"){
			$transactionId = trim($_GET["transactionId"]);
			$fixedTime = trim($_GET["fixedTime"]);
			updateFixedTime($conn,$transactionId,$fixedTime);
		}
		else if($dataType == "updateFee"){
			$transactionId = trim($_GET["transactionId"]);
			$fee = trim($_GET["fee"]);
			updateFee($conn,$transactionId,$fee);
		}
		else if($dataType == "updateLocation"){
			$transactionId = trim($_GET["transactionId"]);
			$location = trim($_GET["location"]);
			updateLocation($conn,$transactionId,$location);
		}
		else if($dataType == "updateFollower"){
			$transactionId = trim($_GET["transactionId"]);
			$follower = trim($_GET["follower"]);
			updateFollower($conn,$transactionId,$follower);
		}
	}
?>















