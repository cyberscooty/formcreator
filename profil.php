<?php include 'header.php';

include 'connect.php';
$userid=$_SESSION['userid'];

//--annuler
if(isset($_POST['profil_cancel'])){	header('Location: index.php'); exit();}

//--Retour page principale
if(isset($_POST['back'])){header('Location: index.php'); exit();}

//message
if ($_GET['m']==1){$message=array('message_vert','Votre profil a été mis à jour');}
if ($_GET['m']==2){$message=array('message_rouge','Ancien mot de passe incorrect');}
if ($_GET['m']==3){$message=array('message_rouge','Les mots de passes sont différents');}
if ($_GET['m']==4){$message=array('message_rouge','Le mot de passe est trop court (min 8 caractères)');}
if ($_GET['m']==5){$message=array('message_vert','Le mot de passe a été mis à jour');}
if ($_GET['m']==6){$message=array('message_rouge','Erreur inconnue, le mot de passe n\'a pas été mis à jour');}



//--Valider
if(isset($_POST['profil_submit'])){
	$passhash=$_POST['passhash'];
	$now = date("Y-m-d H:i:s");
	$login=mysql_real_escape_string(trim($_POST['login']));
	$prenom=mysql_real_escape_string(trim($_POST['prenom']));
	$nom=mysql_real_escape_string(trim($_POST['nom']));
	$email=mysql_real_escape_string(trim($_POST['email']));
	$oldpass=mysql_real_escape_string(trim($_POST['oldpass']));
	$newpass1=mysql_real_escape_string(trim($_POST['newpass1']));
	$newpass2=mysql_real_escape_string(trim($_POST['newpass2']));
	$message='';
	

	
	if(strpos($email,'@')==false OR strpos($email,'.')==false){$message=array('message_rouge','L\'adresse email ne semble pas valide');}
	
	if($message==''){	//update profil
				$affected_rows = $db->exec("UPDATE users SET login='$login',prenom='$prenom',nom='$nom',email='$email' WHERE id=$userid");
				$_SESSION['login'] = $login;
				$_SESSION['prenom'] = $prenom;
				$_SESSION['nom'] = $nom;
				$_SESSION['email'] = $email;
				echo 'modif='.$affected_rows;
				if ($affected_rows==1){$m=1;$updated = $db->exec("UPDATE users SET datemodif='$now' WHERE id=$userid");}
		}
	
		
	if($oldpass!=''){ //update mdp
		if(MD5($oldpass)!=$passhash){$m=2;} //verif ancien mdp
		if($newpass1!=$newpass2 AND $message==''){$m=3;} //verif confirmation mdp
		if((int)strlen($newpass1)<8 AND $message==''){$m=4;} //verif longueur mdp
		if($newpass1==$newpass2 AND $message==''){ //update mdp
			$newpass=MD5($newpass1);
			$modifmdp = $db->exec("UPDATE users SET passhash='$newpass',datemodif='$now' WHERE id=$userid");
			if ($modifmdp=1){$m=5;}else {$m=5;}
			
		}
			
	}

	
	
}

if ($m!=''){header('Location: profil.php?m='.$m); exit();}

if (isset($message)) echo '<div class="erreurlogin margin_bottom '.$message[0].' align_center">'.$message[1].'</div>';


include 'connect.php';
$userid=$_SESSION['userid'];
$result = $db->query("SELECT * FROM users WHERE id=$userid");
while($row = $result->fetch(PDO::FETCH_ASSOC)) {$login=$row['login'];$prenom=$row['prenom'];$nom=$row['nom'];$email=$row['email'];$passhash=$row['passhash'];}




echo '<div class="question_box align_center">';
echo '<div class="form_titre">Mon profil</div>';
echo '<form action="profil.php" method="post">';

echo '<div class="send_mini_title">Login</div>';
echo '<input name="login" class="values_default type1 align_center" type="text" value="'.$login.'" required>';
echo '<div class="send_mini_title">Prénom</div>';
echo '<input name="prenom" class="values_default type1 align_center" type="text" value="'.ucfirst($prenom).'" required>';
echo '<div class="send_mini_title">Nom</div>';
echo '<input name="nom" class="values_default type1 align_center" type="text" value="'.mb_strtoupper($nom).'" required>';

echo '<div class="form_titre subtitle">Email</div>';
echo '<input name="email" class="values_default type1 align_center" type="text" value="'.$email.'" required>';

echo '<div class="form_titre subtitle">Changer mon mot de passe</div>';
echo '<div class="send_mini_title">Ancien mot de passe</div>';
echo '<input name="oldpass" class="values_default type1 align_center" type="password" value="">';
echo '<div class="send_mini_title">Nouveau mot de passe</div>';
echo '<input name="newpass1" class="values_default type1 align_center" type="password" value="">';
echo '<div class="send_mini_title">Confirmation</div>';
echo '<input name="newpass2" class="values_default type1 align_center" type="password" value="">';

echo '<input name="passhash" type="hidden" value="'.$passhash.'">';




echo '<div class="centrer align_center margin_top margin_bottom">';
echo '<input type="submit" class="bouton margin_right" name="profil_submit" value="Valider"><input type="submit" class="bouton" name="profil_cancel" value="Annuler">';
echo '</div></div>';
echo '<input type="submit" class="bt_hautgauche" name="back" value="" title="Retour page principale">';
echo '</form>';



include 'footer.php';?>