<?
/*
  Импорт/экспорт данных - работа с мусклом
  Дмитрий Скачко для 3110, 2015г.
*/
 
class dataController {
 
  	protected $sqlhost = 'localhost';
	protected $sqluser = 'root';
	protected $sqlpass = '';
	protected $sqltable = 'weirdee'; 
	protected $charset = 'utf8';
	private $db = null;
    private $result = null; 
	
	public function __construct()
        {
                $this->db = new mysqli($this->sqlhost, $this->sqluser, $this->sqlpass, $this->sqltable);
                $this->db->set_charset($this->charset);
        } 		
		
	public function query($query)
        {
                if(!$this->db)
                        return false;   
                if(is_object($this->result))
                        $this->result->free();  
                $this->result = $this->db->query($query);  
                if($this->db->errno)
                        die("mysqli error #".$this->db->errno.": ".$this->db->error); 

                if(is_object($this->result))
                {
                        while($row = $this->result->fetch_assoc())
                                $data[] = $row;                        
                        return $data;
                }   
                else if($this->result == FALSE)
                        return false;                         
                else return $this->db->affected_rows;
        }  
  
  function GetTextFromDBbyId($id)
  {
	$data = $this->query("SELECT text FROM data WHERE id = '".$id."'");
	return $data[0]["text"];
  }
  
  function GetTextFromDBbySection($section)
  {
	$data = $this->query("SELECT text FROM data WHERE section = '".$section."'");
	return $data[0]["text"];
  }
  
  function GetAllTexts()
  {
	$data = $this->query("SELECT * FROM data");
	return $data;
  }
  
  function SetText($text, $id)
  {
	$this->query("UPDATE data SET text='".$text."' WHERE id = '".$id."'");
	return true;
  }
  
  function LoginGetMd5($param)
  {
	$data = $this->query("SELECT user_id, user_password FROM users WHERE user_login='".$param."' LIMIT 1");
	return $data[0];
  }
  
  function LoginWriteHash($hash, $insip = 0, $id, $user_ip)
  {
	  $ip = "";
	  if($insip == 1) { $ip = ", user_ip=INET_ATON('".$user_ip."')";}
	$data = $this->query("UPDATE users SET user_hash='".$hash."' ".$ip." WHERE user_id='".$id."'");
	return true;
  }
  
  function LoginGetUserData($param)
  {
	$data = $this->query("SELECT *,INET_NTOA(user_ip) FROM users WHERE user_id = '".$param."' LIMIT 1");
	return $data[0];
  }
  
  function CheckFieldsN($num)
  {
	$data = $this->query("SELECT COUNT(*) FROM data");
	if($data[0]<$num)
	{
		for($i=0; $i<$num; $i++)
		{
			$this->query("INSERT INTO data (text) values('<Empty>')");
		}
	}
  }
  
}
 
?>