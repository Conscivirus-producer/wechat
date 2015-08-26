<?php
	namespace Common\Logic;
	use Common\Model\TeachingRecordModel;
	class TeachingRecordLogic extends TeachingRecordModel{
		public function getTeachingRecord($transactionId){
			//$teachingRecord = D("TeachingRecord");
			return $this->where(array("transactionId" => $transactionId))->select();
		}
		
	}

?>