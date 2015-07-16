<?php
	require_once("globalData.php");
	$globalData = new GlobalData();
	$conn = new mysqli($globalData->getMysqlHost(), $globalData->getMysqlUsername(), $globalData->getMysqlPassword(), $globalData->getMysqlDatabase());
	function getTeacherInformation($openId,$conn){
		$jsonArray = array();
		//1，获取个人基本信息
		$query = "set names utf8";
		$result = $conn->query($query);
		$query = "select * from T_teacher where openId = '$openId'";
		$result = $conn->query($query);
		$row = $result->fetch_assoc();
		$jsonArray = $row;
		
		$jsonArray["options"] = array(
			"name" => array()
		);
		$jsonArray["certificate"] = array(
			"desc" => array(),
			"imgUrl" => array()
		);
		//2，获取可教科目
		$query = "set names utf8";
		$result = $conn->query($query);
		$query = "select name from T_offers where teacherOpenId = '$openId'";
		$result = $conn->query($query);
		while($row = $result->fetch_assoc()){
			array_push($jsonArray["options"]["name"], $row["name"]);
		}
		//3，获取证书
		$query = "set names utf8";
		$result = $conn->query($query);
		$query = "select description, imageUrl from T_teacher_certifications where teacherOpenId = '$openId'";
		$result = $conn->query($query);
		while($row = $result->fetch_assoc()){
			array_push($jsonArray["certificate"]["desc"], $row["description"]);
			array_push($jsonArray["certificate"]["imgUrl"], $row["imageUrl"]);
		}
		
		return $jsonArray;
	}
	
	function getCertificates($openId,$conn){
		$jsonArray = array(
			"description" => array(),
			"imageUrl" => array()
		);
		
		$query = "set names utf8";
		$result = $conn->query($query);
		$query = "select description, imageUrl from T_teacher_certifications where teacherOpenId = '$openId'";
		$result = $conn->query($query);
		while($row = $result->fetch_assoc()){
			array_push($jsonArray["description"], $row["description"]);
			array_push($jsonArray["imageUrl"], $row["imageUrl"]);
		}
		return $jsonArray;
	}
	
	function getHead($openId,$conn){
		$jsonArray = array(
			"imageUrl" => ""
		);
		
    	if(@fopen("http://7xk9ts.com2.z0.glb.qiniucdn.com/".$openId."_head",'r')) 
		{ 
			$jsonArray["imageUrl"] = "http://7xk9ts.com2.z0.glb.qiniucdn.com/".$openId."_head";
		}
		
		return $jsonArray;
	}
	
	function certificateRecord($openId,$desc,$imgUrl,$conn){
		$query = "set names utf8";
		$result = $conn->query($query);
		$query = "insert into T_teacher_certifications values('$openId','$desc','$imgUrl')";
		$result = $conn->query($query);
		
		$jsonArray = array(
			"status" => "ok"
		);
		
		return $jsonArray;
	}
	
	if($_POST){
		$dataType = trim($_POST["dataType"]);
		if($dataType == "getTeacherInformation"){
			$openid = trim($_POST["openid"]);
			echo json_encode(getTeacherInformation($openid,$conn));
		}
		else if($dataType == "getCertificates"){
			$openid = trim($_POST["openid"]);
			echo json_encode(getCertificates($openid,$conn));
		}
		else if($dataType == "getHead"){
			$openid = trim($_POST["openid"]);
			echo json_encode(getHead($openid,$conn));
		}
		else if($dataType == "certificateRecord"){
			$openid = trim($_POST["teacherOpenId"]);
			$desc = trim($_POST["description"]);
			$imgUrl = trim($_POST["imageUrl"]);
			echo json_encode(certificateRecord($openid,$desc,$imgUrl,$conn));
		}
	}
?>












