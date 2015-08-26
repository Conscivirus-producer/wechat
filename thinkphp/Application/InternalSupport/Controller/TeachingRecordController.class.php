<?php
namespace InternalSupport\Controller;
use Think\Controller;
class TeachingRecordController extends Controller {
    public function insertTeachingRecord(){
    	$transactionId = "326";
    	$str = "mon,tue,wed";
		$startdate = "2015-09-01 13:40:00";
		$weekMap = array("mon"=>"Monday", "tue"=>"Tuesday", "wed"=>"Wednesday", "thu"=>"Thursday", "fri"=>"Friday", "sat"=>"Saturday", "sun"=>"Sunday");
		$weekCdeArray = explode(',', $str);
		$teachingRecord = D("TeachingRecord");
		for($i = 0;$i < count($weekCdeArray); $i++){
			$teachingTime = date("Y-m-d H:i:s", strtotime("next ".$weekMap[$weekCdeArray[$i]], strtotime($startdate)));
			$map["teachingDt"] = array('eq',$teachingTime);
			$result = $teachingRecord->where($map)->select();
			if(count($result) == 0){
				$data["transactionId"] = $transactionId;
				$data["createdDt"] = date('y-m-d h:i:s',time());
				$data["teachingDt"] = $teachingTime;
				echo $teachingRecord->add($data);
			}
		}
    }
	
	public function test(){
		$teachingRecord = D("TeachingRecord", "Logic")->test();
	}
	
}