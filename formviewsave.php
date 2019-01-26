<?php
include 'header.php';
//--Retour page principale
if(isset($_POST['back'])){
	?>
	<script>window.close();</script>
	<?php
	}



	//couleur formulaire et wallpaper
	$wallaper=base64_decode($_GET['w']);
	$couleur=$_GET['c'];
	if ($wallaper==''){$wallaper='nature1.jpg';}
	echo '<style>:root {--main-color:#'.$colors[$couleur].'}#wallpaper {background: url(wallpapers/'.$wallaper.');background-size: cover;}</style>';


$form_id=$_POST['form_id'];
$now = date("Y-m-d H:i:s");
$user_id=$_SESSION['userid'];
if($user_id==''){$user_id=0;}


if ($form_id!=''){ //prevent resubmitting

	//recup personalisation formulaire
	include 'connect.php';
	$result = $db->query("SELECT * FROM formulaires WHERE id='$form_id'");
	while($row = $result->fetch(PDO::FETCH_ASSOC)) {$couleur=$row['couleur'];$wallaper=$row['background'];}





include 'connect.php';
$result = $db->query("SELECT * FROM questions WHERE form_id=$form_id");

while($row = $result->fetch(PDO::FETCH_ASSOC)) {
	$type=$row['type'];
	$qid=$row['id'];

	
	if($type==1 || $type==2 || $type==3 || $type==5 || $type==6 || $type==9 || $type==10){
		$resultat=mysql_real_escape_string(trim($_POST['champ'.$qid]));
		include 'connect.php';
		$save_result = $db->exec("INSERT INTO reponses(question_id,valeur, user_id,datesubmitted) VALUES('$qid','$resultat','$user_id','$now')");
		}
		
	if($type==4){
	$result2 = $db->query("SELECT * FROM data WHERE question_id='$qid' AND is_secondary=0");
		while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
		$vid=$row2[id];
		if ($_POST['checkbox'.$vid]==1){$save_result = $db->exec("INSERT INTO reponses(question_id,valeur, user_id,datesubmitted) VALUES('$qid','$vid','$user_id','$now')");}
		}
	}
}

//prevent resubmitting - redirect to the same page
header('Location: formviewsave.php?c='.$couleur.'&w='.base64_encode($wallaper)); exit(); 

}

echo '<div class="merci">Merci de votre participation, vos réponses ont été enregistrées</div>';
echo '<form action="formviewsave.php" class="one_formulaire" method="post">';
echo '<input type="submit" class="bouton bt_valid" name="back" value="Fermer cette fenêtre">';
echo '</form>';








include 'footer.php';?>

