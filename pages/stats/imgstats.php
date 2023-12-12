<?php

require_once('camembert.class.php');
require_once('db.class.php');
$camembert = new camembert(); // initialisation

$c = new database();
$c->db_connect();

$time_up = time()-1209600;
$time_middle = time()-5356800;
$time_red = time()-6566400;

// Adresses UP
$query = "SELECT count(*) AS num FROM adr_ip WHERE adr_ip_time >= $time_up";
$sql = mysql_query($query) or die(mysql_error().'<br>');
while($data = mysql_fetch_assoc($sql))
{
$ipup = $data['num'];
}
// Adresses MIDDLE
$query = "SELECT count(*) AS num FROM adr_ip WHERE adr_ip_time < $time_up AND adr_ip_time >= $time_middle";
$sql = mysql_query($query) or die(mysql_error().'<br>');
while($data = mysql_fetch_assoc($sql))
{
$ipmiddle = $data['num'];
}
// Adresses RED
$query = "SELECT count(*) AS num FROM adr_ip WHERE adr_ip_time < $time_middle AND adr_ip_time >= $time_red";
$sql = mysql_query($query) or die(mysql_error().'<br>');
while($data = mysql_fetch_assoc($sql))
{
$ipred = $data['num'];
}
// Adresses DOWN
$query = "SELECT count(*) AS num FROM adr_ip WHERE adr_ip_time < $time_red";
$sql = mysql_query($query) or die(mysql_error().'<br>');
while($data = mysql_fetch_assoc($sql))
{
$ipdown = $data['num'];
}

 # on peut utiliser une requete SQL pour alimenter le tableau
 $camembert->add_tab( $ipup, "IP UP" );
 $camembert->add_tab( $ipmiddle, "IP MIDDLE" );
 $camembert->add_tab( $ipred, "IP 2 MOIS" );
 $camembert->add_tab( $ipdown, "IP DOWN" );


 #$camembert->trier_tab(); # Facultatif, les donnees sont triees dans l'ordre decroissant
 # $camembert->affiche_tab(); # Debug
 
 # on genere l'image au format PNG
 $camembert->stat2png(3, 15); # 1er argument (2 ou 3 pour la 2D ou la 3D) - 2eme argument hauteur en pixel de l'effet 3D (mettre quelque chose meme pour la 2D)

?>