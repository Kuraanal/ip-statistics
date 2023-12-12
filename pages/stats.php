<?php


if(isset($_GET['type']))
{
if(isset($_POST['choixlan'])) $lan_id = $_POST['choixlan'];
elseif(isset($_GET['id'])) $lan_id = $_GET['id'];

$lan_name = new database();
$lan_name->db_connect();

$sql = "SELECT lan_id, lan_name, lan_ip FROM reseaux WHERE lan_id LIKE '$lan_id'";
$req = mysql_query($sql);
while($data = mysql_fetch_assoc($req))
{
$lan_name = $data['lan_name'];
$lan_ip = $data['lan_ip'];
}

echo 'Liste des IP du reseau : <strong>'.$lan_name.' - '.$lan_ip.'</strong><br>
<div class="block_ip">
';

affich_ip($lan_id);

echo '
</div>
<span style="margin-left: 15px;"><img src="pages/stats/statslan.php?id='.$lan_id.'"></span>
';
}
else
{

echo '<div style="width: 400px; height: 260px; padding-left: 10px; padding-top: 20px;"><img src="pages/stats/imgstats.php"></div>';

}
?>