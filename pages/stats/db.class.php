<?php

class database
{

	// Atributs de la classe
	private $db_ip = 'localhost';
	private $db_name = 'ip_stat';
	private $db_user = 'username';
	private $db_pass = 'password';
	private $db_connected;
	
	/*----------------
	/ Contructeur
	----------------*/
	function __construct()
	{

	}
	
	function db_connect()
	{
		global $error_message;
		$this->db_connected = mysql_connect($this->db_ip, $this->db_user, $this->db_pass)
					 or die('Impossible de se connecter a la base de donn�e. : '.mysql_error());
		$dbselect = mysql_select_db($this->db_name, $this->db_connected)
					or die ('Impossible de selectionner la base : '.mysql_error());
					
		$error_message .=  'Connexion ok.<br>';
	}
	
	function db_close()
	{
		global $error_message;
		mysql_close($this->db_connected);
		$error_message .= 'Fermeture de la base';
	}
}

?>