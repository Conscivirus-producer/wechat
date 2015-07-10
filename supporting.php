<?php
	require_once("config.php");
	header('Access-Control-Allow-Origin:*');
	$host = "localhost";
	$user = "root";
	$password = "2324150778t";
	$password = "123456";
	$database = "wechat_schema";
	$conn = new mysqli($host, $user, $password, $database);
	
	if($_GET&&$_GET["requestMethod"]){
		$requestMethod = trim($_GET["requestMethod"]);
		if($requestMethod == "getTransactions"){
			echo getTransactions($conn);
		}else if($requestMethod == "myRecord"){
			getMyRecord($conn);	
		}else if($requestMethod == "replyToUser"){
			replyToUser($conn);
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
	
	function replyToUser($conn){
		$openid = trim($_GET["openid"]);
		$content = trim($_GET["content"]);
		
		$query = "UPDATE `T_transaction` SET `status`='2', updatedDt = sysdate() where parentOpenid = '$openid' and `status`='1'";
		$result = $conn->query($query);
		
		$access_token_get_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx9855e946fbde03ac&secret=a185dd60de19330b8eaaadf4d8ae00ef";
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
	
	function getTransactions($conn){
		$startDate = trim($_GET["startDate"]);
		$endDate = trim($_GET["endDate"]);
		$query = "set names utf8";
		$result = $conn->query($query);
		
		$query = "SELECT T_parent.nickname, T_parent.mobile, T_child.*, T_transaction.status, T_transaction.comment FROM `T_transaction`, T_child, T_parent "
		."WHERE T_transaction.createdDt > '$startDate' and T_transaction.createdDt <'$endDate' and T_transaction.childId = T_child.childId ".
		"and T_transaction.status != 'C' and T_child.parentOpenid = T_parent.openId ORDER BY `T_child`.`createdDt` DESC";
		
		$result = $conn->query($query);
		$jsonArray = array(
			'parentOpenId' => array(),
			'nickname' => array(),
			'mobile' => array(),
			'grade' => array(),
			'subject' => array(),
			'interest' => array(),
			'expected_price' => array(),
			'expectedTeacherGender' => array(),
			'createdDt' => array(),
			'status' => array(),
			'comment' => array()
		);
		while($row = $result->fetch_assoc()){
			array_push($jsonArray["parentOpenId"],$row["parentOpenid"]);
			array_push($jsonArray["nickname"],$row["nickname"]);
			array_push($jsonArray["mobile"],$row["mobile"]);
			array_push($jsonArray["grade"],$row["grade"]);
			array_push($jsonArray["subject"],getSubject($row["subject"]));
			array_push($jsonArray["interest"],getInterestName($row["interest"], $conn));
			array_push($jsonArray["expected_price"],getExpectedPrice($row["expected_price"]));
			array_push($jsonArray["expectedTeacherGender"],getExpectedGender($row["expectedTeacherGender"]));
			array_push($jsonArray["createdDt"],$row["createdDt"]);
			array_push($jsonArray["status"],getStatusDescription($row["status"]));
			array_push($jsonArray["comment"],$row["comment"]);
		}
		
		echo json_encode($jsonArray);
	}

	function getStatusDescription($status){
		if($status == "1"){
			return "1.订单已提交";
		}else if($status == "2"){
			return 	"2.已回复家长";
		}else if($status == "3"){
			return 	"3.家长已同意";
		}else if($status == "4"){
			return 	"4.学生已联系家长";
		}else if($status == "5"){
			return 	"5.已确定首次试教时间和地点";
		}else if($status == "6"){
			return 	"6.已上门试教";
		}else if($status == "7"){
			return 	"7.确定具体的交易细节";
		}
	}
	
	function getUserDetails($openid){
		//1,获取access_token
		$access_token_get_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx9855e946fbde03ac&secret=a185dd60de19330b8eaaadf4d8ae00ef";
		$access_token_json = file_get_contents($access_token_get_url); 
		$json_obj = json_decode($access_token_json,true);
		$access_token = $json_obj["access_token"];
		//2,再获取基本信息
		$basic_information_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
		$basic_information_json = file_get_contents($basic_information_url);
		$json_obj = json_decode($basic_information_json,true); 
		
		return $json_obj;
	}

	function getExpectedGender($gender){
		if($gender == "gender1"){
			return "男";
		} else if($gender == "gender1"){
			return "女";	
		} else{
			return "男女不限";
		}
	}
	
	function getInterestName($interest, $conn){
		$query = "SELECT * FROM `T_offers` WHERE code = '$interest' LIMIT 1";
		$result = $conn->query($query);
		if($result->num_rows == 0){
			return "";
		}
		$row = $result->fetch_assoc();
		return $row["name"];
	}
	
	function getExpectedPrice($price){
		if($price == "price1"){
			return "50 ~ 100";
		}else if($price == "price2"){
			return "100 ~ 150";
		}else if($price == "price3"){
			return "150以上";
		}else{
			return "";
		}
	}

	function getSubject($subject){
		if($subject == "SU1"){
			return "数学";
		}else if($subject == "SU2"){
			return "英语";
		}else if($subject == "SU3"){
			return "语文";
		}else{
			return "";
		}
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
?>