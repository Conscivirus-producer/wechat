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
    	$map["name"] = array('like','%'.I('name').'%');
    	$map["studentNumber"] = array('like','%'.I('studentNumber').'%');
    	$map["faculty"] = array('like','%'.I('faculty').'%');
    	$map["major"] = array('like','%'.I('major').'%');
    	$map["gender"] = array('like','%'.I('gender').'%');
    	$map["mobile"] = array('like','%'.I('mobile').'%');
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
    	$Teacher  =   M('Teacher');
    	$data =   $Teacher->table('T_teacher')->where($map)->select();
    	
    	//print_r($data);
    	$len = count($data);
    	$offers = array();
    	for($i = 0;$i < $len;$i++){
    		$openId = $data[$i]["openid"];
    		$offermap["teacherOpenId"] = array('like','%'.$openId.'%');
    		$Offers = M("Offers");
    		$offer = $Offers->field("name")->select();
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
    		$places = explode(",",$place);
    		for($j=0;$j<count($places);$j++){
    			$places[$j] = $location[$places[$j]];
    		}
    		$data[$i]["address"] = implode("，",$places);
    	}
    	$certifications = array();
    	for($i = 0;$i < $len;$i++){
    		$openId = $data[$i]["openid"];
    		$certificatemap["teacherOpenId"] = array('like','%'.$openId.'%');
    		$certificates = M("Certifications");
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
}










