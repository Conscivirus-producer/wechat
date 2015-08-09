<?php
	session_start();
	if(!(isset($_SESSION['wojiaonixue_internal_login_status']) AND $_SESSION['wojiaonixue_internal_login_status'] == 'active')){
	    header("Location:login.html");
	    exit();
	}
	header('Access-Control-Allow-Origin:*');
	require_once("config.php");
	require_once("processUtil.php");
	require_once("globalData.php");
	
	$codeParser = new CodeParser();
	$conn = new mysqli($host, $user, $password, $database);
	
	if($_GET&&$_GET["requestMethod"]){
		$requestMethod = trim($_GET["requestMethod"]);
		if($requestMethod == "replyImageAndTextInformation"){
			replyImageAndTextInformation($appid, $secret, $rootUrl);
		}else if($requestMethod == "replyTextToUser"){
			replyTextToUser($appid, $secret);
		}
	}
	
	function replyImageAndTextInformation($appid, $secret, $rootUrl){
		global $conn;
		$openid = trim($_GET["openid"]);
		$teacherOpenId = trim($_GET["teacherOpenId"]);
		$content = trim($_GET["content"]);
		$query = "set names utf8";
		$result = $conn->query($query);
		$query = "SELECT * FROM `T_teacher` WHERE openId = '$teacherOpenId' and teacherStatus = 'R' limit 1";
		$result = $conn->query($query);
		if($result->num_rows == 0){
			$resultMsg = array(
				'errcode' => 'NOTEXIST',
				'errmsg' => '老师不存在');
			echo json_encode($resultMsg);
			return;
		}
			
		$row = $result->fetch_assoc();
		$teacherMajor = $row["major"];
		$teacherName = $row["name"];
		
		$query = "SELECT * FROM `T_transaction` WHERE parentOpenid = '$openid' and status != 'C' limit 1";
		$result = $conn->query($query);
		$row = $result->fetch_assoc();
		$transactionId = $row["transactionId"];
		
		$access_token_get_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;
		$access_token_json = file_get_contents($access_token_get_url); 
		$json_obj = json_decode($access_token_json,true);
		$access_token = $json_obj["access_token"];
		$obj = array("title"=>"为您找到的老师信息如下",
					  "description"=>"谢谢您的选择，为您推荐的老师是深圳大学".$teacherMajor."的".$teacherName."，点击该消息查看学生详细信息。",
					//"url"=>"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx9855e946fbde03ac&redirect_uri=http://www.ilearnnn.com/findTeacher.php&response_type=code&scope=snsapi_userinfo&state=1&teacherOpenId=".$teacherOpenId."&transactionId=".$transactionId."#wechat_redirect",
					"url"=>"http://".$rootUrl."/findTeacher.php?teacherOpenId=".$teacherOpenId."&transactionId=".$transactionId,
					"picurl"=>"http://7xk9ts.com2.z0.glb.qiniucdn.com/common.jpg");
		$array = array("touser"=>$openid, 
							"msgtype"=>"news",
							"news"=>array("articles"=>array($obj)));
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
	
	function replyTextToUser($appid, $secret){
		global $conn;
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