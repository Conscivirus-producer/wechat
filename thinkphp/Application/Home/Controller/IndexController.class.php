<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        //echo U('Home/index?cate_id=1&status=1');
        //$data['status']  = 1;
		//$data['content'] = 'content';
		//$this->ajaxReturn($data);
		$this->success('新增成功', 'Home/Index/test');
    }
	
	public function test(){
		echo "test";
	}
}