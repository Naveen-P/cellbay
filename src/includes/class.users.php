<?php
class users{
private $uid,$uname,$uemail,$upwd,$ugender,$udob,$ujdate,$uprof,$uimage,$torders,$loid;

public function __construct()
{
/*$argv = func_get_args();
$argc = func_num_args();
if($argc==1)
call_user_func_array(array($this,'view'),$argv);
if($i>1)
call_user_func_array(array($this,'create'),$argv);*/
//echo "Constructor!";
}

public function view($uid){
	$sql = mysql_query("SELECT * FROM users WHERE UserID=$uid");
	$row=mysql_fetch_assoc($sql);
	$this->uid=$uid;
	$this->uname=$row['UserName'];
	$this->uemail=$row['UserEmail'];
	$this->upwd=$row['UserPassword'];
	$this->ugender=$row['UserGender'];
	$this->udob=$row['UserDOB'];
	$this->ujdate=$row['UserJoinDate'];
	$this->uprof=$row['UserProfession'];
	$this->uimage=$row['UserImage'];
	$this->torders=$row['TotalOrders'];
	$this->loid=$row['LastOrderID'];
}

public function getUID(){
	return $this->uid;
}

public function getUname(){
	return $this->uname;
}

public function getUEmail(){
	return $this->uemail;
}

public function getUPwd(){
	return $this->upwd;
}

public function getUGender(){
	return $this->ugender;
}

public function getUDOB(){
	return $this->udob;
}

public function getUJDate(){
	return $this->ujdate;
}

public function getUProf(){
	return $this->uprof;
}

public function getUImage(){
	return $this->uimage;
}

public function getTorders(){
	return $this->torders;
}

public function getLoid(){
	return $this->loid;
}

public function create($fields,$values){
if(!is_array($fields) || !is_array($values))
            return 'Error - Fields and values must be sent as an array';
                        
        $field_ct  = count($fields);
        $value_ct = count($values);
        if($field_ct != $value_ct)
            return 'Error - Field count and value count do not match.';
                        
        $query1 = "INSERT INTO `users` (`";
        $query1 .= implode('`, `', $fields) . "`) VALUES ('";
        $query1 .= implode("', '", $values) . "')";
        $exec=dbquery($query1);
        return $exec;

}

}
?>
