<?php
namespace Search\Controller;
use Think\Controller;
class TeacherController extends Controller{
	public function read(){
    	/*$Form   =   M('Teacher');
    	// 读取数据
    	$data =   $Form->find(I('title'));
    	if($data) {
        	$this->assign('data',$data);// 模板变量赋值
    	}else{
    		
        	//$this->error('数据错误');
    	}*/
    	
    	if(I('search')){
    	
    	$map["T_teacher.name"] = array('like','%'.I('name').'%');
    	$map["studentNumber"] = array('like','%'.I('studentNumber').'%');
    	$map["faculty"] = array('like','%'.I('faculty').'%');
    	$map["major"] = array('like','%'.I('major').'%');
    	$map["gender"] = array('like','%'.I('gender').'%');
    	$map["mobile"] = array('like','%'.I('mobile').'%');
    	$map["teacherStatus"] = array('like','%'.I('teacherStatus').'%');
    	if(I('code') != ''){
    		$map["T_offers.code"] = array('eq',I('code'));
    		$map["T_offers.status"] = array('neq','D');
    	}
    	$starttime = I('starttime');
    	if($starttime == ""){
    		$starttime = "1992-01-25 14:36";
    	}
    	$endtime = I('endtime');
    	if($endtime == ""){
    		$endtime = "3000-01-25 14:36";
    	}
    	$map["created_dt"] = array(array('gt',$starttime),array('lt',$endtime)) ;
    	$map["address"] = array('like','%'.I('address').'%');
    	$Teacher  =   D('Teacher');
    	$data = "";
    	if(I('code') != ''){
    		$data =   $Teacher->join(' T_offers ON T_teacher.openId = T_offers.teacherOpenId')->where($map)->field("openId, T_teacher.name,studentNumber,faculty,major,gender,mobile,created_dt,T_teacher.description,price,highestGrade,address,teacherStatus,rating")->order('created_dt desc')->select();
    	}else{
    		$data =   $Teacher->where($map)->order('created_dt desc')->select();
    	}
    	
    	//print_r($data);
    	$len = count($data);
    	for($i = 0;$i < $len;$i++){
    		$openId = $data[$i]["openId"];
    		$offermap["teacherOpenId"] = array('like','%'.$openId.'%');
    		$offermap["status"] = array('neq','D');
    		$Offers = D("Offer");
    		$offer = $Offers->where($offermap)->field("name")->select();
    		$data[$i]["offer"] = $offer;
    		
    		$place = $data[$i]["address"];
    		$location = array(
    			"location0" => "不限",
  				"location1" => "南山区",
  				"location2" => "福田区",
  				"location3" => "罗湖区",
  				"location4" => "宝安区",
  				"location5" => "龙岗区"
    		);
    		$grade = array(
    			"grade12"=>"高三",
  				"grade11"=>"高二",
  				"grade10"=>"高一",
  				"grade9"=>"初三",
  				"grade8"=>"初二",
  				"grade7"=>"初一",
  				"grade6"=>"小学六年级",
  				"grade5"=>"小学五年级",
  				"grade4"=>"小学四年级",
  				"grade3"=>"小学三年级",
  				"grade2"=>"小学二年级",
  				"grade1"=>"小学一年级"
    		);
    		$gender = array(
    			"f" =>"女",
    			"m" =>"男"
    		);
    		$places = explode(",",$place);
    		for($j=0;$j<count($places);$j++){
    			$places[$j] = $location[$places[$j]];
    		}
    		$data[$i]["address"] = implode("，",$places);
    		$data[$i]["highestGrade"] = $grade[$data[$i]["highestGrade"]];
    		$data[$i]["gender"] = $gender[$data[$i]["gender"]];
    	}
    	for($i = 0;$i < $len;$i++){
    		$openId = $data[$i]["openId"];
    		$certificatemap["teacherOpenId"] = array('like','%'.$openId.'%');
    		$certificates = D("Certificate");
    		$certificate = $certificates->where($certificatemap)->field("description")->select();
    		
    		$data[$i]["certificate"] = $certificate;
    	}
    	if($data) {
    		//print_r($data);
        	$this->assign('data',$data);
        	$location = array(
    			"location0" => "不限",
  				"location1" => "南山区",
  				"location2" => "福田区",
  				"location3" => "罗湖区",
  				"location4" => "宝安区",
  				"location5" => "龙岗区"
    		);
    		$this->assign('location',$location);
    		$this->display();
    	}else{
        	$this->error('数据错误');
    	}
    	
    	}else{
    		$this->display();
    	}
 	}
 	
 	public function update(){
 		if(IS_GET){
 			$Teacher = D('Teacher');
 			$data["openId"] = I("openId");
 			$data[I("field")] = I("val");
 			$Teacher->save($data);
 			$jsonData['status']  = 1;
			echo json_encode($jsonData);
 		}
 	}
}










