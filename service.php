<?php
	require_once("config.php");
	require_once("processUtil.php");
	$codeParser = new CodeParser();
	$conn = new mysqli($host, $user, $password, $database);
	if($_GET&&$_GET["typeCode"]){
		$typeCode = trim($_GET["typeCode"]);
		$query = "set names utf8";
		$result = $conn->query($query);
		$query = "SELECT DISTINCT `code`,`name` FROM `T_offers` WHERE `typeCode`='$typeCode' and `status`='R' and teacherOpenId in (select openId from T_teacher where teacherStatus = 'R')";
		$result = $conn->query($query);
		$jsonArray = array(
			'name' => array(),
			'code' => array()
		);
		while($row = $result->fetch_assoc()){
			$code = $row["code"];
			$name = $row["name"];
			array_push($jsonArray["name"],$name);
			array_push($jsonArray["code"],$code);
		}
		echo json_encode($jsonArray);
	}
	
	if($_GET&&$_GET["requestMethod"]){
		$requestMethod = trim($_GET["requestMethod"]);
		if($requestMethod == "matchTeacher"){
			$childId = trim($_GET["childId"]);
			$interest = trim($_GET["interest"]);
			$subject = trim($_GET["subject"]);
			$choice = trim($_GET["choice"]);
			
			$query = "set names utf8";
			$result = $conn->query($query);
			$query = "select * from T_teacher";
			if($choice == "contentsub"){
				$query = $query." where openId in (select teacherOpenId from T_offers where code = '$subject')";
			}else if($choice == "contentinte"){
				$query = $query." where openId in (select teacherOpenId from T_offers where code = '$interest')";
			}else{
				$query = $query." where openId in (select teacherOpenId from T_offers where code = '$interest') and openId in (select teacherOpenId from T_offers where code = '$subject')";
			}
			
			$query = $query." and teacherStatus = 'R' order by rating DESC limit 3";
			
			$result = $conn->query($query);
			//{"teacherOpenId":"02","name":"", "gender":"", "major":"","description":"", "":"", "rating":0, "imageUrl":"", "mobile":""}
			$jsonArray = array(
				'teacherOpenId' => array(),
				'major' => array(),
				'name' => array(),
				'gender' => array(),
				'mobile' => array(),
				'description' => array(),
				'rating' => array(),
				'imageUrl' => array(),
				'childId' => array(),
			);
			while($row = $result->fetch_assoc()){
				array_push($jsonArray["teacherOpenId"],$row["openId"]);
				array_push($jsonArray["major"],$row["major"]);
				array_push($jsonArray["name"],$row["name"]);
				array_push($jsonArray["gender"],$row["gender"]);
				array_push($jsonArray["mobile"],$row["mobile"]);
				array_push($jsonArray["description"],$row["description"]);
				array_push($jsonArray["rating"],$row["rating"]);
				array_push($jsonArray["imageUrl"],$row["imageUrl"]);
				array_push($jsonArray["childId"],$childId);
			}
			echo json_encode($jsonArray);
		}else if($requestMethod == "insertParentAndChild"){
			$childId = insertParentAndChild($conn, $appid, $secret);
			insertTransaction($conn, $childId);
		}else if($requestMethod == "teacherDetails"){
			getTeacherDetails($conn);
		}else if($requestMethod == "updateParentMobile"){
			updateParentMobile($conn);
		}else if($requestMethod == "myRecord"){
			getMyRecord($conn);	
		}else if($requestMethod == "cancelTransaction"){
			cancelTransaction($conn);
		}else if($requestMethod == "parseCodeForDisplay"){
			parseCodeForDisplay($conn);
		}
	}

	function parseCodeForDisplay($conn){
		global $codeParser;
		$interest = trim($_GET["interest"]);
		$grade = trim($_GET["grade"]);
		$subject = trim($_GET["subject"]);
		$teacherGender = trim($_GET["teacherGender"]);
		$price = trim($_GET["price"]);
		$address = trim($_GET["address"]);
		$resultArray = array(
			'interest' => $codeParser->getInterestName($interest, $conn), 
			'grade' => $codeParser->getGradeName($grade), 
			'subject' => $codeParser->getSubject($subject), 
			'teacherGender' => $codeParser->getExpectedGender($teacherGender), 
			'price' => $codeParser->getExpectedPrice($price), 
			'address' => $codeParser->getExpectedLocation($address));
		echo json_encode($resultArray);
	}

	function getTeacherDetails($conn){
		$teacherOpenId = trim($_GET["teacherOpenId"]);
		$detailArray = array(
			'name' => array(),
			'description' => array(),
		);
		$query = "set names utf8";
		$result = $conn->query($query);
		$query = "SELECT * FROM `T_offers` WHERE teacherOpenId = '$teacherOpenId' and status = 'R' and typeCode != 'SU'";
		$result = $conn->query($query);
		
		while($row = $result->fetch_assoc()){
			array_push($detailArray["name"],$row["name"]);
			array_push($detailArray["description"],$row["description"]);
		}
		
		$query = "SELECT * FROM `T_teacher` WHERE openId = '$teacherOpenId'";
		$result = $conn->query($query);
		$row = $result->fetch_assoc();
		$description = $row["description"];
		$rootArray = array("name"=>$row["name"], 
							"major"=>$row["major"],
							"imageUrl"=>$row["imageUrl"],
							"description"=>$description,
							"extraDescription"=>$row["extraDescription"], 
							"price"=>$row["price"],
							"interests"=>$detailArray);
		
		echo json_encode($rootArray); 
	}

	function insertParentAndChild($conn, $appid, $secret){
		$interest = trim($_GET["interest"]);
		$subject = trim($_GET["subject"]);
		$parentOpenId = trim($_GET["parentOpenId"]);
		
		$childGender = trim($_GET["gender"]);
		$grade = trim($_GET["grade"]);
		$price = trim($_GET["price"]);
		$address = trim($_GET["address"]);
		$teacherGender = trim($_GET["teacherGender"]);
		
		$query = "set names utf8";
		$result = $conn->query($query);
		
		$query = "SELECT * FROM `T_parent` WHERE openId = '$parentOpenId'";
		$result = $conn->query($query);
		$json_obj = getUserDetails($parentOpenId, $appid, $secret);
		if($result->num_rows == 0){
			$query = "INSERT INTO `T_parent`(`openId`,`nickname`, `mobile`, `status`, `createdDt`)".
			 " VALUES ('%s','%s','%s','%s',sysdate())";
			$query = sprintf($query, $parentOpenId,$json_obj["nickname"], "", "");
			$conn->query($query);
		}
		
		$query = "INSERT INTO `T_child`(`parentOpenid`, `gender`, `grade`, `subject`, `interest`,`expected_price`, `expectedTeacherGender`,`expectedLocation`, `createdDt`)".
		" VALUES ('$parentOpenId','$childGender','$grade','$subject','$interest','$price','$teacherGender','$address', sysdate())";
		$result = $conn->query($query);
		return mysqli_insert_id($conn); 
		
	}

	function getUserDetails($openid, $appid, $secret){
		//1,获取access_token
		$access_token_get_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;
		$access_token_json = file_get_contents($access_token_get_url); 
		$json_obj = json_decode($access_token_json,true);
		$access_token = $json_obj["access_token"];
		//2,再获取基本信息
		$basic_information_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
		$basic_information_json = file_get_contents($basic_information_url);
		$json_obj = json_decode($basic_information_json,true); 
		
		return $json_obj;
	}
	
	function updateParentMobile($conn){
		$parentOpenId = trim($_GET["parentOpenId"]);
		$mobile = trim($_GET["mobile"]);
		$query = "UPDATE `T_parent` SET `mobile`='$mobile' WHERE openId = '$parentOpenId'";
		$result = $conn->query($query);
	}
	
	function insertTransaction($conn, $childId){
		$parentOpenId = trim($_GET["parentOpenId"]);
		$query = "INSERT INTO `T_transaction`(`parentOpenid`, `childId`, `createdDt`, `updatedDt`, `status`) VALUES".
		 "('$parentOpenId','$childId',sysdate(),sysdate(),'1')";
		 
		$result = $conn->query($query);
		return mysqli_insert_id($conn);
	}
	
	function cancelTransaction($conn){
		$transactionId = trim($_GET["transactionId"]);
		
		$query = "UPDATE `T_transaction` SET `updatedDt`=sysdate(),`status`='C' WHERE transactionId = '$transactionId'";
		$result = $conn->query($query);
		echo $transactionId;
	}
	
	function getMyRecord($conn){
		$parentOpenId = trim($_GET["parentOpenId"]);
		
		$query = "set names utf8";
		$result = $conn->query($query);
		 
		
		$query = "select T_transaction.transactionId, T_transaction.createdDt, T_transaction.status, T_teacher.* from T_transaction LEFT JOIN ".
			"T_teacher on T_transaction.teacherOpenid = T_teacher.openId where T_transaction.parentOpenid = '$parentOpenId'";
		$result = $conn->query($query);
		$jsonArray = array(
			'transactionId' => array(),
			'createdDt' => array(),
			'status' => array(),
			'teacherOpenId' => array(),
			'major' => array(),
			'name' => array(),
			'gender' => array(),
			'mobile' => array(),
			'description' => array(),
			'rating' => array(),
			'imageUrl' => array(),
			'childId' => array(),
		);
		while($row = $result->fetch_assoc()){
			array_push($jsonArray["transactionId"],$row["transactionId"]);
			array_push($jsonArray["createdDt"],$row["createdDt"]);
			array_push($jsonArray["status"],$row["status"]);
			array_push($jsonArray["teacherOpenId"],$row["openId"]);
			array_push($jsonArray["major"],$row["major"]);
			array_push($jsonArray["name"],$row["name"]);
			array_push($jsonArray["gender"],$row["gender"]);
			array_push($jsonArray["mobile"],$row["mobile"]);
			array_push($jsonArray["description"],$row["description"]);
			array_push($jsonArray["rating"],$row["rating"]);
			array_push($jsonArray["imageUrl"],$row["imageUrl"]);
			array_push($jsonArray["childId"],$childId);
		}
		
		echo json_encode($jsonArray);
	}

	function endWith($haystack, $needle)
	 {   
	      $length = strlen($needle);  
	      if($length == 0)
	      {    
	          return true;  
	      }  
	      return (substr($haystack, -$length) === $needle);
	 }
?>