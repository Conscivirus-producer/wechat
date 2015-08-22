<?php
namespace Wechat\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	echo "Hello, wechat!";
    }
	
	public function test(){
		$parent = D("Parent");
		$data = $parent->select();
		//for ($i=0;$i < count($data); $i++){
			//echo $data[$i]["openid"];
		//}
		$this->assign("name","qop");
		$this->display();
	}
}