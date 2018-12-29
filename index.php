<?php include 'header.php';


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
echo '<a href="formulaire.php?form=new" class="form_box"><div class="form_new">+</div><div class="form_title_new">Créer un nouveau formulaire</div></a>';

//--affiche formulaires de l'utilisateur
include 'connect.php';
$userid=$_SESSION['userid'];
$result = $db->query("SELECT * FROM formulaires WHERE actif=1 AND owner='$userid' ORDER BY datecreated DESC");
$row_count = $result->rowCount();
echo '<div class="form_list">';
if ($row_count==0){echo 'Vous n\'avez pas encore créé de formulaire';}
while($row = $result->fetch(PDO::FETCH_ASSOC)) {
		echo '<a href="formulaire.php?form='.$row['uniqueid'].'" class="form_box"><div class="form_title">'.$row['titre'].'</div><img src="img/icon_date.svg" class="form_icon"/><div class="form_date">'.datecourtfr($row['datecreated']).'</div>';
		echo '<form action="index.php" class="delete_form" method="post">';
		echo '<input type="submit" value="suppr_form" name="suppr_form'.$row['id'].'" title="Supprimer ce formulaire" class="question_options form_options1">';
		
		echo '</form>';
		
		echo '</a>';
	
	
	}


echo '</div>';




include 'footer.php';?>