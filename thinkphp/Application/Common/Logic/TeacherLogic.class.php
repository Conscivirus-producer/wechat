<?php
	namespace Common\Logic;
	use Common\Model\TeacherModel;
	class TeacherLogic extends TeacherModel{
		public function isValidateTeacher($openid){
			$map["openId"] = array('eq',$openid);
			$map["teacherStatus"] = array('eq','R');
			$data = $this->where($map)->select();
			$returnCode = 0;
			if(count($data) > 0){
				$returnCode = $data[0]["teacherStatus"] == "R" ? 2 : 1;
			}
			return $returnCode;
		}
	}


?>