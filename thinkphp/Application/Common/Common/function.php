<?php
use Think\Log;
	function getGradeName($grade){
		$gradeArray = array(
			'grade1' => "小学一年级",
			'grade2' => "小学二年级",
			'grade3' => "小学三年级",
			'grade4' => "小学四年级",
			'grade5' => "小学五年级",
			'grade6' => "小学六年级",
			'grade7' => "初一",
			'grade8' => "初二",
			'grade9' => "初三",
			'grade10' => "高一",
			'grade11' => "高二",
			'grade12' => "高三",
		);
		return $gradeArray[$grade];
	}
	
	function formatCourse($subject, $interest){
		$subject = getSubject($subject);
		$interest = getInterestName($interest);
		
		$course = "";
		if($subject != "" && $interest != ""){
			$course = $subject.",".$interest;
		}else if($subject != ""){
			$course = $subject;
		}else if($interest != ""){
			$course = $interest;
		}
		LOG::write($course, 'WARN');
		return $course;
	}
	
	function getInterestName($interest){
		if($interest == "" || $interest == "undefined"){
			return "";
		}
		$offer = D("Offer");
		$map["code"] = array('eq',$interest);
		$data = $offer->where($map)->select();
		return $data[0]["name"];
	}
	
	function getExpectedLocation($location){
		if($location == 'address1'){
			return "南山区";
		} else if($location == 'address2'){
			return "福田区";	
		} else if($location == 'address3'){
			return "罗湖区";	
		} else if($location == 'address4'){
			return "宝安区";	
		} else if($location == 'address5'){
			return "龙岗区";	
		} else if($location == 'address6'){
			return "其它";	
		} else{
			return $location;
		}
	}
	
	function getStatusDescription($status){
		if($status == "1"){
			return "1.新订单";
		}else if($status == "2"){
			return 	"2.客服已联系家长,家长未确定";
		}else if($status == "3"){
			return 	"3.家长已同意,安排试教中";
		}else if($status == "4"){
			return 	"4.已试教";
		}else if($status == "5"){
			return 	"5.订单正式确定";
		}else if($status == "C"){
			return 	"C.订单已取消";
		}else if($status == "S"){
			return 	"S.优质订单";
		}
	}
	
	function getExpectedGender($gender){
		if($gender == "gender1"){
			return "男";
		} else if($gender == "gender1"){
			return "女";	
		} else{
			return "男女不限";
		}
	}
	
	function getExpectedPrice($price){
		if($price == "price1"){
			return "50 ~ 100";
		}else if($price == "price2"){
			return "100 ~ 150";
		}else if($price == "price3"){
			return "150以上";
		}else{
			return "";
		}
	}
	
	function handleNullValue($value){
		if($value == null || $value == ""){
			return "";
		}
		return $value;
	}

	function getSubject($subject){
		//split(',', $subject);
		$subject = strtoupper($subject);
		if($subject == "SU1"){
			return "数学";
		}else if($subject == "SU2"){
			return "英语";
		}else if($subject == "SU3"){
			return "语文";
		}else if($subject == "SU4"){
			return "全科";
		}else if($subject == "UNDEFINED"){
			return "";
		}else{
			return $subject;
		}
	}
	
	function startsWith($haystack, $needle) {
	    // search backwards starting from haystack length characters from the end
	    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
	} 