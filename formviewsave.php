<?php
include 'header.php';
//--Retour page principale
if(isset($_POST['back'])){
	//header('Location: index.php'); exit();
	?>
	
	<script>window.close();</script>
	
	<?php
	
	
	}






$form_id=$_POST['form_id'];
$now = date("Y-m-d H:i:s");
$user_id=$_SESSION['userid'];
if($user_id==''){$user_id=0;}

include 'connect.php';
$result = $db->query("SELECT * FROM questions WHERE form_id=$form_id");

while($row = $result->fetch(PDO::FETCH_ASSOC)) {
	$type=$row['type'];
	$qid=$row['id'];

	
	if($type==1 || $type==2 || $type==3){
		//echo '$type==1 || $type==2 || $type==3';
		
		$resultat=mysql_real_escape_string(trim($_POST['champ'.$qid]));
		//echo "$qid - $resultat - $user_id - $now";
		
		include 'connect.php';
		$save_result = $db->exec("INSERT INTO reponses(question_id,valeur, user_id,datesubmitted) VALUES('$qid','$resultat','$user_id','$now')");
		
		}
	
	
	//#########################
	//Reste à faire : enregistre type 4-5-6-etc...
	//#########################
	
	
	
}


echo '<div class="merci">Merci de votre participation, vos réponses ont été enregistrées</div>';
echo '<form action="formviewsave.php" class="one_formulaire" method="post">';
echo '<input type="submit" class="bouton bt_valid" name="back" value="Fermer cette fenêtre">';
echo '</form>';











?>