<?php
	class Yunpian{
		private $apikey;
		private $accountPostUrl = "http://yunpian.com/v1/user/get.json";
		private $templatePostUrl = "http://yunpian.com/v1/tpl/get_default.json";
		private $messagePostUrl = "http://yunpian.com/v1/sms/send.json";
		
		function __construct($param){
			$this->apikey = $param;
		}
		public function getApiKey(){
			return $this->apikey;
		}
		
		public function getAccountPostUrl(){
			return $this->accountPostUrl;
		}
		
		public function getTemplatePostUrl(){
			return $this->templatePostUrl;
		}
		
		public function getMessagePostUrl(){
			return $this->messagePostUrl;
		}
		
		public function do_post_request($url, $data, $optional_headers = null){
    		$params = array(
        		'http' => array(
            		'method' => 'POST',
            		'content' => $data
        		)
    		);
    		if ($optional_headers !== null) {
        		$params['http']['header'] = $optional_headers;
    		}
    		$ctx = stream_context_create($params);
    		$fp = @fopen($url, 'rb', false, $ctx);
    		if (!$fp) {
        		throw new Exception("Problem with $url, $php_errormsg");
    		}
    		$response = @stream_get_contents($fp);
    		if ($response === false) {
        		throw new Exception("Problem reading data from $url, $php_errormsg");
    		}
    		return $response;
		}
		/*
			Tested OK
		*/
		public function getAccountInformation(){
			$url = $this->getAccountPostUrl();
			$data = array(
				"apikey" => ""
			);
			$data["apikey"] = $this->getApiKey();
			$postdata = http_build_query($data);
			return json_decode($this->do_post_request($url,$postdata),true);
		}
		/*
			Tested OK
		*/
		public function modifyAccountInformation($emergencyContact="",$emergencyMobile="",$alarmBalance=""){
			$url = $this->getAccountPostUrl();
			$data = array();
			$data["apikey"] = $this->getApiKey();
			if($emergencyContact != ""){
				$data["emergency_contact"] = $emergencyContact;
			}
			if($emergencyMobile != ""){
				$data["emergency_mobile"] = $emergencyMobile;
			}
			if($alarmBalance != ""){
				$data["alarm_balance"] = $alarmBalance;
			}
			$postdata = http_build_query($data);
			
			$resultArray = json_decode($this->do_post_request($url,$postdata),true);
			
			if($resultArray["msg"] == "OK"){
				return true;
			}else{
				return false;
			}
		}
		/*
			Tested OK
		*/
		public function getDefaultTemplate($tplId = ""){
			$url = $this->getTemplatePostUrl();
			$data = array();
			$data["apikey"] = $this->getApiKey();
			if($tplId != ""){
				$data["tpl_id"] = $tplId;
			}
			$postdata = http_build_query($data);
			return json_decode($this->do_post_request($url,$postdata),true);
		}
		/*
		*0表示需要通知,默认; 
		*1表示仅审核不通过时通知; 
		*2表示仅审核通过时通知; 
		*3表示不需要通知
		*模板内容，必须以带符号【】的签名结尾
		*/
		public function addTemplate($tplContent, $notifyType=0){
			$url = $this->getTemplatePostUrl();
			$data = array();
			$data["apikey"] = $this->getApiKey();
			$data["tpl_content"] = $tplContent;
			if($notifyType != 0){
				$data["notify_type"] = $notifyType;
			}
			$postdata = http_build_query($data);
			$resultArray = json_decode($this->do_post_request($url,$postdata),true);
			if($resultArray["msg"] == "OK"){
				return $resultArray;
			}else{
				return false;
			}
		}
		
		public function getTemplate($tplId = ""){
			$url = $this->getTemplatePostUrl();
			$data = array();
			$data["apikey"] = $this->getApiKey();
			if($tplId != ""){
				$data["tpl_id"] = $tplId;
			}
			$postdata = http_build_query($data);
			return json_decode($this->do_post_request($url,$postdata),true);
		}
		
		public function modifyTemplate($tplId,$tplContent){
			$url = $this->getTemplatePostUrl();
			$data = array();
			$data["apikey"] = $this->getApiKey();
			$data["tpl_id"] = $tplId;
			$data["tpl_content"] = $tplContent;
			$postdata = http_build_query($data);
			$resultArray = json_decode($this->do_post_request($url,$postdata),true);
			if($resultArray["msg"] == "OK"){
				return $resultArray;
			}else{
				return false;
			}
		}
		
		public function deleteTemplate($tplId){
			$url = $this->getTemplatePostUrl();
			$data = array();
			$data["apikey"] = $this->getApiKey();
			$data["tpl_id"] = $tplId;
			$postdata = http_build_query($data);
			$resultArray = json_decode($this->do_post_request($url,$postdata),true);
			if($resultArray["msg"] == "OK"){
				return true;
			}else{
				return false;
			}
		}
		
		public function sendMessage($mobile,$text){
			$url = $this->getMessagePostUrl();
			$data = array();
			$data["apikey"] = $this->getApiKey();
			$data["mobile"] = $mobile;
			$data["text"] = $text;
			$postdata = http_build_query($data);
			$resultArray = json_decode($this->do_post_request($url,$postdata),true);
			if($resultArray["msg"] == "OK"){
				return $resultArray;
			}else{
				return false;
			}
		}
	}
?>




















