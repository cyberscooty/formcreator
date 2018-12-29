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

	//check si uniqueid existe
	include 'connect.php';
	$result = $db->query("SELECT * FROM formulaires WHERE uniqueid='$uniqueid'");
	$row_count = $result->rowCount();
	if ($row_count==0){header('Location: index.php'); exit();}
	//--recup valeurs table
	while($row = $result->fetch(PDO::FETCH_ASSOC)) {$form_id=$row['id'];$form_titre=$row['titre'];$form_description=$row['description'];$couleur=$row['couleur'];$background=$row['background'];
												$reponses_possibles=$row['reponses_possibles'];$datecreated=$row['datecreated'];$datemodif=$row['datemodif'];}

$mustsave=0;


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
	
//--Enregistre modif
if(isset($_POST['ok']) || isset($_POST['add_question']) || isset($_POST['add_titre']) || $mustsave==1 || isset($_POST['back'])){
	$modif=0;
	include 'connect.php';
	
	//--Enregistre modif formulaire
	$form_titre=mysql_real_escape_string(trim($_POST['form_titre']));
	$form_description=mysql_real_escape_string(trim($_POST['form_description']));
	$affected_rows = $db->exec("UPDATE formulaires SET titre='$form_titre',description='$form_description' WHERE id=$form_id");
	$modif=$modif+$affected_rows;
	
	//--Enregistre modif questions
	$result = $db->query("SELECT id FROM questions WHERE form_id='$form_id'");
	while($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$id=$row['id'];
		$type=$_POST['type'.$id];
		$titre=mysql_real_escape_string(trim($_POST['quest_titre'.$id]));
		$description=$_POST['quest_descr'.$id];
		$affected_rows = $db->exec("UPDATE questions SET titre='$titre',description='$description',type='$type' WHERE id=$id");
		$modif=$modif+$affected_rows;
			
	}
	
	
	
	//--Enregistre modif datas
		$result = $db->query("SELECT data.id AS data_id FROM data,questions WHERE questions.form_id=$form_id AND questions.id=data.question_id");
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$data_id=$row['data_id'];
			$valeur=$_POST['champ'.$data_id];
			if($valeur!=''){$affected_rows = $db->exec("UPDATE data SET valeur='$valeur' WHERE id=$data_id");}
			$modif=$modif+$affected_rows;
			
			}
		
	//--Ajoute nouvelles valeurs (doit être à la fin)
		$result = $db->query("SELECT id FROM questions WHERE form_id='$form_id'");
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$id=$row['id'];
			$type=$_POST['type'.$id];
			$radionew=mysql_real_escape_string(trim($_POST['radionew'.$id]));
			$chknew=mysql_real_escape_string(trim($_POST['chknew'.$id]));
			$listnew=mysql_real_escape_string(trim($_POST['listnew'.$id]));
			$numA=$_POST['numA'.$id];
			$numB=$_POST['numB'.$id];
			$now = date("Y-m-d H:i:s");
			
			if ($type==6){}//verifie si déjà une valeur -> UPDATE sinon INSERT
			
			
			
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
	$result = $db->exec("INSERT INTO questions(form_id, titre,datecreated,type) VALUES($form_id,'Question sans titre', '$now',3)");
	header('Location: formulaire.php?form='.$uniqueid.'#bottom'); exit();}
	
	
	
//--Ajouter titre
if(isset($_POST['add_titre'])){echo 'add titre';}


//--Retour page principale
if(isset($_POST['back'])){header('Location: index.php'); exit();}	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	



?>