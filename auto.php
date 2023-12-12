<?php
require_once('includes/classes/db.class.php');
require_once('includes/lan.php');

$c = new database();
$c->db_connect();

$query = "SELECT * FROM routers ORDER BY router_id ASC";
$sql = mysql_query($query);
while($data = mysql_fetch_assoc($sql))
{
	$ip = $data['router_ip'];
	$comm = $data['router_comm'];

	update_ip($ip, $comm);
	sleep('1');
}	

?>