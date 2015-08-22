<?php
namespace Wechat\Controller;
use Think\Controller;
class TeacherRecordController extends Controller {
    public function index(){
    	echo "Hello, wechat!";
		echo session('openid');
    }
	
	public function myClassList(){
		$parent = D("Parent");
		$data = $parent->select();
		//for ($i=0;$i < count($data); $i++){
			//echo $data[$i]["openid"];
		//}
		echo session('openid');
		$this->assign("name","qop");
		$this->display();
	}
}