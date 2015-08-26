<?php
	namespace Common\Logic;
	use Common\Model\TeachingRecordModel;
	class TeachingRecordLogic extends TeachingRecordModel{
		public function test(){
			//$teachingRecord = D("TeachingRecord");
			echo $transactionId;
			echo count($this->where(array("transactionId" => "326"))->select());
		}
		
	}

?>