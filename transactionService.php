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
	}
?>