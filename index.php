<?php
session_start();
$error_message = '';
require_once('includes/classes/db.class.php');
require_once('includes/classes/user.class.php');
require_once('includes/classes/camembert.class.php');
require_once('includes/lan.php');

if(isset($_GET['login']))
{
 $u = new user($_POST['username'], $_POST['password']);
 if($_GET['login'] == '1') $u->login();
 else $u->logout();
}

include('theme/home.php');
?>