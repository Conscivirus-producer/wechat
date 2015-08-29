<?php
namespace Wechat\Behaviors;
class CheckLoginBehavior extends \Think\Behavior{
    //行为执行入口
    public function run(&$param){
		//echo "test111".$param;
		//throw new Exception("Error Processing Request", 1);
		//echo C("APP_ID");
		//exit("No openid provided.");
		$openid = "";
		if (isset($_GET['code'])){
		    $code = $_GET['code'];
		    $access_token_get_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".C("APP_ID")."&secret=".C("APP_SECRET")."&code=".$code."&grant_type=authorization_code";
		    $access_token_json = file_get_contents($access_token_get_url); 
		    $json_obj = json_decode($access_token_json,true);
		    $openid = $json_obj["openid"];
			
		}else{
			//need to be modified to show hint and qrcode image
		    //echo "NO CODE";
		    $openid = "obS35vk9Hqwl4WZXsosjxm_hckKQ";
			redirect("/thinkphp/ErrorHandling/ErrorHandling/error/message/非法访问");
		}
		session('openid', $openid);
		//检查当前用户是否是老师并且存储到session
		$result = D("Teacher", "Logic")->isValidateTeacher($openid);
		session('is_teacher', $result);
    }
}