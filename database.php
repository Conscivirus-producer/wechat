<?php
class DB{

	private $conn;
	function __construct(){
		$host = "localhost";
		$user = "root";
		$password = "2324150778t";
		$database = "wechat_schema";
		$this->$conn = new mysqli($host, $user, $password, $database);
		//mysql_select_db("wechat_schema", $conn);
		//$this->$conn->setCharset($charset);		//设置字符集
	}
	/**
	 * @return:成功返回数组，失败时返回false
	 */
	public function select($sql){
		$result = $this->$conn->query($sql);
		//$result = $this->$conn->getData($sql);
		return $result;
	}
	
	function __destruct(){

		mysql_close($this->$conn);

	}
	public function get_con(){
		return $this->$conn;
	}
}

?>