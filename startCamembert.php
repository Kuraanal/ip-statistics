<?php
# Camembert 2D/3D - 03/05/2008 - (C)2008 www.Software-DS.com
# Demo en ligne : http://www.software-ds.com/PHP/Camembert-2D-3D/demo-camembert.php

 require("camembert.php"); # on charge la classe camembert
  
 $camembert = new camembert(); # initialisation

 # on peut utiliser une requete SQL pour alimenter le tableau
 $camembert->add_tab( 424, "IP UP" );
 $camembert->add_tab( 4, "IP MIDDLE" );
 $camembert->add_tab( 48, "IP 2 MOIS" );
 $camembert->add_tab( 1814, "IP DOWN" );

 # on genere l'image au format PNG
 $camembert->stat2png(2, 15); # 1er argument (2 ou 3 pour la 2D ou la 3D) - 2eme argument hauteur en pixel de l'effet 3D (mettre quelque chose meme pour la 2D)

?>