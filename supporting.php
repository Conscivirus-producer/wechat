<?php
	header('Access-Control-Allow-Origin:*');
	session_start();
	if(!(isset($_SESSION['wojiaonixue_internal_login_status']) AND $_SESSION['wojiaonixue_internal_login_status'] == 'active')){
	    header("Location:login.html");
	    exit();
	}
	require_once("config.php");
	require_once("processUtil.php");
	require_once("globalData.php");
	
	$codeParser = new CodeParser();
	$conn = new mysqli($host, $user, $password, $database);
	
	if($_GET&&$_GET["requestMethod"]){
		$requestMethod = trim($_GET["requestMethod"]);
		if($requestMethod == "getTransactions"){
			echo getTransactions($conn);
		}else if($requestMethod == "getTransactionsByStatus"){
			getTransactionsByStatus($conn);	
		}else if($requestMethod == "myRecord"){
			getMyRecord($conn);	
		}else if($requestMethod == "updateFollowStatus"){
			updateFollowStatus($conn, $appid, $secret);
		}else if($requestMethod == "manualCreateTransaction"){
			manualCreateTransaction();
		}
	}
	
	function manualCreateTransaction(){
		global $conn;
		$mobile = trim($_GET["mobile"]);
		$nickname = trim($_GET["nickname"]);
		$grade = trim($_GET["grade"]);
		$subject = trim($_GET["subject"]);
		$interest = trim($_GET["interest"]);
		$address = trim($_GET["address"]);
		$openid = trim($_GET["openid"]);
		$remark = trim($_GET["remark"]);
		if($remark == ''){
			$remark = "家长留下手机号";
		}
		
		$resultArray = array("code"=>"0", "message"=>"");
		
		$query = "set names utf8";
		$result = $conn->query($query);
		
		$query = "SELECT * FROM `T_parent` WHERE openId = '$mobile'";
		$result = $conn->query($query);
		if($result->num_rows > 0){
			$query = "UPDATE `T_child` SET `grade`='$grade',`subject`='$subject',`interest`='$interest',`expectedLocation`='$address' WHERE parentOpenid = '$mobile'";
			$result = $conn->query($query);
			$query = "UPDATE `T_transaction` SET`comment`= '$remark' WHERE parentOpenid = '$mobile'";
			$result = $conn->query($query);
			$resultArray["code"] = "1";
			$resultArray["message"] = "家长记录已存在,记录更新成功";
			echo json_encode($resultArray); 
			return;
		}
		
		$query = "INSERT INTO `T_parent` (`openId`, `nickname`, `mobile`, `status`, `gender`, `imageUrl`, `createdDt`) ".
			"VALUES ('$mobile', '$nickname', '$mobile', '', '', '', sysdate())";
		$result = $conn->query($query);
		
		$query = "INSERT INTO `T_child` (`childId`, `parentOpenid`, `grade`, `subject`, `interest`, `expected_price`, `expectedLocation`, `createdDt`) ".
			"VALUES (NULL, '$mobile', '$grade', '$subject', '$interest', '', '$address', sysdate())";
		$result = $conn->query($query);
		
		$query = "INSERT INTO `T_transaction` (`transactionId`, `parentOpenid`, `childId`, `createdBy`, `createdDt`, `updatedDt`, `status`, `comment`) ".
			"VALUES (NULL, '$mobile', (SELECT childId FROM `T_child` WHERE parentOpenid = '$mobile'), '$openid', sysdate(), sysdate(), '1', '$remark')";
		$result = $conn->query($query);
		
		$resultArray["code"] = "0";
		$resultArray["message"] = "记录保存成功!";
		echo json_encode($resultArray); 
		//echo mysqli_insert_id($conn);
	}
	
	function updateFollowStatus($conn, $appid, $secret){
		$startDate = trim($_GET["startDate"]);
		$endDate = trim($_GET["endDate"]);
		$query = "set names utf8";
		$result = $conn->query($query);
		$query = "SELECT openId FROM `T_scan_information` where createdDt > '$startDate' and createdDt < '$endDate'"; 
		$result = $conn->query($query);
		
		while($row = $result->fetch_assoc()){
			$openid = $row["openId"];
			$json_obj = getUserDetails($openid, $appid, $secret);
			$followed = $json_obj["subscribe"];
			$query = "update `T_scan_information` set followed = '$followed' where openId = '$openid'";
			$conn->query($query);
		}
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
	
	function getTransactionsByStatus($conn){
		global $codeParser;
		$globalData = new GlobalData();
		$status = trim($_GET["status"]);
		$startDate = trim($_GET["startDate"]);
		$endDate = trim($_GET["endDate"]);
		$follower = trim($_GET["follower"]);
		$openid = trim($_GET["openid"]);
		$query = "set names utf8";
		$result = $conn->query($query);
		
		$query = "SELECT T_transaction.transactionId,T_transaction.createdDt,T_transaction.follower,T_transaction.parentOpenid, ".
			"T_parent.nickname, T_parent.mobile,T_child.subject, T_child.grade, T_child.interest, T_child.expected_price, ".
			"T_child.expectedTeacherGender, T_child.expectedLocation, T_transaction.teacherOpenid, ".
			"T_teacher.name as teacherName, T_teacher.mobile as teacherMobile, T_transaction.trialTime, T_transaction.fixedTime, ".
			"T_transaction.fee, T_transaction.location, T_transaction.status,T_transaction.comment FROM T_parent,  T_child, `T_transaction` ".
			"LEFT JOIN T_teacher ON T_transaction.teacherOpenid = T_teacher.openId WHERE T_transaction.parentOpenid = T_parent.openId  and ".
			"T_transaction.childId = T_child.childId";
		
		if($openid != ''){
			$query = $query." and T_transaction.parentOpenid = '$openid'";
		}else {
			if($status == '2'){
				$query = $query." and T_transaction.status = 2 and T_parent.mobile != ''";
			} else {
				$query = $query." and T_transaction.status = '$status'";
			}
			if($startDate != ''){
				$query = $query." and T_transaction.createdDt > '$startDate'";
			} 
			if($endDate != ''){
				$query = $query." and T_transaction.createdDt < '$endDate'";
			}
			
			if($follower != 'All'){
				$query = $query." and T_transaction.follower = '$follower'";
			}
		}
		$whiteList = $globalData->getWhiteList();
		$query = $query." and T_transaction.parentOpenid not in $whiteList";
		$query = $query." order by status, createdDt desc";
		$result = $conn->query($query);
		$jsonArray = array(
			'transactionId' => array(),
			'createdDt' => array(),
			'follower' => array(),
			'parentOpenId' => array(),
			'nickname' => array(),
			'mobile' => array(),
			'grade' => array(),
			'subject' => array(),
			'interest' => array(),
			'expected_price' => array(),
			'expectedTeacherGender' => array(),
			'expectedLocation' => array(),
			'teacherName' => array(),
			'teacherMobile' => array(),
			'trialTime' => array(),
			'fixedTime' => array(),
			'fee' => array(),
			'location' => array(),
			'status' => array(),
			'comment' => array()
		);
		while($row = $result->fetch_assoc()){
			array_push($jsonArray["transactionId"],$row["transactionId"]);
			array_push($jsonArray["createdDt"],$row["createdDt"]);
			array_push($jsonArray["follower"],$row["follower"]);
			array_push($jsonArray["parentOpenId"],$row["parentOpenid"]);
			array_push($jsonArray["nickname"],$row["nickname"]);
			array_push($jsonArray["mobile"],$row["mobile"]);
			array_push($jsonArray["grade"],$row["grade"]);
			array_push($jsonArray["subject"],$codeParser->getSubject($row["subject"]));
			array_push($jsonArray["interest"],$codeParser->getInterestName($row["interest"], $conn));
			array_push($jsonArray["expected_price"],$codeParser->getExpectedPrice($row["expected_price"]));
			array_push($jsonArray["expectedTeacherGender"],$codeParser->getExpectedGender($row["expectedTeacherGender"]));
			array_push($jsonArray["expectedLocation"],$codeParser->getExpectedLocation($row["expectedLocation"]));
			array_push($jsonArray["teacherName"],$codeParser->handleNullValue($row["teacherName"]));
			array_push($jsonArray["teacherMobile"],$codeParser->handleNullValue($row["teacherMobile"]));
			array_push($jsonArray["trialTime"],$row["trialTime"]);
			array_push($jsonArray["fixedTime"],$row["fixedTime"]);
			array_push($jsonArray["fee"],$row["fee"]);
			array_push($jsonArray["location"],$row["location"]);
			array_push($jsonArray["status"],$codeParser->getStatusDescription($row["status"]));
			array_push($jsonArray["comment"],$row["comment"]);
		}
		
		echo json_encode($jsonArray);
	}
	
	function getTransactions($conn){
		global $codeParser;
		$startDate = trim($_GET["startDate"]);
		$endDate = trim($_GET["endDate"]);
		$query = "set names utf8";
		$result = $conn->query($query);
		
		$query = "SELECT T_parent.nickname, T_parent.mobile, T_child.*, T_transaction.transactionId, T_transaction.status, T_transaction.comment FROM `T_transaction`, T_child, T_parent "
		."WHERE T_transaction.createdDt > '$startDate' and T_transaction.createdDt <'$endDate' and T_transaction.childId = T_child.childId ".
		"and T_transaction.status != 'C' and T_child.parentOpenid = T_parent.openId ORDER BY `T_child`.`createdDt` DESC";
		
		$result = $conn->query($query);
		$jsonArray = array(
			'transactionId' => array(),
			'parentOpenId' => array(),
			'nickname' => array(),
			'mobile' => array(),
			'grade' => array(),
			'subject' => array(),
			'interest' => array(),
			'expected_price' => array(),
			'expectedTeacherGender' => array(),
			'expectedLocation' => array(),
			'createdDt' => array(),
			'status' => array(),
			'comment' => array()
		);
		while($row = $result->fetch_assoc()){
			array_push($jsonArray["transactionId"],$row["transactionId"]);
			array_push($jsonArray["parentOpenId"],$row["parentOpenid"]);
			array_push($jsonArray["nickname"],$row["nickname"]);
			array_push($jsonArray["mobile"],$row["mobile"]);
			array_push($jsonArray["grade"],$row["grade"]);
			array_push($jsonArray["subject"], $codeParser->getSubject($row["subject"]));
			array_push($jsonArray["interest"],$codeParser->getInterestName($row["interest"], $conn));
			array_push($jsonArray["expected_price"],$codeParser->getExpectedPrice($row["expected_price"]));
			array_push($jsonArray["expectedTeacherGender"],$codeParser->getExpectedGender($row["expectedTeacherGender"]));
			array_push($jsonArray["expectedLocation"],$codeParser->getExpectedLocation($row["expectedLocation"]));
			array_push($jsonArray["createdDt"],$row["createdDt"]);
			array_push($jsonArray["status"],$codeParser->getStatusDescription($row["status"]));
			array_push($jsonArray["comment"],$row["comment"]);
		}
		
		echo json_encode($jsonArray);
	}

	function getMyRecord($conn){
		$parentOpenId = trim($_GET["parentOpenId"]);
		
		$query = "set names utf8";
		$result = $conn->query($query);
		$query = "select T_transaction.transactionId, T_transaction.createdDt, T_transaction.status, T_teacher.* from T_transaction, T_teacher ".
			"where T_transaction.parentOpenid = '$parentOpenId' and T_transaction.teacherOpenid = T_teacher.openId";
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
	
	//处理POST数据
	if($_POST){
		$dataType = trim($_POST["dataType"]);
		//老师注册
		if($dataType == "teacherRegistration"){
			$openid = trim($_POST["openid"]);
			$name = trim($_POST["name"]);
			$sex = trim($_POST["sex"]);
			$school = trim($_POST["school"]);
			$major = trim($_POST["major"]);
			$studentNumber = trim($_POST["studentNumber"]);
			$phone = trim($_POST["phone"]);
			$desc = trim($_POST["desc"]);
			$imgUrl = trim($_POST["imgUrl"]);
			$options = $_POST["options"];				//array
			$otheroptions = trim($_POST["otheroptions"]);	//" " separated array
			$price = trim($_POST["price"]);
			$location = $_POST["location"];			//array
			$location = implode(",",$location);
			$teachingTime = trim($_POST["teachingTime"]);
			$highestGrade = trim($_POST["highestGrade"]);
			
			//1，存入老师的基本信息，T_teacher，默认wechatAccount为空，extraDescription为空，rating为1，teacherStatus为R
			$query = "set names utf8";
			$result = $conn->query($query);
			$query = "insert into T_teacher values('$openid','','$school','$major','$studentNumber','$name','$sex','$phone','$desc','',sysdate(),'1','$imgUrl','$price','$highestGrade','$location','I','','$teachingTime')";                       
			$result = $conn->query($query);
			
			//2，存入老师所有能教的科目，兴趣
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
			
			
			//3，存入其它的能教得科目，项目
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
				'dataType' => "teacherRegistration"
			);
			echo json_encode($jsonArray);
		}
	}
?>