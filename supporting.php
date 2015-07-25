<?php
	header('Access-Control-Allow-Origin:*');
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
		}else if($requestMethod == "replyToUser"){
			replyToUser($conn, $appid, $secret);
		}else if($requestMethod == "updateNickName"){
			updateNickNames($conn, $appid, $secret);
		}
	}
	
	function encode_json($str) {  
	    return urldecode(json_encode(url_encode($str)));      
	}  
	  
	/** 
	 *  
	 */  
	function url_encode($str) {  
	    if(is_array($str)) {  
	        foreach($str as $key=>$value) {  
	            $str[urlencode($key)] = url_encode($value);  
	        }  
	    } else {  
	        $str = urlencode($str);  
	    }  
	      
	    return $str;  
	} 
	
	function updateNickNames($conn, $appid, $secret){
		$query = "set names utf8";
		$result = $conn->query($query);
		$query = "SELECT openId FROM `T_parent` where nickname = '' and status != 'INACTIVE' limit 100"; 
		$result = $conn->query($query);
		
		while($row = $result->fetch_assoc()){
			$openid = $row["openId"];
			$json_obj = getUserDetails($openid, $appid, $secret);
			if($json_obj["subscribe"] == "0"){
				$query = "UPDATE `T_parent` SET `status`='INACTIVE' where openId = '$openid'";
			}else{
				$nickname = $json_obj["nickname"];
				$query = "UPDATE `T_parent` SET `nickname`='$nickname' where openId = '$openid'";
			}
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
	
	function replyToUser($conn, $appid, $secret){
		$openid = trim($_GET["openid"]);
		$content = trim($_GET["content"]);
		
		$query = "UPDATE `T_transaction` SET `status`='2', updatedDt = sysdate() where parentOpenid = '$openid' and `status`='1'";
		$result = $conn->query($query);
		
		$access_token_get_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;
		$access_token_json = file_get_contents($access_token_get_url); 
		$json_obj = json_decode($access_token_json,true);
		$access_token = $json_obj["access_token"];
		$text = array("content"=>$content);
		$array = array("touser"=>$openid, 
							"msgtype"=>"text",
							"text"=>$text);
		$body = encode_json($array);
		$content_length = strlen($body);
		$opts = array('http' =>
		  array(
		    'method'  => 'POST',
		    'header'  => "Content-Type: text/xml\r\n".
		      "Content-length: $content_length\r\n",
		      "Accept-Charset: ISO-8859-1,utf-8",
		    'content' => $body,
		    'timeout' => 60
		  )
		);
		
		$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
		$context  = stream_context_create($opts);
		$result = file_get_contents($url, false, $context, -1, 40000);
		echo $result;
	}

	function getTransactionsByStatus($conn){
		global $codeParser;
		$globalData = new GlobalData();
		$status = trim($_GET["status"]);
		$startDate = trim($_GET["startDate"]);
		$endDate = trim($_GET["endDate"]);
		$follower = trim($_GET["follower"]);
		$query = "set names utf8";
		$result = $conn->query($query);
		
		$query = "SELECT T_transaction.transactionId,T_transaction.createdDt,T_transaction.follower,T_transaction.parentOpenid, ".
			"T_parent.nickname, T_parent.mobile,T_child.subject, T_child.grade, T_child.interest, T_child.expected_price, ".
			"T_child.expectedTeacherGender, T_child.expectedLocation, T_transaction.teacherOpenid, ".
			"T_teacher.name as teacherName, T_teacher.mobile as teacherMobile, T_transaction.trialTime, T_transaction.fixedTime, ".
			"T_transaction.fee, T_transaction.location, T_transaction.status,T_transaction.comment FROM T_parent,  T_child, `T_transaction` ".
			"LEFT JOIN T_teacher ON T_transaction.teacherOpenid = T_teacher.openId WHERE T_transaction.parentOpenid = T_parent.openId  and ".
			"T_transaction.childId = T_child.childId";
		
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
		$arr_string = join(',', $globalData->getWhiteListArray());
		$query = $query." and T_transaction.parentOpenid not in ('$arr_string')";
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
			$highestGrade = trim($_POST["highestGrade"]);
			
			//1，存入老师的基本信息，T_teacher，默认wechatAccount为空，extraDescription为空，rating为1，teacherStatus为R
			$query = "set names utf8";
			$result = $conn->query($query);
			$query = "insert into T_teacher values('$openid','','$school','$major','$studentNumber','$name','$sex','$phone','$desc','',sysdate(),'1','$imgUrl','$price','$highestGrade','$location','I')";                       
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