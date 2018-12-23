<?php include 'header.php';






echo '<a href="formulaire.php?form=new" class="form_box"><div class="form_new">+</div><div class="form_title_new">Créer un nouveau formulaire</div></a>';

include 'connect.php';
$userid=$_SESSION['userid'];
$result = $db->query("SELECT * FROM formulaires WHERE actif=1 AND owner='$userid' ORDER BY datecreated DESC");
$row_count = $result->rowCount();
echo '<div class="form_list">';
if ($row_count==0){echo 'Vous n\'avez pas encore créé de formulaire';}
while($row = $result->fetch(PDO::FETCH_ASSOC)) {
		echo '<a href="formulaire.php?form='.$row['uniqueid'].'" class="form_box"><div class="form_title">'.$row['titre'].'</div><img src="img/icon_date.svg" class="form_icon"/><div class="form_date">'.datecourtfr($row['datecreated']).'</div></a>';
	
	
	}


echo '</div>';




include 'footer.php';?>