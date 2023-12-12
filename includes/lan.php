<?php

// Fonction d'ajout des adresses IP a un reseau.
function ajout_ip($lan, $ip, $mask)
{
 global $error_message;
 
 exec('nmap -n -sL '.$ip.'/'.$mask.' | grep -v Starting | grep -v finished | cut -f2 -d " "', $result);
//print_r($result);
 
 unset($result['0']);
 unset($result['1']);
 unset($result[count($result)+1]);
 
 $i = '2';

 for($i > '1'; $i <= count($result)+1; $i++)
 {
 $sql = "INSERT INTO `adr_ip` (adr_ip_ip, adr_ip_lan, adr_ip_time) VALUES ('$result[$i]', '$lan', '0')";
 $query = mysql_query($sql)
 		  or die ('Ajout impossible.<br>'.mysql_error());
 }
 
 $error_message .= 'Ajout de '.count($result).' IP termin�<br>';
}


// Fonction d'ajout des reseaux
function ajout_lan($lan, $mask, $name, $site)
{
 global $error_message;
 
 $a = new database();
 $a->db_connect();
 
 $sql = "INSERT INTO `reseaux` (lan_id, lan_ip, lan_mask, lan_name, lan_site) VALUES ('', '$lan', '$mask', '$name', '$site')";
 $query = mysql_query($sql)
 		  or die ('Ajout impossible.<br>'.mysql_error());
		  
 $sql2 = "SELECT * FROM `reseaux` WHERE `lan_name` LIKE '$name' ORDER BY lan_id DESC LIMIT 1";
 $query2 = mysql_query($sql2) or die(mysql_error());
 while($data2 = mysql_fetch_assoc($query2))
 {
 $lanid = $data2['lan_id'];
 }
 $error_message .= 'Ajout du reseau termin�<br>'; 
 
 // Ajout des ip du lan cr�e
 ajout_ip($lanid, $lan, $mask);

 $a->db_close();
}
// Suppression d'un reseau depuis la base
function del_lan($lan)
{
	global $error_message;

	$c = new database();
	$c->db_connect();
	
	$query = "DELETE FROM reseaux WHERE lan_id LIKE '$lan'";
	$sql = mysql_query($query);
	$query = "DELETE FROM adrp_ip WHERE adr_ip_lan LIKE '$lan'";
	$sql = mysql_query($query);
	
	$error_message .= 'Suppression effectu�e';
}

// Fonctione de mise a jour des adresse ip recuper�e dans la table ARP du routeur.
function update_ip($adr_router, $comm_router)
{
	global $error_message;
	// echo 'Recherche de la table ARP<br>';
	exec('snmpwalk -c '.$comm_router.' -v 1 '.$adr_router.' .1.3.6.1.2.1.4.22.1.2 | cut -d . -f 3-6 | cut -d " " -f 1', $result);
	$time = time();
	if(!empty($result)) echo 'wasabi';
	
	$c = new database();
	$c->db_connect();
	
	for($i > '0'; $i <= count($result)-'1'; $i++)
	{
		$query = "UPDATE `adr_ip` SET `adr_ip_ip` = '$result[$i]', `adr_ip_time` = '$time' WHERE adr_ip_ip LIKE '$result[$i]'";
		$sql = mysql_query($query);
	}
	
	$error_message .=  'Mise a jour des IP dans la base effectu�e.<br>';
	$c->db_close();
}

function affich_ip($lan_id)
{
$c = new database();
$c->db_connect();
$timenow = time();

$query = "SELECT * FROM `adr_ip` WHERE `adr_ip_lan` LIKE '$lan_id'";
$sql = mysql_query($query);
while($data = mysql_fetch_assoc($sql))
{
$time = $timenow-$data['adr_ip_time'];

	if($time <= 1209600) $class = 'ip_up';
	elseif($time > 1209600 && $time <= 5356800) $class = 'ip_middle';
	elseif($time > 5356800 && $time <= 6566400) $class = 'ip_red';
	else $class = 'ip_down';
	
echo '<div class="'.$class.'">'.$data['adr_ip_ip'].'</div>';
}
}
?>