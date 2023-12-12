<?php

class user
{
	// Atributs
	public $user_name;
	private $user_password;
	private $user_isadmin;
	
	// Constructeur
	function __construct($user, $pass)
	{
		$this->user_name = $user;
		$this->user_password = $pass;
	}
	
	// Fonction de login
	function login()
	{
		$c = new database();
		$c->db_connect();
	
		$query = "SELECT * FROM user WHERE user_name LIKE '$this->user_name'";
		$sql = mysql_query($query) or die(mysql_error());
		while($data = mysql_fetch_assoc($sql))
		{
			if($data['user_pass'] == md5($this->user_password)) $_SESSION['userconnected'] = '1';
			else echo 'Ca a foiré';
		}
		
		$c->db_close();
	}
	
	function logout()
	{
		unset($_SESSION['userconnected']);
	}
}

?>