<?php
namespace Wechat\Controller;
use Think\Controller;
class TeacherRecordController extends Controller {
    public function index(){
    	echo "Hello, wechat!";
		echo session('openid');
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
}