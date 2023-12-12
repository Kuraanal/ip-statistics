<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Statistiques IP</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="-1">
<link rel="stylesheet" href="theme/style.css">
</head>

<body>
<div id="header">
<?php
if(isset($_SESSION['userconnected']))
{
?>
	<div class="choix_lan">
		<form action="index.php?page=stats&type=lan" method="post">
		Choix d'un reseaux :
		<select name="choixlan">
			<?php
			$c = new database();
			$c->db_connect();
			
			$query = "SELECT * FROM reseaux ORDER BY lan_name ASC";
			$sql = mysql_query($query);
			while($data = mysql_fetch_assoc($sql))
			{
				echo '<option value="'.$data['lan_id'].'">'.$data['lan_name'].' - '.$data['lan_ip'].'</option>';
			}
			
			$c->db_close();
			?>
		</select>
		<input type="submit" value="Changer de reseau.">
		</form>
	</div>
<?php
}
?>
	<ul>
		<?php
		if(isset($_SESSION['userconnected']))
		{
			echo '<a href="index.php"><li>Accueil</li></a><a href="index.php?page=stats"><li>Stats</li></a><a href="index.php?page=admin"><li>Admin</li></a><a href="index.php?login=0"><li>Deco</li></a>';
		}
		?>
	</ul>
</div>
<div id="content">
<?php
if(isset($_SESSION['userconnected']) && $_SESSION['userconnected'] = '1')
{
	if(isset($_GET['page']))
	{
		include('pages/'.$_GET['page'].'.php');
	}
	else include('pages/stats.php');
}
else
{
	echo'	<div class="login">
			<form name=index action="index.php?login=1" method="post">
				<center><font size="4"><u>Connexion</u></font></center><br>
				Login : <input type="text" size="25" name="username"><br>
				Password : <input type="password" size="25" name="password"><br><br>
				<center><input type="submit" value="Connexion"></center>
			</form>
			</div>';
}
?>
</div>
</body>
</html>