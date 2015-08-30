<?php
	namespace Common\Logic;
	use Common\Model\TeachingRecordModel;
	use Common\Model\AssessmentSettingModel;
	use Common\Model\TeachingAssessmentModel;
	class TeachingRecordLogic extends TeachingRecordModel{
		public function getTeachingRecord($transactionId){
			//$teachingRecord = D("TeachingRecord");
			$datemap["teachingDt"] = array('gt', date("Y-m-d h:i:s"));
			$datemap["transactionId"] = array('eq', $transactionId);
			$recordId = $this->where($datemap)->getfield('recordId');
			$map["transactionId"] = $transactionId;
			$map["recordId"] = array('elt', $recordId);
			return $this->where($map)->order('recordId desc')->select();
		}
		
	    public function autoGenerateTeachingRecord($transactionId, $isInitial){
	    	$transaction = D("Transaction");
			$data = $transaction->where(array("transactionId" => $transactionId))->select();
			if($data[0]["fixedTime"] == '' || $data[0]["teachingFrequency"] == ''){
				return;
			}
			$startDate;
			if($isInitial == "Y"){
				$startDate = $data[0]["fixedTime"];
				$this->initialSingleTeacherRecord($transactionId, $startDate);
			} else{
				$startDate = date('y-m-d h:i:s',time());
			}
	    	$weekFrequency = $data[0]["teachingFrequency"];
			//$startdate = "2015-09-01 13:40:00";
			$weekMap = array("1"=>"Monday", "2"=>"Tuesday", "3"=>"Wednesday", "4"=>"Thursday", "5"=>"Friday", "6"=>"Saturday", "7"=>"Sunday");
			$weekCdeArray = explode(',', $weekFrequency);
			for($i = 0;$i < count($weekCdeArray); $i++){
				$teachingTime = date("Y-m-d H:i:s", strtotime("next ".$weekMap[$weekCdeArray[$i]], strtotime($startDate)));
				$this->initialSingleTeacherRecord($transactionId, $teachingTime);
			}
    	}

		protected function initialSingleTeacherRecord($transactionId, $teachingTime)
		{
			$map["teachingDt"] = array('eq',$teachingTime);
			$map["transactionId"] = array('eq',$transactionId);
			$result = $this->where($map)->select();
			if(count($result) == 0){
				$data["transactionId"] = $transactionId;
				$data["createdDt"] = date('y-m-d h:i:s',time());
				$data["teachingDt"] = $teachingTime;
				$data["status"] = "0";
				echo $this->add($data);
			}
		}
    	
    	public function getAssessmentSettingsByCourseCode($courseCode){
    		$AssessmentSetting = D("AssessmentSetting");
    		$condition["courseCode"] = $courseCode;
    		return $AssessmentSetting->where($condition)->select();
    	}
    	
    	public function insertNewTeachingRecord($teachingRecord){
    		$data["recordId"] = $teachingRecord["recordId"];
    		$data["teachingDt"] = $teachingRecord["teachingDt"];
    		$data["overallScore"] = $teachingRecord["overallScore"];
    		$data["comment"] = $teachingRecord["comment"];
    		$data["teachingImage"] = $teachingRecord["teachingImage"];
    		$data["status"] = "1";
    		$this->save($data);
    		$TeachingAssessment = D("TeachingAssessment");
    		$teachingRecordId = $teachingRecord["recordId"];
    		$assessmentScore = $teachingRecord["assessmentScore"];
    		$scoreArray = explode(",",$assessmentScore);
    		for($i = 0;$i < count($scoreArray);$i++){
    			$assessmentData["teachingRecordId"] = $teachingRecordId;
    			$assessmentData["assessCode"] = $i+1;
    			$assessmentData["score"] = $scoreArray[$i];
    			$TeachingAssessment->add($assessmentData);
    		}
    	}
    	
    	public function getTeachingRecordInformation($recordId){
    		$condition["recordId"] = $recordId;
    		$data = $this->where($condition)->select();
    		$TeachingAssessment = D("TeachingAssessment");
    		$map["teachingRecordId"] = $recordId;
    		$data["assessmentScore"] = $TeachingAssessment->where($map)->select();
    		return json_encode($data);
    	}
		
	}

?>