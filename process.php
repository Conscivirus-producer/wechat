<?php
//require_once("database.php");
class Processor{
	
	private $conn;
	
	function __construct(){
		$host = "localhost";
		$user = "root";
		$password = "2324150778t";
		$database = "wechat_schema";
		$this->conn = new mysqli($host, $user, $password, $database);
	}
	
	public function saveRequester($input){
		
	}
	
	public function saveTransaction($input){
		
	}
	
	public function exec($sql){
		$this->conn->query($query);
	}
	
	//input: {"parentOpenid":""}
	//output, json array: [{"transactionId":"","createdTime":"","status":"", "teacherOpenId":"","name":"", "gender":"", "major":"","description":"", "":"", "rating":0, "imageUrl":"", "mobile":""}]
	public function getMyRecord($parentOpenId){
		$obj = json_decode($parentOpenId);
		$obj->parentOpenid;
		$query = "set names utf8";
		$result = $this->conn->query($query);

		$query = "select T_transaction.transactionId, T_transaction.createdDt, T_transaction.status, T_teacher.* from T_transaction, T_teacher where T_transaction.parentOpenid = '$obj->parentOpenid' and T_transaction.teacherOpenid = T_teacher.openId";
		$result = $this->conn->query($query);
		
		$array = array();
		while($row =$result->fetch_array()){
			$record = array("transactionId"=>$row[0],"createdTime"=>$row[1],"status"=>$row[2], 
			"teacherOpenId"=>$row[3], "major"=>$row[5], "name"=>$row[6], "gender"=>$row[7], "mobile"=>$row[8],
			"description"=>$row[9], "rating"=>$row[10], "imageUrl"=>$row[11]);
			$array[] = json_encode($record);
		}
		return json_encode($array);
	}

	//input: {"parentOpenid":"", "mobile":"", "childGender":"", "grade":"", "subject":"", "interest":""}
	//output, json array: [{"teacherOpenId":"","name":"", "gender":"", "major":"","description":"", "":"", "rating":0, "imageUrl":"", "mobile":""}]	
	public function matchTeacher($childInput){
		$obj = json_decode($childInput);
		$query = "set names utf8";
		$result = $this->conn->query($query);
		$query = "select * from T_teacher WHERE openId in (select teacherOpenId from T_offers where code = '$obj->interest')";
		if(!empty($obj->subject)){
			$query = $query." and openId in (select teacherOpenId from T_offers where code = '$obj->subject')";
		}
		$result = $this->conn->query($query);
		//{"teacherOpenId":"02","name":"", "gender":"", "major":"","description":"", "":"", "rating":0, "imageUrl":"", "mobile":""}
		$array = array();
		while($row =$result->fetch_array()){
			$record = array("teacherOpenId"=>$row[0],"major"=>$row[2],"name"=>$row[3], 
			"gender"=>$row[4], "mobile"=>$row[5], "description"=>$row[6], "rating"=>$row[7], "imageUrl"=>$row[8]);
			$array[] = json_encode($record);
		}
		return json_encode($array);
	}
	
	function __destruct(){
		$this->conn->close();
	}
}
?>