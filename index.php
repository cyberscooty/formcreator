<?php include 'header.php';


echo '<style>#wallpaper {background: url(img/index_wallpaper.jpg);background-size: cover;}#main{background: none;}</style>';

//--désactive formulaire
include 'connect.php';
$now = date("Y-m-d H:i:s");
$userid=$_SESSION['userid'];
$result = $db->query("SELECT id FROM formulaires WHERE actif=1 AND owner='$userid'");
while($row = $result->fetch(PDO::FETCH_ASSOC)) {
	$fid=$row['id'];
	if ($_POST['suppr_form'.$fid]=='suppr_form'){$affected_rows = $db->exec("UPDATE formulaires SET datemodif='$now',actif=0 WHERE id=$fid");}
}





//--ajout nouveau formulaire
echo '<div class="newform">';
echo '<div class="listform_title">Créer un formulaire</div>';
echo '<a href="formulaire.php?form=new" class="form_box"><div class="form_new">+</div><div class="form_title_new">Créer un nouveau formulaire vide</div></a>';



echo '<a href="formulaire.php?form=new_expl1" class="form_box"><div class="form_title">Qu\'avez vous pensé de la présentation?</div><div class="form_title_new">Créer un formulaire d\'après un exemple</div></a>';
echo '</div>';

//--affiche formulaires de l'utilisateur
echo '<div class="listform_title">Vos formulaires</div>';
include 'connect.php';
$userid=$_SESSION['userid'];
$result = $db->query("SELECT * FROM formulaires WHERE actif=1 AND owner='$userid' ORDER BY datecreated DESC");
$row_count = $result->rowCount();
echo '<div class="form_list">';
if ($row_count==0){echo 'Vous n\'avez pas encore créé de formulaire';}
while($row = $result->fetch(PDO::FETCH_ASSOC)) {
	
		$description=$row['description'];
		$couleur=(int)$row['couleur'];
		$wallpaper=$row['background'];
		$maxlength=90;
		if ($wallpaper==''){$wallpaper='nature1.jpg';}
		if (strlen($description)>$maxlength){$description=substr($description,0,$maxlength).'...';}
		
		echo '<style>#form_box'.$row['id'].'{background: url(wallpapers/'.$wallpaper.');background-size: cover;}</style>';
		
		echo '<a href="formulaire.php?form='.$row['uniqueid'].'" class="form_box" id="form_box'.$row['id'].'"><div class="form_title">'.$row['titre'].'</div><img src="img/icon_date.svg" class="form_icon"/><div class="form_date">'.datecourtfr($row['datecreated']).'</div>';
		echo '<div class="form_coul" class="form_coul" style="background:#'.$colors[$couleur].'"></div>';
	
		echo '<div class="wallpaper_plus_clair"></div>';
		echo '<div class="form_descr" title="'.$row['description'].'">'.stripcslashes($description).'</div>';
		echo '<form action="index.php" class="delete_form" method="post">';
		echo '<input type="submit" value="suppr_form" name="suppr_form'.$row['id'].'" title="Supprimer ce formulaire" class="question_options form_options1">';
		
		echo '</form>';
		
		echo '</a>';
	
	
	}


echo '</div>';




include 'footer.php';?>