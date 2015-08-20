<?php
	class GlobalData{
		private $mysqlHost = "localhost";
		private $myqlUsername = "root";
		private $mysqlPassword = "2324150778t";
		private $mysqlDatabase = "wechat_schema";
		private $rootUrl = "www.ilearnnn.com";
		private $wechatAppId = "wx9855e946fbde03ac";
		private $wechatAppSecret = "28e4b6e745a58b2999afee567478b105";
		private $whiteList= "('obS35vk9Hqwl4WZXsosjxm_hckKQ',
										'obS35vukOJDFCh2RulSiTq6bVFPI',
										'obS35vu4p_zaCQaZXWSRJ2ZeWRXY',
										'obS35vrF0AKDNL7MPB-ldm9feeyU',
										'obS35viUQDwKRmJ0g9TxA7EMTvyM',
										'obS35vi291nUGwvmCEGhlOqRR2fI',
										'obS35vn0ybxTQKrSb9rkBZ50RQ7g',
										'obS35vq4v81OgjWP3ghANvMvIMks',
										'obS35vs6BGFOYo9w9Aq3q1OYNQjU',
										'obS35vnFjutWaW_EkVhIOsYd50Ms',
										'obS35vt_xhCpM3BjVGxWZfL9zRnE',
										'obS35vtZwdmgrpApXCCtGoqoN2wY',
										'obS35vvGE9rO0gIs0SoPwdGXP0dw',
										'obS35vk0ok-8JHZcaMloqre27g2Y',
										'obS35vufAmy_XwRlf6KOEYCtlzGE',
										'',
										'obS35vpbcdKbDmBe1hy0L-nZlq0k')";
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
		public function getWhiteList(){
			return $this->whiteList;
		}
	}
?>