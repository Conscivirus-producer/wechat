<?php 

class CodeParser{
	function __construct(){
		
	}
	
	public function getGradeName($grade){
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
	
	public function getInterestName($interest, $conn){
		if($interest == "" || $interest == "undefined"){
			return "";
		}
		$query = "set names utf8";
		$result = $conn->query($query);
		$query = "SELECT * FROM `T_offers` WHERE code = '$interest' LIMIT 1";
		$result = $conn->query($query);
		if($result->num_rows == 0){
			return $interest;
		}
		$row = $result->fetch_assoc();
		return $row["name"];
	}
	
	public 	function getExpectedLocation($location){
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
	
	public function getStatusDescription($status){
		if($status == "1"){
			return "1.订单已提交";
		}else if($status == "2"){
			return 	"2.已回复家长";
		}else if($status == "3"){
			return 	"3.家长已同意";
		}else if($status == "4"){
			return 	"4.学生已联系家长";
		}else if($status == "5"){
			return 	"5.已确定首次试教时间和地点";
		}else if($status == "6"){
			return 	"6.已上门试教";
		}else if($status == "7"){
			return 	"7.确定具体的交易细节";
		}
	}
	
	public function getExpectedGender($gender){
		if($gender == "gender1"){
			return "男";
		} else if($gender == "gender1"){
			return "女";	
		} else{
			return "男女不限";
		}
	}
	
	public function getExpectedPrice($price){
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
	
	public function handleNullValue($value){
		if($value == null || $value == ""){
			return "";
		}
		return $value;
	}

	public function getSubject($subject){
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
}
?>