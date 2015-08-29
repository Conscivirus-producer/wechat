<?php
namespace InternalSupport\Controller;
use Think\Controller;
class TeachingRecordController extends Controller {
	public function test(){
		$teachingRecord = D("TeachingRecord", "Logic")->test();
	}
	
	public function insertTeachingRecord(){
		$insertTeachingRecord = D("TeachingRecord", "Logic")->autoGenerateTeachingRecord(I("transactionId"), I("isInitial"));
	}
	
	public function batchGenerateTeachingRecord(){
		$transaction = D("Transaction");
		$map["teachingFrequency"] = array('neq','');
		$map["fixedTime"] = array('neq','');
		$map["status"] = array('in',array('5','S'));
		$data = $transaction->where($map)->select();
		for($i = 0; $i < count($data); $i++){
			D("TeachingRecord", "Logic")->autoGenerateTeachingRecord($data[$i]["transactionId"], 'N');
		}
	}
}