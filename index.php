<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "ajskdjnclVXOIskdu293ueLJwij");
$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();
$wechatObj->responseMsg();

class wechatCallbackapiTest
{
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
						$access_token_get_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx9855e946fbde03ac&secret=a185dd60de19330b8eaaadf4d8ae00ef";
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
						$queryString = "insert into T_scan_information values('$fromUsername','$nickname','$eventKey', sysdate())";
						$conn->query("SET NAMES UTF8");
						$conn->query($queryString);
						//4,回复信息
						$msgType = "text";
                		//$contentStr = "欢迎关注我教你学，在这里我们可以帮您找到任何你想学的优质辅导和兴趣课程。您可以通过点击下方“免费试听”按钮来找到最合适您的老师。如果您有一技之长想要教你所学，可以回复1并填写申请表格进行注册。如有任何疑问，可以给我们留言，我们会尽快与您联系。";
	                	$contentStr = '欢迎关注我教你学。我们为您安排了一次免费上门试教，您可以点击公众号下方"免费试听"，选择适合您小孩的教学内容;或者直接回复学科或兴趣，如“数学”，并留下您的手机号。我们将会在24小时内帮你安排老师试教。
客服电话: 400-686-4616';
                		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                		echo $resultStr;
					}
				}else{            
					if(!empty( $keyword ))
                	{
                		if($keyword == "1"){
	              			/*$msgType = "text";
	                		$contentStr = '<a href="www.hehe.life/manage.php">申请表格</a>';
	                		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
	                		echo $resultStr;*/
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
							$PicUrl = "http://www.hehe.life/image/logo.jpg";//图片链接
							$Url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx9855e946fbde03ac&redirect_uri=http://www.hehe.life/manage.php&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";//打开后的图片链接
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
						} else if($keyword == "sdjwoiewe"){
	              			$msgType = "text";
	                		$contentStr = '欢迎关注我教你学。我们为您安排了一次免费上门试教，您可以点击公众号下方"免费试听"，选择适合您小孩的教学内容;或者直接回复学科或兴趣，如“数学”，并留下您的手机号。我们将会在24小时内帮你安排老师试教。
客服电话: 400-686-4616';
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