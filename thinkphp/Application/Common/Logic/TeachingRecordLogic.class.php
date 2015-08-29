<?php
	namespace Common\Logic;
	use Common\Model\TeachingRecordModel;
	class TeachingRecordLogic extends TeachingRecordModel{
		public function getTeachingRecord($transactionId){
			//$teachingRecord = D("TeachingRecord");
			$datemap["teachingDt"] = array('gt', date("Y-m-d h:i:s"));
			$recordId = $this->where($datemap)->getfield('recordId');
			$map["transactionId"] = $transactionId;
			$map["recordId"] = array('elt', $recordId);
			return $this->where($map)->order('recordId desc')->select();
		}
		
	    public function insertTeachingRecord($transactionId, $isInitial){
	    	$transaction = D("Transaction");
			$data = $transaction->where(array("transactionId" => $transactionId))->select();
			$startDate = $isInitial == "Y" ? $data[0]["fixedTime"] : date('y-m-d h:i:s',time());
	    	$weekFrequency = $data[0]["teachingFrequency"];
			//$startdate = "2015-09-01 13:40:00";
			$weekMap = array("1"=>"Monday", "2"=>"Tuesday", "3"=>"Wednesday", "4"=>"Thursday", "5"=>"Friday", "6"=>"Saturday", "7"=>"Sunday");
			$weekCdeArray = explode(',', $weekFrequency);
			for($i = 0;$i < count($weekCdeArray); $i++){
				$teachingTime = date("Y-m-d H:i:s", strtotime("next ".$weekMap[$weekCdeArray[$i]], strtotime($startDate)));
				$map["teachingDt"] = array('eq',$teachingTime);
				$map["transactionId"] = array('eq',$transactionId);
				$result = $this->where($map)->select();
				if(count($result) == 0){
					$data["transactionId"] = $transactionId;
					$data["createdDt"] = date('y-m-d h:i:s',time());
					$data["teachingDt"] = $teachingTime;
				}
			}
    	}
	}

?>