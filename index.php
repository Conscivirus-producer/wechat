<?php
require_once("config.php");
/**
  * wechat php test
  */
//define your token
define("TOKEN", "woijodsj23232jdofijweo323ioj");
$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();
$wechatObj->setAppid($appid, $secret);
$wechatObj->responseMsg();

class wechatCallbackapiTest
{
	private $appid;
	private $secret;
	
	public function setAppid($appid, $secret){
		$this->appid = $appid;
		$this->secret = $secret;
	}
	
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $msgType = $postObj->MsgType;
                $event = $postObj->Event;
                $eventKey = $postObj->EventKey;
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
				if($msgType == "event"){
					if($event == "subscribe"){
						if($eventKey == ""){
							$eventKey = "noscan";
						}
						//1,获取access_token
						$access_token_get_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appid."&secret=".$this->secret;
    					$access_token_json = file_get_contents($access_token_get_url); 
    					$json_obj = json_decode($access_token_json,true);
    					$access_token = $json_obj["access_token"];
    					//2,再获取基本信息
    					$basic_information_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$fromUsername."&lang=zh_CN";
    					$basic_information_json = file_get_contents($basic_information_url);
    					$json_obj = json_decode($basic_information_json,true); 
    					$nickname = $json_obj["nickname"];
    					//3,更新数据库信息
    					$host = "localhost";
						$user = "root";
						$password = "2324150778t";
						$database = "wechat_schema";
						$conn = new mysqli($host, $user, $password, $database);
						$queryString = "insert into T_scan_information(`openId`, `nickname`, `qrcodeId`, `createdDt`) values('$fromUsername','$nickname','$eventKey', sysdate())";
						$conn->query("SET NAMES UTF8");
						$conn->query($queryString);
						//4,回复信息
						$msgType = "text";
                		//$contentStr = "欢迎关注我教你学，在这里我们可以帮您找到任何你想学的优质辅导和兴趣课程。您可以通过点击下方“免费试听”按钮来找到最合适您的老师。如果您有一技之长想要教你所学，可以回复1并填写申请表格进行注册。如有任何疑问，可以给我们留言，我们会尽快与您联系。";
	                	$contentStr = "欢迎关注我教你学，您可以在这里选择任何您想要学的优质辅导以及兴趣培养课程。\n\n".
	                		"家长点击<a href='https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx9855e946fbde03ac&redirect_uri=http://www.ilearnnn.com/findTeacher.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect'>免费试听</a>选择合适的家教。\n".
	                		"深大学生点击<a href='https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx9855e946fbde03ac&redirect_uri=http://www.ilearnnn.com/manage.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect'>老师注册</a>成为老师。\n".
	                		"投票点<a href='http://mp.weixin.qq.com/s?__biz=MzIwNDAwMTEzMw==&mid=208696219&idx=1&sn=0c0b8a2c5ca670c7a26ce3300d5e0c15&scene=4#wechat_redirect'>这里</a>。\n\n".
	                		"如有任何疑问，直接发送信息至本平台，我们会立刻与您联系。";
                		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                		echo $resultStr;
					}
				}else{            
					if(!empty( $keyword ))
                	{
                		if($keyword == "1"){
	                		$imageTpl = "<xml>
										<ToUserName><![CDATA[%s]]></ToUserName>
										<FromUserName><![CDATA[%s]]></FromUserName>
										<CreateTime>%s</CreateTime>
										<MsgType><![CDATA[news]]></MsgType>
										<ArticleCount>1</ArticleCount>
										<Articles>
										<item>
										<Title><![CDATA[%s]]></Title>
										<Description><![CDATA[]]></Description>
										<PicUrl><![CDATA[%s]]></PicUrl>
										<Url><![CDATA[%s]]></Url>
										</item>
										</Articles>
										</xml> ";
							$title = "填写表格成为老师";//标题
							$PicUrl = "http://www.ilearnnn.com/image/logo.jpg";//图片链接
							$Url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->appid."&redirect_uri=http://www.ilearnnn.com/manage.php&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";//打开后的图片链接
							$time = time();
							$resultStr = sprintf($imageTpl, $fromUsername, $toUsername, $time, $title, $PicUrl,$Url);
							echo $resultStr;
                		} else if($keyword == "同意"){
	              			$msgType = "text";
	                		$contentStr = '谢谢回复，请留下您的手机号，我们的老师会通过短信或电话与您联系。';
	    					$host = "localhost";
							$user = "root";
							$password = "2324150778t";
							$database = "wechat_schema";
							$conn = new mysqli($host, $user, $password, $database);
							$conn->query("SET NAMES UTF8");
							$conn->query($queryString);
							$queryString = "UPDATE `T_transaction` SET `status`='3', updatedDt = sysdate() where parentOpenid = '$fromUsername' and `status`='2'";
							$conn->query($queryString);
	                		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
	                		echo $resultStr;
						} else if($keyword == "报名"){
	              			$msgType = "text";
	                		$contentStr = '感谢您的报名，请留下您的手机号，我们的客服人员会及时通知您活动最新的情况。';
	                		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
	                		echo $resultStr;
						} else if(strpos($keyword,'投') != false && strpos($keyword,'票') != false && strpos($keyword,'号') != false && strpos($keyword,'No') != false){
							$msgType = "text";
                			//$contentStr = "欢迎关注我教你学，在这里我们可以帮您找到任何你想学的优质辅导和兴趣课程。您可以通过点击下方“免费试听”按钮来找到最合适您的老师。如果您有一技之长想要教你所学，可以回复1并填写申请表格进行注册。如有任何疑问，可以给我们留言，我们会尽快与您联系。";
	                		$contentStr = "投票点<a href='http://mp.weixin.qq.com/s?__biz=MzIwNDAwMTEzMw==&mid=208696219&idx=1&sn=0c0b8a2c5ca670c7a26ce3300d5e0c15&scene=4#wechat_redirect'>这里</a>。";
                			$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                			echo $resultStr;
						}
                	}else{
                		echo "Input something...";
                	}
				}
        }else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>