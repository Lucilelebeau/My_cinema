<!DOCTYPE html>
<html lang="ZXX">
	<head>
		<meta charset="uft-8">
		<link rel="stylesheet" type="text/css" href="style_cinema.css" />
		<title>My cinema</title>
		<meta name="description" content="My cinema rien qu'à moi, na !" />
	</head>
	<body>
        <nav>
			<ul>
				<a href="index.php"><li>Home</li></a>
			</ul>
		</nav>
		<h1>My cinema</h1>
		<form class="forms" method="get">
            <h2>Nouveau membre</h2><br><br>
            <label for="pseudo">Pseudo </label>
			<input type="text" name="pseudo" placeholder="votre pseudo" required><br><br>

			<label for="pass">Password (8 characters minimum):</label>
            <input type="password" name="pass" minlength="8" maxlenght="10" required><br><br>

            <label for="pass">Confirmez votre password :</label>
            <input type="password" id="pass" name="pass" minlength="8" maxlenght="10" required><br><br>
			
			<label for="membreEmail">Email :</label>
            <input type="email" name="email" required><br><br>
			
            <input type="submit" class="chercher" value="Valider"><br><br>
            
            <?php
            try{
                $bdd = new PDO('mysql:host=localhost;dbname=cinema;charset=utf8', 'root', '');
            }
            catch(Exception $e){
                die('Erreur : '.$e->getMessage());
            }
            
            $pseudo= $_POST['pseudo'];
            $pass = $_POST['pass'];
            $email = $_POST['email'];
            
            // Vérification de la validité des informations
            $pass_hache = password_hash($pass, PASSWORD_DEFAULT);
            
            $req = "INSERT INTO membre_connexion(pseudo, pass, email, date_inscrip) VALUES('$pseudo', '$pass_hache', '$email', NOW())";
            $bdd->exec($req);
            
            ?>
        </form>

        <form class="forms" method="get">
            <h2>Connexion</h2><br><br>
            <label for="pseudo">Pseudo </label>
			<input type="text" name="pseudo" placeholder="votre pseudo" required><br><br>

			<label for="pass">Password </label>
            <input type="password" id="pass" name="pass" minlength="8" maxlenght="10" required><br><br>

            <input type="submit" class="chercher" value="Se connecter"><br><br>

            <?php 
            $req = $bdd->prepare('SELECT id_connexion, pass FROM membre_connexion WHERE pseudo = :pseudo');
            $req->execute(array('pseudo' => $pseudo));
            $resultat = $req->fetch();

            $isPasswordCorrect = password_verify($_POST['pass'], $resultat['pass']);

            if (!$resultat){
                echo 'Mauvais identifiant ou mot de passe !';
            }
            else{
                if ($isPasswordCorrect) {
                    session_start();
                    $_SESSION['id'] = $resultat['id'];
                    $_SESSION['pseudo'] = $pseudo;
                    echo 'Vous êtes connecté !';
                }
                else {
                echo 'Mauvais identifiant ou mot de passe !';
                }
            }
            ?>
        </form>
    </body>
			