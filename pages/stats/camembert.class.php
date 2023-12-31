<?php
# Camembert 2D/3D - 03/05/2008
# Auteur : Didier STRAUS (C)2008 www.Software-DS.com
# Description: Cree une image PNG en camembert a partir des donnees fournies.
# Demo en ligne : http://www.software-ds.com/PHP/Camembert-2D-3D/demo-camembert.php

class camembert {
 var $dim;  # dim de position dans le tableau
 var $tabVal; # tableau des valeurs
 var $tabNom; # tableau des noms
 var $tot;    # total des valeurs

### camembert : constructeur / initialisation
 function camembert() {
  $this->dim = 0;
  $this->tot = 0;
  
  $this->tabVal=array();
  $this->tabNom=array();
 } # fin camembert


### add_tab : ajoute une donnee au tableau (valeur + libelle)
 function add_tab($val, $nom) {
//  if ($val >= 0) {
   $this->tabVal[$this->dim] = $val;
   $this->tabNom[$this->dim] = $nom;
   $this->tot = $this->tot + $val; # calcul du total
   $this->dim++; # MAJ de l'dim
//  }
 } # fin add_tab


### trier_tab : trie le tableau par ordre decroissant
 function trier_tab() {
  if ($this->dim > 1) { # tri necessaire ?
  
   for($i=0;$i<$this->dim-1;$i++) {
    $maxi = $this->tabVal[$i];

    for($j=$i+1;$j<$this->dim;$j++) {
     if ($maxi < $this->tabVal[$j]) { # on echange les positions dans le tableau
      $maxi  = $this->tabVal[$j];
      $inter = $this->tabNom[$j];
      
      $this->tabVal[$j] = $this->tabVal[$i];
      $this->tabNom[$j] = $this->tabNom[$i];

      $this->tabVal[$i] = $maxi;
      $this->tabNom[$i] = $inter;      
     }
    } # for j 
   } # for i
  } # if
 } # fin trier_tab


### affiche_tab : affiche les donnees du tableau, utile pour utile Debug
 function affiche_tab() {
  for($i=0; $i<$this->dim; $i++) {
   echo $this->tabNom[$i].' '.$this->tabVal[$i].'<br />';
  } # for
 } # fin affiche_tab
 

### stat2png : genere une image camembert au format PNG
 function stat2png($mode, $hauteur_effet_3D) {
  $width       = 400; # largeur de l'image
  $height      = 260; # hauteur de l'image
  $centre_x    = 125; # poisition X du centre du camembert
  $centre_y    = 110; # poisition Y du centre du camembert
  $cam_largeur = 250; # largeur du camembert
  $cam_hauteur = 210; # hauteur du camembert

  # declaration/initialisation de l'image
  $img = imagecreatetruecolor($width, $height) or die("Probleme : Chargement de la lib GD impossible");

  # declaration des couleurs
  $noir  = imagecolorallocate($img,0,0,0);
  $vert  = imagecolorallocate($img,90,160,90);
  $blanc = imagecolorallocate($img,255,255,255);

  ImageFill( $img, 0, 0, $blanc ); # couleur de fond de l'image (blanc)
  
  if ($mode<>2 && $mode<>3) { # controle du mode
   $mode = 2;
  }
  
  if ($mode == 2) {
   $cam_largeur = $cam_hauteur; # pour la 2D on veut un cercle et pas une ellipse
  }
  
  $tot_angle = -90; # on commence a afficher les donnees a partir de midi

  # variables pour generer les couleurs du camembert
  $v2 = 185;
  $v1 = 75;
  $c  = 0;
  
  for($i=0; $i<$this->dim; $i++) { # pour chaque morceau du camembert, on calcul la couleur et les angles
   
   # on genere une couleur differente a chaque iteration et on la memorise
   if ($c==0) {
    $tab_couleurs[$i][0][0] = $v1; # R
    $tab_couleurs[$i][0][1] = $v2; # G
    $tab_couleurs[$i][0][2] = $v2; # B
   }
   else if ($c==1) {
    $tab_couleurs[$i][0][0] = $v2; # R
    $tab_couleurs[$i][0][1] = $v1; # G
    $tab_couleurs[$i][0][2] = $v2; # B
   }
   else if ($c==2) {
    $tab_couleurs[$i][0][0] = $v2; # R
    $tab_couleurs[$i][0][1] = $v2; # G
    $tab_couleurs[$i][0][2] = $v1; # B
   }
   
   $c++;
   # calcul complexe pour changer de couleur
   if ($c==3) {
    $c   = 0;
    $v1 += 60;
    $v2 -= 40;
    
	if (abs($v1-$v2) < 40) {
     $v1 += 30;
     $v2 -= 30;
    } # if
   } # if

   # on assombrit la couleur et on la memorise
   $dark = 55; # modifier cette valeur pour modifier l'assombrissement des couleurs

   for($k=0; $k<3; $k++) { # R G B
 
    if ($tab_couleurs[$i][0][$k] - $dark > 0)
     $tab_couleurs[$i][1][$k] = $tab_couleurs[$i][0][$k] - $dark;
    else
     $tab_couleurs[$i][1][$k] = 0;

   } # for($k=0; k<3; k++)

   # on calcul et memorise l'angle
   $tab_angle[$i] = $tot_angle;
   $angle = ($this->tabVal[$i] * 360) / $this->tot;
   $tot_angle += $angle;

  } # for($i=0; $i<$this->dim; $i++)

  $tab_angle[$this->dim] = $tot_angle; # on n'oublie pas de memoriser le dernier angle ;)


  # on peut commencer a afficher les morceaux de camemberts
   
  if ($mode == 3) { # Effet 3D
      
   for($k=$centre_y + $hauteur_effet_3D; $k > $centre_y; $k--) { # pour avoir un effet 3D de 10 pixels

    for($i=0; $i<$this->dim; $i++) { # pour chaque morceau du camembert
         
     # creation de la couleur sombre
     $color = imagecolorallocate( $img, $tab_couleurs[$i][1][0], $tab_couleurs[$i][1][1], $tab_couleurs[$i][1][2] ); # R G B
       
	 # on affiche le morceau de camembert
     imagefilledarc($img, $centre_x, $k, $cam_largeur, $cam_hauteur, $tab_angle[$i], $tab_angle[$i+1], $color, IMG_ARC_PIE);

    } # for($i=0; $i<$this->dim; $i++)

   } # for($k=120; $k>110; $k--)

  } # if ($mode == 3)


  # on affiche les morceaux "clairs" du camembert (partie commune 2D/3D)
  for($i=0; $i<$this->dim; $i++) { # pour chaque morceau du camembert
 
   # creation de la couleur claire
   $color = imagecolorallocate( $img, $tab_couleurs[$i][0][0], $tab_couleurs[$i][0][1], $tab_couleurs[$i][0][2] ); # R G B
   
   # on affiche le morceau de camembert
   imagefilledarc($img, $centre_x, $centre_y, $cam_largeur, $cam_hauteur, $tab_angle[$i], $tab_angle[$i+1], $color, IMG_ARC_PIE);
   
   #  on affiche la legende
   $x = 250;
   $y = 15 + $i*16;
   imagefilledrectangle($img, $x, $y, $x+9, $y+9, $color); # petit carre de couleur
   imagestring($img, 2, $x+15, $y-2, $this->tabNom[$i]. ' ('.floor(($this->tabVal[$i] * 100) / $this->tot).'%) - '.$this->tabVal[$i], $noir); # texte

  } # for($i=0; $i<$this->dim; $i++)

   
  # finalisation de l'image
  
  imagestring( $img, 2, 250, 195, 'Total des IP : '.$this->tot, $vert); # vous pouvez mettre votre site internet

  header("Content-type: image/png"); # declaration du Header, pour pouvoir afficher l'image
  imagepng($img);     # creation de l'image
  imagedestroy($img); # nettoyage des ressources
 } # fin stat2png


} # fin de la classe camembert
?>
