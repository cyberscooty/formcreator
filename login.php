<?php
include 'header2.php';
$create_account=0;
$mdpoublie=0;
//--check login
if ($_POST['login']!='' && $_POST['mdp']!='' && !isset($_POST['mdpoublie']) && !isset($_POST['pasdecompte'])) {
	
	$login=mysql_real_escape_string(trim($_POST['login']));
	$mdp=md5(trim($_POST['mdp']));
	include 'connect.php';
	$result = $db->query("SELECT * FROM users WHERE login='$login' AND passhash='$mdp' AND actif>0");
	$row_count = $result->rowCount();
	
	if ($row_count==1){
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$_SESSION['login'] = $row['login'];
			$_SESSION['prenom'] = $row['prenom'];
			$_SESSION['nom'] = $row['nom'];
			$_SESSION['email'] = $row['email'];
			$_SESSION['sessionid']='kjFK_69kA5+k47gv-DG&ik';
			
			header('Location: index.php'); exit();
		}		
	}
	else{$erreur='Compte non reconnu';}
}


//--pas encore de compte
if (isset($_POST['pasdecompte'])) {
	$create_account=1;
	
}

//--mdp oublié
if (isset($_POST['mdpoublie'])) {
	$mdpoublie=1;
	
}


//--creation compte
if (isset($_POST['ca_ok'])) {
	$create_account=1;
	$login=mysql_real_escape_string(trim($_POST['ca_login']));
	$prenom=mysql_real_escape_string(trim($_POST['ca_prenom']));
	$nom=mysql_real_escape_string(trim($_POST['ca_nom']));
	$email=mysql_real_escape_string(trim($_POST['ca_email']));
	$mdp=mysql_real_escape_string(trim($_POST['ca_mdp']));
	$confirm=mysql_real_escape_string(trim($_POST['ca_mdpconfirm']));
	
	$ca_erreur='';
	if(strpos($email,'@')==false){$ca_erreur='L\'adresse email ne semble pas valide';}
	if(strpos($email,'.')==false){$ca_erreur='L\'adresse email ne semble pas valide';}
	if($mdp!=$confirm){$ca_erreur='Les mots de passes sont différents';}
	if (strlen($mdp)<8){$ca_erreur='Le mot de passe est trop court (min 8 caractères)';}
	if($mdp!=$confirm){$ca_erreur='Les mots de passes sont différents';}
	
	
	if($ca_erreur==''){	//enregistre new user
			include 'connect.php';
			$result = $db->query("SELECT * FROM users WHERE email='$email' OR login='$login'");
			$row_count = $result->rowCount();
			if ($row_count>0){$ca_erreur='Un utilisateur avec cet email ou ce login existe déjà';}
			else {
				$passhash=md5($mdp);
				$now = date("Y-m-d H:i:s");
				$result = $db->exec("INSERT INTO users(login,passhash,prenom,nom,email,datecreated,datemodif,actif)
						VALUES('$login','$passhash','$prenom','$nom','$email','$now','$now',1)");
				//connecte new user
				$_SESSION['login'] = $login;
				$_SESSION['prenom'] = $prenom;
				$_SESSION['nom'] = $nom;
				$_SESSION['email'] = $email;
				$_SESSION['sessionid']='kjFK_69kA5+k47gv-DG&ik';
				header('Location: index.php'); exit();
				}
		}
}


//--envoi mail reset mdp
if (isset($_POST['mo_ok'])) {
	$mdpoublie=1;
	$login=mysql_real_escape_string(trim($_POST['mo_login']));
	include 'connect.php';
	$result = $db->query("SELECT * FROM users WHERE login='$login'");
	$row_count = $result->rowCount();
	if ($row_count==0){$mo_erreur='Ce nom d\'utilisateur n\'existe pas';}
	else {while($row = $result->fetch(PDO::FETCH_ASSOC)) {$to=$row['email'];$prenom=$row['prenom'];$nom=$row['nom'];}
	$msg = "First line of text\nSecond line of text";
	$msg = wordwrap($msg,70);
	$subject=utf8_decode('[FormCreator] Réinitialisation de votre mot de passe');
	$headers="From: FormCreator@noreply.local \n"; 
	$headers.= "MIME-version: 1.0\n"; 
	$headers.= "Content-type: text/html; charset= UTF-8\n"; 
	mail($to,$subject,$msg,$headers);
	$mdpoublie=0;}
	
}




//--formulaire de connexion
if ($create_account!=1 AND $mdpoublie!=1){
echo '<div class="login"><form action="login.php" method="post">';
echo '<input class="fake_submit" type="submit" name="ok" value="Ok">';
echo '<div class="titre_box margin_bottom">Se connecter à FormCreator</div>';
if (isset($erreur)) echo '<div class="erreurlogin margin_bottom">'.$erreur.'</div>';
echo '<input class="input_text" type="text" name="login" placeholder="login">';
echo '<input class="input_text" type="password" name="mdp" placeholder="mot de passe">';
echo '<input class="login_secondaire margin_bottom" type="submit" name="mdpoublie" value="Mot de passe oublié">';
echo '<input class="login_secondaire margin_bottom" type="submit" name="pasdecompte" value="Pas encore de compte?">';
echo '<input class="bouton bt_green bt_seul" type="submit" name="ok" value="Ok">';
echo '</form></div>';}


//--creation nouveau compte
if ($create_account==1){
echo '<div class="login"><form action="login.php" method="post">';
echo '<input class="fake_submit" type="submit" name="ca_ok" value="Ok">';
echo '<div class="titre_box margin_bottom">Création d\'un profil FormCreator</div>';
if (isset($ca_erreur)) echo '<div class="erreurlogin margin_bottom">'.$ca_erreur.'</div>';
echo '<input class="input_text" type="text" name="ca_login" placeholder="Login de connexion" required value="'.$login.'">';
echo '<input class="input_text" type="text" name="ca_prenom" placeholder="Prénom" required value="'.$prenom.'">';
echo '<input class="input_text" type="text" name="ca_nom" placeholder="Nom" required value="'.$nom.'">';
echo '<input class="input_text" type="text" name="ca_email" placeholder="Adresse email" required  value="'.$email.'">';
echo '<div class="tips">L\'adresse email ne sera utilisée que pour renvoyer un mot de passe oublié</div>';
echo '<div class="margin_bottom_double"></div>';
echo '<input class="input_text" type="password" name="ca_mdp" placeholder="mot de passe" required>';
echo '<input class="input_text" type="password" name="ca_mdpconfirm" placeholder="confirmation" required>';
echo '<div class="margin_bottom_double"></div>';
echo '<input class="bouton bt_green bt_plus" type="submit" name="ca_ok" value="Ok">';
echo '<a href="login.php" class="bouton bt_green">Annuler</a>';
echo '</form></div>';}


//--mot de passe oublié
if ($mdpoublie==1){
echo '<div class="login"><form action="login.php" method="post">';
echo '<input class="fake_submit" type="submit" name="mo_ok" value="Ok">';
echo '<div class="titre_box margin_bottom">Mot de passe oublié</div>';
if (isset($mo_erreur)) echo '<div class="erreurlogin margin_bottom">'.$mo_erreur.'</div>';
echo '<input class="input_text" type="text" name="mo_login" placeholder="votre login" required  value="'.$login.'">';
echo '<div class="tips">Un email sera envoyé sur l\'adresse email enregistrée dans votre profil</div>';
echo '<div class="margin_bottom_double"></div>';
echo '<input class="bouton bt_green bt_plus" type="submit" name="mo_ok" value="Ok">';
echo '<a href="login.php" class="bouton bt_green">Annuler</a>';
echo '</form></div>';}





include 'footer.php';?>
