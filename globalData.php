<?php
	class GlobalData{
		private $mysqlHost = "localhost";
		private $myqlUsername = "root";
		private $mysqlPassword = "2324150778t";
		private $mysqlDatabase = "wechat_schema";
		private $rootUrl = "localhost";
		private $wechatAppId = "wx9855e946fbde03ac";
		private $wechatAppSecret = "28e4b6e745a58b2999afee567478b105";
		public function getMysqlHost(){
			return $this->mysqlHost;
		}
		public function getMysqlUsername(){
			return $this->myqlUsername;
		}
		public function getMysqlPassword(){
			return $this->mysqlPassword;
		}
		public function getMysqlDatabase(){
			return $this->mysqlDatabase;
		}
		public function getRootUrl(){
			return $this->rootUrl;
		}
		public function getWechatAppId(){
			return $this->wechatAppId;
		}
		public function getWechatAppSecret(){
			return $this->wechatAppSecret;
		}
	}
?>