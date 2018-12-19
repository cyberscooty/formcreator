<?php
include 'header2.php';

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
	echo 'pas encore de compte';
}

//--mdp oublié
if (isset($_POST['mdpoublie'])) {
	echo 'mdp oublié';
}









//--formulaire de connexion
echo '<div class="login"><form action="login.php" method="post">';
echo '<input class="fake_submit" type="submit" name="ok" value="Ok">';
echo '<div class="titre_box margin_bottom">Se connecter à FormCreator</div>';
if (isset($erreur)) echo '<div class="erreurlogin margin_bottom">'.$erreur.'</div>';
echo '<input class="input_text" type="text" name="login" placeholder="login">';
echo '<input class="input_text" type="password" name="mdp" placeholder="mot de passe">';
echo '<input class="login_secondaire margin_bottom" type="submit" name="mdpoublie" value="Mot de passe oublié">';
echo '<input class="login_secondaire margin_bottom" type="submit" name="pasdecompte" value="Pas encore de compte?">';
echo '<input class="bouton bt_green bt_seul" type="submit" name="ok" value="Ok">';




echo '</form></div>';











include 'footer.php';?>
