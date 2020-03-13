<!DOCTYPE html>
<html lang="ZXX">
	<head>
		<meta charset="uft-8">
		<link rel="stylesheet" type="text/css" href="style_cinema.css" />
		<title>My cinema</title>
		<meta name="description" content="My cinema rien qu'à moi, na !" />
	</head>
	<body>
        <h1>My cinema</h1>
        <form class="forms1" method="post">
            <?php
                try{
                        $bdd = new PDO('mysql:host=localhost;dbname=cinema;charset=utf8', 'root', '');
                    }
                    catch(Exception $e){
                        die('Erreur : '.$e->getMessage());
                    }
                    
                    $homeId= $_GET['id'];

                    $reponse = $bdd->query("SELECT id_perso, UPPER(nom), prenom, email, adresse, cpostal, ville, date_naissance FROM fiche_personne WHERE id_perso=$homeId");
                    $donnees = $reponse->fetch();
                    $reponse->closeCursor();
            ?>
            <h2>Modifier membre<br><br></h2>


            <label for="membreNom">Nom :</label>
            <input class="inputModifier" type="text" name="nom" maxlength="18" value="<?php echo $donnees['UPPER(nom)'];?>" required><br><br>
            
            <label for="membrePrenom">Prénom :</label>
            <input class="inputModifier" type="text" name="prenom" value="<?php echo $donnees['prenom'];?>" required><br><br>

            <label for="membreAnniv">Date de naissance :</label>
            <input type="text" name="dateNaiss" max="2020-01-01" value="<?php echo $donnees['date_naissance'];?>" required><br><br>

            <label for="membreEmail">Email :</label>
            <input class="inputModifier" type="email" name="email" value="<?php echo $donnees['email'];?>" required><br><br>

            <label for="adresse">Adresse :</label>
            <input class="inputModifier" type="text" name="adresse"value="<?php echo $donnees['adresse'];?>"><br><br>

            <label for="cpostal">Code postal :</label>
            <input type="text" name="cpostal" value="<?php echo $donnees['cpostal'];?>" required><br><br>

            <label for="ville">Ville :</label>
            <input class="inputModifier" type="text" name="ville" value="<?php echo $donnees['ville'];?>" required><br><br>

            <label for="pays">Pays :</label>
            <input type="text" name="pays"><br><br>
            
            <a href="voirPlus.php?id=<?php echo $homeId;?>"><button class="retour" type="button">Retour</button></a>
            <input id="ajouter" class="enregistrer" type="submit" value="Enregistrer" />
            </form>

            <?php
            try{
			    $bdd = new PDO('mysql:host=localhost;dbname=cinema;charset=utf8', 'root', '');
		    }
		    catch(Exception $e){
			    die('Erreur : '.$e->getMessage());
            }
            
            $homeId= $_GET['id'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $dateNaiss = $_POST['dateNaiss'];
            $email = $_POST['email'];
            $adresse = $_POST['adresse'];
            $cpostal = $_POST['cpostal'];
            $ville = $_POST['ville'];
            $pays = $_POST['pays'];

            $reponse = $bdd->query("UPDATE fiche_personne SET nom='$nom', prenom='$prenom', date_naissance='$dateNaiss', email='$email', adresse='$adresse', cpostal='$cpostal', ville='$ville', pays='$pays'
                                    WHERE id_perso=$homeId");
            $donnees = $reponse->fetch();
            echo $donnees;
                echo '
                <div class="rep_forms">
		        <h2>Fiche modifiée avec succés !</h2>
                <table><br><br>
                    <tr>
                        <th>id membre</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Date de naissance</th>
                        <th>Email</th>
                        <th>Adresse</th>
                        <th>Code postal</th>
                        <th>Ville</th>
                        <th>Pays</th>
                    </tr>
                    <tr>
                        <td>'.$homeId.'</td>
                        <td>'.$nom.'</td>
                        <td>'.$prenom.'</td>
                        <td>'.$dateNaiss.'</td>
                        <td>'.$email.'</td>
                        <td>'.$adresse.'</td>
                        <td>'.$cpostal.'</td>
                        <td>'.$ville.'</td>
                        <td>'.$pays.'</td>
                    </tr>
                </table>
            </div>';
            $reponse->closeCursor();
            
            ?>

    </body>
</html>