<?php
namespace Wechat\Controller;
use Think\Controller;
use Qiniu\Auth;
use Think\Log;

class TeacherRecordController extends Controller {
    public function _before_myClassList(){
    	//如果不是老师，直接退出
    	$isTeacher = session('is_teacher');
		$message = "";
    	if($isTeacher == "0"){
			$this->redirect("ErrorHandling/ErrorHandling/error", array('message'=>'您没有注册成为老师，不能访问该功能'));
    	}else if($isTeacher == "1"){
			$this->redirect("ErrorHandling/ErrorHandling/error", array('message'=>'您的老师资质尚未审核通过，还不能访问该功能'));
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
		
		$token = $auth->uploadToken($bucket);			//token,用来上传图片到七牛
		$courseCode = I('get.courseCode',"A1");			//courseCode,用来拿assessmentSettings
		$recordId = I('get.recordId',"");				//recordId,主键，用来更新teachingRecord
		$teachingDt = I('get.teachingDt',"");			//teachingDt,系统设定教学时间，用来显示系统设定教学时间		
		$transactionId = I('get.transactionId',"");		//transactionId,订单号，用来重导向
		$status = I('get.status',"");					//status,状态,用来控制显示
		$openId = session('openid');
		
		if($recordId == "" || $teachingDt == "" || $transactionId == "" || $status == ""){
			$this->redirect("ErrorHandling/ErrorHandling/error", array('message'=>'系统错误'));
		}else{
			$assessmentSettings = D("TeachingRecord", "Logic")->getAssessmentSettingsByCourseCode($courseCode);
			if(count($assessmentSettings) == 0){
				$assessmentSettings = D("TeachingRecord", "Logic")->getAssessmentSettingsByCourseCode("A1");
			}
			$this->assign("token",$token);
			$this->assign("recordId",$recordId);
			$this->assign("teachingDt",$teachingDt);
			$this->assign("transactionId",$transactionId);
			$this->assign("status",$status);
			$this->assign("assessmentSettings",$assessmentSettings);
			$this->assign("title","上传课堂记录");
			if(D("TeachingRecord", "Logic")->isParent($openId) == true){
				$this->assign("isParent","1");
			}else{
				$this->assign("isParent","0");
			}
			if($status == "1"){
				$this->assign("title","课堂记录详情");
				$recordInformation = D("TeachingRecord", "Logic")->getTeachingRecordInformation($recordId);
				$this->assign("recordInformation",$recordInformation);
			}	
			$this->display();
		}
	}
	
	public function insertNewTeachingRecord(){
		$newTeachingRecord = array();
		$newTeachingRecord["assessmentScore"] = I("post.assessmentScore");
		$newTeachingRecord["teachingDt"] = I("post.teachingDt");
		$newTeachingRecord["comment"] = I("post.comment");
		$newTeachingRecord["teachingImage"] = I("post.teachingImage");
		$newTeachingRecord["overallScore"] = I("post.overallScore");
		$newTeachingRecord["recordId"] = I("post.recordId");
		D("TeachingRecord", "Logic")->insertNewTeachingRecord($newTeachingRecord);
		echo json_encode(array("status"=>"ok"));
	}
	
	public function teachingRecord($transactionId){
		$data = D("TeachingRecord", "Logic")->getTeachingRecord($transactionId);
		//echo $teachingRecords->result["0"]["transactionId"];
		//echo $teachingRecords->course["interest"];
		$this->assign("data", $data);
		$this->display();
	}
}