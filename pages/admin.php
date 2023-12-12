<?php

if(isset($_GET['action']))
{
	include('actions.php');
}

echo '<div style="clear: both; width: 400px; background-color: #bbb; color: #cc2222; margin-left: auto; margin-right: auto; margin-bottom: 25px;">
'.$error_message.'
</div>
';

echo '<div class="routers">
<center>Liste des routeurs.</center><br>
';
$c = new database();
$c->db_connect();
	$query = "SELECT * FROM routers ORDER BY router_id ASC";
	$sql = mysql_query($query) or die (mysql_error());
	while($data = mysql_fetch_assoc($sql))
	{
		Echo '<div class="router"">
		'.$data['router_name'].' - '.$data['router_ip'].' - <a href="index.php?page=admin&action=delrouter&id='.$data['router_id'].'"><img src="./theme/images/del.png"></a>
		</div>';
	}
$c->db_close();
echo '
<form name=index action="index.php?page=admin&action=ajoutrouter" method="post">
	<center><u>Ajout d\'un router</u></center>
	IP: <input type="text" size="20" name="iprouter"><br>
	Communauté router : <input type="text" size="20" name="commrouter"><br>
	Nom du router : <input type="text" size="20" name="namerouter"><br><br>
	<center><input type="submit" value="Ajouter le routeur"></center>
</form>
</div>';

echo '<div class="reseaux">
<center>Liste des reseaux.</center><br>
';
$c = new database();
$c->db_connect();
	$query = "SELECT * FROM reseaux ORDER BY lan_site ASC";
	$sql = mysql_query($query) or die (mysql_error());
	while($data = mysql_fetch_assoc($sql))
	{
		Echo '<a href="index.php?page=stats&type=lan&id='.$data['lan_id'].'"><div class="lan">
		'.$data['lan_name'].' - '.$data['lan_ip'].'/'.$data['lan_mask'].' - <a href="index.php?page=admin&action=del_lan&id='.$data['lan_id'].'"><img src="./theme/images/del.png"></a>
		</div></a>';
	}
echo '<br>';
$c->db_close();
echo '<br><div style="float: right; width: 450px;">
<form name=index action="index.php?page=admin&action=ajoutlan" method="post">

  <br>
	Adresse reseau : <input type="text" size="20" name="lanip"> - 
	Mask : <input type="text" size="5" name="mask"><br>
	Nom du reseau : <input type="text" size="25" name="name"><br>
	Nom du Site : <input type="texte" size="25" name="site">
	<center><input type="submit" value="Creer les ip"></center>
</form></div>
</div>';

?>