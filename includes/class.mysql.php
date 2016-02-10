<?php
/*
	ชื่อไฟล์					class.mysql.php
	การใช้งาน				ใช้ในการเชื่อมต่อฐานข้อมูล MySQL
	ผู้เขียน					อัษฎา อินต๊ะ
	ติดต่อ					webmaster@mocyc.com
*/
if( !defined('_MAXSITE') ) die ('Invalid');

class DB{
	//ส่วนของการเชื่อมต่อ
	var $host = DB_HOST ;
	var $database ;
	var $connect_db ;
	var $selectdb ;
	var $db ;
	var $sql ;
	var $table ;
	var $where;

	////////////////////// ฟังก์ชั่นต่างๆ //////////////////////
	//เชื่อมต่อดาต้าเบส
	function connectdb($db_name="database",$user="username",$pwd="password"){
		$this->database = $db_name;
		$this->username = $user;
		$this->password = $pwd;
		$this->connect_db = mysql_connect ( $this->host, $this->username, $this->password ) or $this->_error();
		//$this->connect_db = mysql_pconnect ( $this->host, $this->username, $this->password ) or $this->_error();
		$this->db = mysql_select_db ( $this->database, $this->connect_db) or $this->_error();
		mysql_query("SET NAMES UTF8");
		mysql_query("SET character_set_results=utf8");
		return true;
	}

	//ปิดการเชื่อมต่อดาต้าเบส
	function closedb( ){
		mysql_close ( $this->connect_db ) or $this->_error();
	}

	//เพิ่มข้อมูล
	//$db->add_db("table",array("field"=>"value"));
	function add_db($table="table", $data="data"){
		$key = array_keys($data);
        $value = array_values($data);
		$sumdata = count($key);
		for ($i=0;$i<$sumdata;$i++)
        {
            if (empty($add)){
                $add="(";
            }else{
                $add=$add.",";
            }
            if (empty($val)){
                $val="(";
            }else{
                $val=$val.",";
            }
            $add=$add.$key[$i];
            $val=$val."'".$value[$i]."'";
        }
        $add=$add.")";
        $val=$val.")";
        $sql="INSERT INTO ".$table." ".$add." VALUES ".$val;
        if (mysql_query($sql)){
            return true;
        }else{
            $this->_error();
            return false;
        }
	}

	//แก้ไขข้อมูลแบบหลายฟิลล์
	//$db->update_db("tabel",array("field"=>"value"),"where");
    function update_db($table="table",$data="data",$where="where"){
        $key = array_keys($data);
        $value = array_values($data);
        $sumdata = count($key);
        $set="";
        for ($i=0;$i<$sumdata;$i++)
        {
            if (!empty($set)){
                $set=$set.",";
            }
            $set=$set.$key[$i]."='".$value[$i]."'";
        }
        $sql="UPDATE ".$table." SET ".$set." WHERE ".$where;
        if (mysql_query($sql)){
            return true;
        }else{
            $this->_error();
            return false;
        }
    }

	//แก้ไขข้อมูลแบบฟิลล์เดียว
	//$db->update("table","set","where");
	function update($table="table",$set="set",$where="where"){
        $sql="UPDATE ".$table." SET ".$set." WHERE ".$where;
        if (mysql_query($sql)){
            return true;
        }else{
            $this->_error();
            return false;
        }
    }

	//ลบข้อมูล
	//$db->del("table","where");
    function del($table="table",$where="where"){
        $sql="DELETE FROM ".$table." WHERE ".$where;
        if (mysql_query($sql)){
            return true;
        }else{
            $this->_error();
            return false;
        }
    }

	//นับจำนวนแถวข้อมูล
	//$db->num_rows("table","field","where");
    function num_rows($table="table",$field="field",$where="where") {
        if ($where=="") {
            $where = "";
        } else {
            $where = " WHERE ".$where;
        }
        $sql = "SELECT ".$field." FROM ".$table.$where;
        if($res = mysql_query($sql)){
            return mysql_num_rows($res);
        }else{
            $this->_error();
            return false;
        }
    }

	//Query ข้อมูล
	//$res = $db->select_query('SELECT field FROM table WHERE where');
    function select_query($sql="sql"){
        if ($res = mysql_query($sql)){
            return $res;
        }else{
            $this->_error();
            return false;
        }
    }

	//นับจำนวนแถวข้อมูล
	//$res = $db->select_query('SELECT field FROM table WHERE where');
	//$rows = $db->rows($res);
    function rows($sql="sql"){
      if ($res = mysql_num_rows($sql)){
            return $res;
        }else{
            $this->_error();
            return false;
        }
    }

	//ดึงค่า array
	//$res = $db->select_query('SELECT field FROM table WHERE where');
	//while ($arr = $db->fetch($res)) {
	//		echo $arr['a']." - ".$arr['c']."<br>\n";
	//}
    function fetch($sql="sql"){
      if ($res = mysql_fetch_assoc($sql)){
            return $res;
        }else{
            $this->_error();
            return false;
        }
    }

	//แสดงข้อความผิดพลาด
    function _error(){
        $this->error[]=mysql_errno();
    }

    public function fetchAll($query){
        $items = array();
        while( $item = mysql_fetch_assoc($query)){
            $items[] = $item;
        }
        return $items;
    }

}

class msdb{
	protected $msdb = null;
	protected $msq = null;

	public function __construct(){
		$this->connect();
	}

	public function connect(){
		try {
		    $this->msdb = new PDO('mysql:host=localhost;dbname='.DB_NAME, DB_USERNAME, DB_PASSWORD);
			$this->msdb->exec("set names utf8");
			$this->msdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			$this->log($e->getMessage());
		}
	}

	public function query($sql, $data = false){
		try {
			$this->msq = $this->msdb->prepare($sql);
			if( $data !== false && count($data) > 0 ){
				foreach( $data as $key => $val ){
					$this->msq->bindParam($key, $val);
				}
			}
			$this->msq->execute();
		} catch(PDOException $e) {
			$this->log($e->getMessage());
		}
	}

	public function fetch($sql, $data = false){
		$this->query($sql, $data);
		return $this->msq->fetch(PDO::FETCH_ASSOC);
	}

	public function fetchAll($sql, $data = false){
		$this->query($sql, $data);
		return $this->msq->fetchAll(PDO::FETCH_ASSOC);
	}

	public function update($sql, $data = false){
		// $this->query($sql, $data);
		return $this->msdb->exec($sql);
	}

	public function log($msg){
		$data = '['.date('Y-m-d H:i:s').'] '.$msg."\n";
		file_put_contents('logs/mysql-logs', $data, FILE_APPEND);
	}
}

$msdb = new msdb();
// Example for fetch, fetchAll
// $test = $msdb->fetchAll("SELECT * FROM `web_admin`");
