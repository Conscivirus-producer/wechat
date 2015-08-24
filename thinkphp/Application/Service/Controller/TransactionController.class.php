<?php
namespace Service\Controller;
use Think\Controller;
class TransactionController extends Controller{
	public function getTransactionsByTeacherOpenId(){
		if(IS_GET){
			$Transaction = D("Transaction");
			$teacherOpenId = I("teacherOpenId");
			$condition["teacherOpenid"] = $teacherOpenId;
			$data = $Transaction->where($condition)->select(); 
			$this->ajaxReturn($data);
		}
	}
}