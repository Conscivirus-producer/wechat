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
			"name" => array(),
			"code" => array(),
			"typeCode" => array()
		);
		$jsonArray["certificate"] = array(
			"desc" => array(),
			"imgUrl" => array()
		);
		//2，获取可教科目
		$query = "set names utf8";
		$result = $conn->query($query);
		$query = "select name,code,typeCode from T_offers where teacherOpenId = '$openId' and status != 'D'";
		$result = $conn->query($query);
		while($row = $result->fetch_assoc()){
			array_push($jsonArray["options"]["name"], $row["name"]);
			array_push($jsonArray["options"]["code"], $row["code"]);
			array_push($jsonArray["options"]["typeCode"], $row["typeCode"]);
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
	
	function updateCertificateDesc($updateId,$updateVal,$conn){
		$query = "set names utf8";
		$result = $conn->query($query);
		$query = "update T_teacher_certifications set description = '$updateVal' where imageUrl = '$updateId'";
		$result = $conn->query($query);
		
		$jsonArray = array(
			"status" => "ok"
		);
		
		return $jsonArray;
	}
	
	function deleteCertificate($deleteId,$conn){
		$query = "set names utf8";
		$result = $conn->query($query);
		$query = "delete from T_teacher_certifications where imageUrl = '$deleteId'";
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
		else if($dataType == "updateCertificateDesc"){
			$updateId = trim($_POST["updateId"]);
			$updateVal = trim($_POST["updateVal"]);
			echo json_encode(updateCertificateDesc($updateId,$updateVal,$conn));
		}
		else if($dataType == "deleteCertificate"){
			$deleteId = trim($_POST["deleteId"]);
			echo json_encode(deleteCertificate($deleteId,$conn));
		}
		else if($dataType == "updateTeacherInformation"){
			$openid = trim($_POST["openid"]);
			$name = trim($_POST["name"]);
			$sex = trim($_POST["sex"]);
			$school = trim($_POST["school"]);
			$major = trim($_POST["major"]);
			$studentNumber = trim($_POST["studentNumber"]);
			$phone = trim($_POST["phone"]);
			$desc = trim($_POST["desc"]);
			$options = $_POST["options"];
			$otheroptions = trim($_POST["otheroptions"]);
			$price = trim($_POST["price"]);
			$location = $_POST["location"];
			$location = implode(",",$location);
			$highestGrade = trim($_POST["highestGrade"]);
			
			//1，更新个人基本信息
			$query = "set names utf8";
			$result = $conn->query($query);
			$query = "update T_teacher set name='$name', gender='$sex', faculty='$school', major='$major', studentNumber='$studentNumber', mobile='$phone', description='$desc', price='$price', address='$location', highestGrade='$highestGrade' where openId='$openid'";
			$result = $conn->query($query);
			
			//2，删除原有offer
			$query = "delete from T_offers where teacherOpenId='$openid'";
			$result = $conn->query($query);
			
			//3，存入老师能教的科目
			$length = count($options);
			$query = "set names utf8";
			$result = $conn->query($query);
			$query = "insert into T_offers(teacherOpenId,name,code,description,typeCode,typeName,status) values ";
			for($i = 0;$i < $length;$i++){
				$code = $options[$i];
				$codeToName = array(
					"A" => "舞蹈与音乐",
					"B" => "体育运动",
					"C" => "书法与美术",
					"D" => "编程软件应用与棋类",
					"E" => "演讲与播音主持",
					"F" => "人文科学与小语种"
				);
				
				$typeCode = "";
				$typeName = "";
				$status = "R";
				$localName = "";
				if(stripos($code,"SU") !== false){
					$typeCode = "SU";
					$typeName = "科目";
					if($code == "SU1"){
						$localName = "语文";
					}else if($code == "SU2"){
						$localName = "数学";
					}else if($code == "SU3"){
						$localName = "英语";
					}else{
						$localName = "化学";
					}
				}else{
					$queryString = "set names utf8";
					$result = $conn->query($queryString);
					$queryString = "select name from T_offers where code = '$code' limit 1";
					$result = $conn->query($queryString);
					$row = $result->fetch_assoc();
					$localName = $row["name"];
					$typeCode = substr($code,0,1);
					$typeName = $codeToName[$typeCode];
				}
				if($i != 0){
					$query = $query.",";
				}
				$query = $query."('$openid','$localName','$code','','$typeCode','$typeName','R')";
			}
			
			
			//4，存入其它的能教得科目，项目
			if($otheroptions != ""){
				$otheroptions = explode(" ",$otheroptions);
				$length = count($otheroptions);
				for($j = 0;$j < $length;$j++){
					$localName = $otheroptions[$j];
					$query = $query.",('$openid','$localName','','','','','R')";
				}
			}
			
			$result = $conn->query($query);
			
			$jsonArray = array(
				'status' => "ok",
				'dataType' => "updateTeacherInformation"
			);
			echo json_encode($jsonArray);                            
		}
	}
?>












