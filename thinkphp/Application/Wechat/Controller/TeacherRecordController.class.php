<?php
namespace Wechat\Controller;
use Think\Controller;
class TeacherRecordController extends Controller {
    public function index(){
    	echo "Hello, wechat!";
		echo session('openid');
    }
	
	public function myClassList(){
		$transaction = D("Transaction");
		$data = $transaction->select();
		//for ($i=0;$i < count($data); $i++){
			//echo $data[$i]["openid"];
		//}
		$userOpenId = session('openid');
		$this->assign("data",$data);
		$this->display();
	}
}