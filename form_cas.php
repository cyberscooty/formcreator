<?php


//--check avant ouverture
	//récupère uniqueid si existe
	$uniqueid=mysql_real_escape_string(trim($_GET['form']));
	if ($uniqueid==''){$uniqueid=$_POST['uniqueid'];}

	//check uniqueid n'est pas vide
	if ($uniqueid=='') {header('Location: index.php'); exit();}

	//création nouveau formulaire
	if ($uniqueid=='new'){
		$uniqueid=(date('z')*2).date('y').str_replace('.','',uniqid('f',TRUE));
		$titre='Formulaire sans titre';
		$now = date("Y-m-d H:i:s");
		$userid=$_SESSION['userid'];
		include 'connect.php';
		$result = $db->exec("INSERT INTO formulaires(uniqueid, titre,owner,datecreated,actif) VALUES('$uniqueid', '$titre','$userid','$now',1)");
	}
	
	//création Exemple 1
	if ($uniqueid=='new_expl1'){
		$uniqueid=(date('z')*2).date('y').str_replace('.','',uniqid('f',TRUE));
		$titre='Formulaire sans titre';
		$now = date("Y-m-d H:i:s");
		$userid=$_SESSION['userid'];
		include 'connect.php';
		$result = $db->exec("INSERT INTO formulaires(uniqueid, titre,owner,datecreated,actif) VALUES('$uniqueid', '$titre','$userid','$now',1)");
		$lastId = $db->lastInsertId();
		$result = $db->exec("INSERT INTO questions(form_id,titre,type,is_required,position,datecreated) VALUES('$lastId','Identification','0','0','2','$now')");
		$result = $db->exec("INSERT INTO questions(form_id,titre,type,is_required,position,datecreated) VALUES('$lastId','Votre email','1','1','4','$now')");
		$result = $db->exec("INSERT INTO questions(form_id,titre,type,is_required,position,datecreated) VALUES('$lastId','Vos impressions','0','0','6','$now')");
		$result = $db->exec("INSERT INTO questions(form_id,titre,type,is_required,position,datecreated) VALUES('$lastId','Quelle note attribueriez vous à la présentation en général','6','0','8','$now')");
		$qid1 = $db->lastInsertId();
		$result = $db->exec("INSERT INTO questions(form_id,titre,type,is_required,position,datecreated) VALUES('$lastId','Qu\'avez vous préféré?','4','0','10','$now')");
		$qid2 = $db->lastInsertId();
		$result = $db->exec("INSERT INTO questions(form_id,titre,type,is_required,position,datecreated) VALUES('$lastId','Conseillerez vous ce produit à un ami','5','0','12','$now')");
		$qid3 = $db->lastInsertId();
		$result = $db->exec("INSERT INTO questions(form_id,titre,type,is_required,position,datecreated) VALUES('$lastId','Une remarque sur cette présentation?','2','0','14','$now')");
		
		$result = $db->exec("INSERT INTO data(question_id,valeur,is_secondary,datecreated) VALUES('$qid1','1','1','$now')");
		$result = $db->exec("INSERT INTO data(question_id,valeur,is_secondary,datecreated) VALUES('$qid1','10','1','$now')");
		$result = $db->exec("INSERT INTO data(question_id,valeur,is_secondary,datecreated) VALUES('$qid2','Le film promotionnel','0','$now')");
		$result = $db->exec("INSERT INTO data(question_id,valeur,is_secondary,datecreated) VALUES('$qid2','Le diaporama de présentation','0','$now')");
		$result = $db->exec("INSERT INTO data(question_id,valeur,is_secondary,datecreated) VALUES('$qid2','De pouvoir essayer le produit','0','$now')");
		$result = $db->exec("INSERT INTO data(question_id,valeur,is_secondary,datecreated) VALUES('$qid3','-- sélectionnez une réponse --','0','$now')");
		$result = $db->exec("INSERT INTO data(question_id,valeur,is_secondary,datecreated) VALUES('$qid3','oui probalement','0','$now')");
		$result = $db->exec("INSERT INTO data(question_id,valeur,is_secondary,datecreated) VALUES('$qid3','non surement pas','0','$now')");
		$result = $db->exec("INSERT INTO data(question_id,valeur,is_secondary,datecreated) VALUES('$qid3','je ne suis pas encore sûr','0','$now')");
		
	}
	

	//check si uniqueid existe
	include 'connect.php';
	$result = $db->query("SELECT * FROM formulaires WHERE uniqueid='$uniqueid'");
	$row_count = $result->rowCount();
	if ($row_count==0){header('Location: index.php'); exit();}
	//--recup valeurs table
	while($row = $result->fetch(PDO::FETCH_ASSOC)) {$form_id=$row['id'];$form_titre=$row['titre'];$form_description=$row['description'];$couleur=$row['couleur'];$background=$row['background'];
												$reponses_possibles=$row['reponses_possibles'];$datecreated=$row['datecreated'];$datemodif=$row['datemodif'];}

$mustsave=0;


//--recherche position max
	$result = $db->query("SELECT MAX(position) AS posmax FROM questions WHERE form_id='$form_id' ORDER BY position ASC");
	while($row = $result->fetch(PDO::FETCH_ASSOC)) {$posmax=$row['posmax'];}



//--Supprime valeur
	$result = $db->query("SELECT data.id AS data_id FROM data,questions WHERE questions.form_id=$form_id AND questions.id=data.question_id");
	while($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$data_id=$row['data_id'];
		if($_POST['suppr'.$data_id]=='+'){$affected_rows = $db->exec("DELETE FROM data WHERE id=$data_id");$mustsave=1;}
	}

//--Supprime question
	$result = $db->query("SELECT id FROM questions WHERE form_id=$form_id");
	while($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$qid=$row['id'];
		if($_POST['suppr_question'.$qid]=='suppr_question'){$affected_rows = $db->exec("DELETE FROM questions WHERE id=$qid");$mustsave=1;}
		
	}



//--Monter / Descendre
$result = $db->query("SELECT id,position FROM questions WHERE form_id=$form_id");
	while($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$qid=$row['id'];
		$position=(int)$row['position'];
		if($_POST['monter'.$qid]=='monter'){$mustsave=2;$position=$position-3;}
		if($_POST['descendre'.$qid]=='descendre'){$mustsave=2;$position=$position+3;}
		
		if ($mustsave==2){$affected_rows = $db->exec("UPDATE questions SET position='$position' WHERE id=$qid");$mustsave=$mustsave-1;$recalcul_pos=1;}
		
	}	


//--recalcul positions
	if ($recalcul_pos==1){
		$result = $db->query("SELECT id FROM questions WHERE form_id=$form_id ORDER BY position ASC");
		$newpos=0;
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$qid=$row['id'];
			$newpos=$newpos+2;
			$affected_rows = $db->exec("UPDATE questions SET position='$newpos' WHERE id=$qid");
			
		}
	}




	
//--Enregistre modif
if(isset($_POST['ok']) || isset($_POST['add_question']) || isset($_POST['add_titre']) || $mustsave>0 || isset($_POST['back']) || isset($_POST['view']) || isset($_POST['results']) 
	|| isset($_POST['envoyer']) || isset($_POST['paint'])){
	
	
	
	$modif=0;
	$now = date("Y-m-d H:i:s");
	include 'connect.php';
	
	//--Enregistre modif formulaire
	$form_titre=mysql_real_escape_string(trim($_POST['form_titre']));
	$form_description=mysql_real_escape_string(trim($_POST['form_description']));
	$affected_rows = $db->exec("UPDATE formulaires SET titre='$form_titre',description='$form_description',datemodif='$now' WHERE id=$form_id");
	$modif=$modif+$affected_rows;
	
	//--Enregistre modif questions
	$result = $db->query("SELECT id FROM questions WHERE form_id='$form_id'");
	while($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$id=$row['id'];
		$type=$_POST['type'.$id];
		$is_required=$_POST['required'.$id];
		$titre=mysql_real_escape_string(trim($_POST['quest_titre'.$id]));
		$description=$_POST['quest_descr'.$id];
		$affected_rows = $db->exec("UPDATE questions SET titre='$titre',description='$description',type='$type',is_required='$is_required',datemodified='$now' WHERE id=$id");
		$modif=$modif+$affected_rows;
			
	}
	
	
	
	//--Enregistre modif datas
		$result = $db->query("SELECT data.id AS data_id FROM data,questions WHERE questions.form_id=$form_id AND questions.id=data.question_id");
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$data_id=$row['data_id'];
			$valeur=$_POST['champ'.$data_id];
			if($valeur!=''){$affected_rows = $db->exec("UPDATE data SET valeur='$valeur',datemodified='$now' WHERE id=$data_id");}
			$modif=$modif+$affected_rows;
			
			}
		
	//--Ajoute nouvelles valeurs (doit être à la fin)
		$result = $db->query("SELECT id FROM questions WHERE form_id='$form_id'");
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$id=$row['id'];
			$qid=$row['id'];
			$type=$_POST['type'.$id];
			$radionew=mysql_real_escape_string(trim($_POST['radionew'.$id]));
			$chknew=mysql_real_escape_string(trim($_POST['chknew'.$id]));
			$listnew=mysql_real_escape_string(trim($_POST['listnew'.$id]));
			$numA=$_POST['numA'.$id];
			$numB=$_POST['numB'.$id];
						
			if ($type==6){
				$maxid=$_POST['maxid'.$qid];
				$minid=$_POST['minid'.$id];
				$min=$_POST['min'.$qid];
				$max=$_POST['max'.$qid];
					$affected_rows = $db->exec("UPDATE data SET valeur='$min',datemodified='$now' WHERE id=$minid");$modif=$modif+$affected_rows;
					$affected_rows = $db->exec("UPDATE data SET valeur='$max',datemodified='$now' WHERE id=$maxid");$modif=$modif+$affected_rows;
					
			}
			
			
			
		if ($radionew!=''){$addnewvalue = $db->exec("INSERT INTO data(question_id, valeur,is_secondary,datecreated) VALUES('$id', '$radionew',0,'$now')");$modif=$modif+$addnewvalue;}
		if ($chknew!=''){$addnewvalue = $db->exec("INSERT INTO data(question_id, valeur,is_secondary,datecreated) VALUES('$id', '$chknew',0,'$now')");$modif=$modif+$addnewvalue;}
		if ($listnew!=''){$addnewvalue = $db->exec("INSERT INTO data(question_id, valeur,is_secondary,datecreated) VALUES('$id', '$listnew',0,'$now')");$modif=$modif+$addnewvalue;}
		}
	
	
	echo '<div class="save_ok">Les modifications ont été enregistrées</div>';
	
	}



//--Ajouter question
if(isset($_POST['add_question'])){
	$now = date("Y-m-d H:i:s");
	include 'connect.php';
	$position=$posmax+2;
	$result = $db->exec("INSERT INTO questions(form_id, titre,datecreated,type,position) VALUES($form_id,'Question sans titre', '$now',3,$position)");
	header('Location: formulaire.php?form='.$uniqueid.'#bottom'); exit();}
	
	
	
//--Ajouter titre
if(isset($_POST['add_titre'])){
	$now = date("Y-m-d H:i:s");
	$position=$posmax+2;
	include 'connect.php';
	$result = $db->exec("INSERT INTO questions(form_id, titre,datecreated,type,position) VALUES($form_id,'Titre', '$now',0,$position)");
	header('Location: formulaire.php?form='.$uniqueid.'#bottom'); exit();
	}


//--Retour page principale
if(isset($_POST['back'])){header('Location: index.php'); exit();}

//--view results
if(isset($_POST['results'])){
?>
	<script type="text/javascript">window.open('results.php?form=<?php echo $uniqueid;?>');</script>
	<?php


}	
	
//--Aperçu formulaire
if(isset($_POST['view'])){
	?>
	<script type="text/javascript">window.open('formulaireview.php?form=<?php echo $uniqueid;?>');</script>
	<?php
	}

	
//--envoi formulaire
if(isset($_POST['envoyer'])){
echo '<div class="blackbox"></div>';
echo '<div class="send_box align_center">';
echo '<div class="send_title_box"><div class="send_title align_center">Envoyer le formulaire</div></div>';
echo '<input type="radio" id="type_lien" name="sendtype" class="select_type_send" value="lien" checked><label for="type_lien">Envoyer le lien</label>
	<input type="radio" id="type_mail" class="select_type_send" name="sendtype" value="mail"><label for="type_mail">Envoyer par e-mail</label>
		';
		
		$link=substr(strtolower(dirname($_SERVER['SERVER_PROTOCOL']) . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']),0,-14);
		$link=$link.'formulaireview.php?form='.$uniqueid;
		

echo '<div class="send_per_link"><div class="lienform">'.$link.'</div></div>';		
echo '<div class="send_per_mail">';

echo '<form action="formulaire.php" class="form_send" method="post">';




$subject='[FormCreator] '.$form_titre;
$msg=ucfirst($_SESSION['prenom']).' '.mb_strtoupper($_SESSION['nom']).' vous invite à répondre à remplir un formulaire';

echo '<div class="send_mini_title">Destinataire</div>';
echo '<input type="text" class="send_text" name="to" value="" placeholder="email@domaine.com" required>';
echo '<div class="send_mini_title">Sujet</div>';
echo '<input type="text" class="send_text" name="subject" value="'.$subject.'">';
echo '<div class="send_mini_title">Message</div>';
echo '<div class="send_body">';
echo '<input type="text" class="send_text margin_top" name="body" value="'.$msg.'">';
echo '<div class="send_lien">Cliquer sur le lien pour accéder au formulaire :<br>'.$link.'</div>';
echo '</div></div>';
echo '
		<input type="hidden" name="uniqueid" value="'.$uniqueid.'">
		<input type="submit" class="bouton margin_right" name="send_link" value="Envoyer"><input type="submit" class="bouton" name="" value="Annuler">
		</form>';

echo '</div>';

	
}

	
	
//--envoi du mail
if(isset($_POST['send_link'])){
	$to=mysql_real_escape_string(trim($_POST['to']));
	$subject=utf8_decode(mysql_real_escape_string(trim($_POST['subject'])));
	$body=mysql_real_escape_string(trim($_POST['body']));
	$link=substr(strtolower(dirname($_SERVER['SERVER_PROTOCOL']) . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']),0,-14);
	$link=$link.'formulaireview.php?form='.$uniqueid;
	
	if($body){$msg='<p>'.$body.'</p>';}
	$msg=$msg.'<p>Cliquer sur le lien pour accéder au formulaire :</p><p><a href="'.$link.'">'.$link.'</a>';
	$msg = wordwrap($msg,70);
	$headers="From: FormCreator@noreply.local \n"; 
	$headers.= "MIME-version: 1.0\n"; 
	$headers.= "Content-type: text/html; charset= UTF-8\n"; 
	mail($to,$subject,$msg,$headers);
	$erreur=array('message_vert','Email envoyé, consultez votre boîte aux lettres');
	echo '<div class="save_ok">Un mail d\'invitation a été envoyé</div>';
	
}	
	
//--personnaliser
if (isset($_POST['paint'])){
	
	echo '<div class="blackbox"></div>';
echo '<div class="send_box align_center">';
echo '<div class="send_title_box"><div class="send_title align_center">Personnalisation du formulaire</div></div>';
echo '<form action="formulaire.php" method="post">';	
echo '<input type="submit" class="bouton" name="" value="Annuler">';	
echo '</form>';	
echo '</div>';	
	
}
	
	
	
	
	
	
	
	



?>