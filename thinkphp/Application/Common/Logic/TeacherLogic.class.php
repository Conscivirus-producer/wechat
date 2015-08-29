<?php
	namespace Common\Logic;
	use Common\Model\TeacherModel;
	class TeacherLogic extends TeacherModel{
		public function isValidateTeacher($openid){
			$map["openId"] = array('eq',$openid);
			$map["teacherStatus"] = array('eq','R');
			$data = $this->where($map)->select();
			return count($data);
		}
	}


?>