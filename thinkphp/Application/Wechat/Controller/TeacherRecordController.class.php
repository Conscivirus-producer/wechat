<?php
namespace Wechat\Controller;
use Think\Controller;
use Qiniu\Auth;
use Think\Log;

class TeacherRecordController extends Controller {
    public function _before_myClassList(){
    	//如果不是老师，直接退出
    	if(session('is_teacher') == "0"){
			$this->error('您没有注册成为老师，不能访问该功能');
    	}
    }
	
	public function myClassList(){
		$openId = session('openid');
		$transaction = D("Transaction");
		$map["teacherOpenid"] = array('eq',$openId);
		$data = $transaction->join("T_child ON T_child.childId = T_transaction.childId")
		->where($map)->field("T_transaction.transactionId, T_child.subject,T_child.interest, T_transaction.location, T_transaction.status")->select();
		//for ($i=0;$i < count($data); $i++){
			//echo $data[$i]["openid"];
		//}
		$userOpenId = session('openid');
		$len = count($data);
		for($i = 0; $i < $len ;$i++){
			$data[$i]["status"] = getStatusDescription($data[$i]["status"]);
			$data[$i]["course"] = formatCourse($data[$i]["subject"], $data[$i]["interest"]);
		}
		$this->assign("data",$data);
		$this->display();
	}
	
	public function uploadTeachingRecord(){
		vendor("qiniusdk.autoload");
		$accessKey = 'k7HBysPt-HoUz4dwPT6SZpjyiuTdgmiWQE-7qkJ4';
		$secretKey = 'BuaBzxTxNsNUBSy1ZvFUAfUbj8GommyWbfJ0eQ2R';
		$auth = new Auth($accessKey, $secretKey);
		$bucket = 'wojiaonixue';
		$token = $auth->uploadToken($bucket);
		$assessmentSettings = D("TeachingRecord", "Logic")->getAssessmentSettingsByCourseCode(I('get.courseCode',"A1"));
		$this->assign("token",$token);
		$this->assign("recordId",I('get.recordId',"58"));
		$this->assign("teachingDt",I('get.teachingDt',"2014-07-28"));
		$this->assign("assessmentSettings",$assessmentSettings);
		$this->display();
	}
	
	public function teachingRecord($transactionId){
		$teachingRecords = D("TeachingRecord", "Logic")->getTeachingRecord($transactionId);
		$this->assign("test", json_encode($teachingRecords));
		$this->display();
	}
}