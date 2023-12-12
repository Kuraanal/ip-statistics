<?php

	// Ajout du reseau et de ses adresses IP.
	if($_GET['action'] == 'ajoutlan')
	{
		ajout_lan($_POST['lanip'], $_POST['mask'], $_POST['name'], $_POST['site']);
	}
	// Suppression d'un router.
	elseif($_GET['action'] == 'del_lan') del_lan($_GET['id']);
	// Ajout d'un router
	elseif($_GET['action'] == 'ajoutrouter')
	{
	$iprouter = $_POST['iprouter'];
	$commrouter = $_POST['commrouter'];
	$namerouter = $_POST['namerouter'];
		$c = new database();
		$c->db_connect();
		
			$query = "INSERT INTO `routers` (router_id, router_ip, router_comm, router_name) VALUES ('', '$iprouter', '$commrouter', '$namerouter')";
			$sql = mysql_query($query) or die(mysql_error());

		$error_message .= 'Ajout du Router OK.<br>';
		$c->db_close();
	}
	// Suppression d'un router
	elseif($_GET['action'] == 'delrouter')
	{
		$idrouter = $_GET['id'];
		$c = new database();
		$c->db_connect();
		
			$query = "DELETE FROM `routers` WHERE `router_id` = '$idrouter'";
			$sql = mysql_query($query) or die(mysql_error());
			
		$error_message .= 'Suppression du Router OK.<br>';
		$c->db_close();

	}
	// Mise a jour des IP depuis la table ARP
	elseif($_GET['action'] == 'update')
	{
		$c = new database();
		$c->db_connect();
		$router = $_POST['routers'];
		
			$query = "SELECT * FROM `routers` WHERE `router_id` LIKE $router LIMIT 1";
			$sql = mysql_query($query) or die('Impossible : '.mysql_error());
			while($data = mysql_fetch_assoc($sql))
			{
				$iprouter = $data['router_ip'];
				$commrouter = $data['router_comm'];
			}
		
		$c->db_close();
		
		// Mise a jour des IP
		update_ip($iprouter, $commrouter);
	}
	
?>