<?php
namespace ErrorHandling\Controller;
use Think\Controller;

class ErrorHandlingController extends Controller {
	public function error(){
		$this->assign("message",I("message"));
		$this->display();
	}
}