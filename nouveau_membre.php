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
            <h2>Ajouter un nouveau membre<br><br></h2>
            <label for="membreNom">Nom :</label>
            <input type="text" name="nom" required><br><br>
            
            <label for="membrePrenom">Prénom :</label>
            <input type="text" name="prenom" required><br><br>

            <label for="membreAnniv">Date de naissance :</label>
            <input type="date" name="dateNaiss" max="2020-01-01" required><br><br>

            <label for="membreEmail">Email :</label>
            <input type="email" name="email" required><br><br>

            <label for="adresse">Adresse :</label>
            <input type="text" name="adresse"><br><br>

            <label for="cpostal">Code postal :</label>
            <input type="text" name="cpostal" required><br><br>

            <label for="ville">Ville :</label>
            <input type="text" name="ville" required><br><br>

            <label for="pays">Pays :</label>
            <input type="text" name="pays"><br><br>
            
            <input id="ajouter" class="ajouter_new_membre" type="submit" value="Valider" />
            <a href="index.php"><button class="retour_new" type="button">Retour</button></a>
        </form>

        <?php
        try{
            $bdd = new PDO('mysql:host=localhost;dbname=cinema;charset=utf8', 'root', '');
        }
        catch(Exception $e){
            die('Erreur : '.$e->getMessage());
        }
        $reponse = $bdd->query("SELECT MAX(id_perso) from fiche_personne");
        while ($donnees = $reponse->fetch()){
            $maxId = $donnees['MAX(id_perso)'];
        }
        $reponse->closeCursor();
        
        $reponse = $bdd->query("SELECT MAX(id_membre) from membre");
        while ($donnees = $reponse->fetch()){
            $maxMembre = $donnees['MAX(id_membre)'];
        }
        $reponse->closeCursor();
        
        $newIdMembre = $maxMembre +1;
        $newId = $maxId +1;
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $dateNaiss = $_POST['dateNaiss'];
        $email = $_POST['email'];
        $adresse = $_POST['adresse'];
        $cpostal = $_POST['cpostal'];
        $ville = $_POST['ville'];
        $pays = $_POST['pays'];

        $sql = "INSERT INTO fiche_personne VALUES('$newId','$nom', '$prenom', '$dateNaiss', '$email', '$adresse', '$cpostal', '$ville', '$pays')";
        $sql1 = "INSERT INTO membre(id_membre, id_fiche_perso, date_inscription) VALUES('$newIdMembre', '$newId', NOW())";
        $bdd->exec($sql);
        $bdd->exec($sql1);
        
        $reponse = $bdd->query("SELECT * FROM fiche_personne LEFT JOIN membre ON fiche_personne.id_perso=membre.id_fiche_perso WHERE id_perso=$newId");
        while ($donnees = $reponse->fetch()){
            echo '<div class="rep_forms1">
                    <h2>Le nouveau membre a été ajouté avec succés !</h2><br><br>
                    <table>
                        <tr>
                            <th>id perso</th>
                            <th>id membre</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Adresse</th>
                            <th>Code postal</th>
                            <th>Ville</th>
                            <th>Date de naissance</th>
                        </tr>
                        <tr>
                            <td>'.$donnees['id_perso'].'</td>
                            <td>'.$donnees['id_membre'].'</td>
                            <td>'.$donnees['nom'].'</td>
                            <td>'.$donnees['prenom'].'</td>
                            <td>'.$donnees['email'].'</td>
                            <td>'.$donnees['adresse'].'</td>
                            <td>'.$donnees['cpostal'].'</td>
                            <td>'.$donnees['ville'].'</td>
                            <td>'.$donnees['date_naissance'].'</td>
                        </tr>
                    </table> 
                </div>';
        }
        $reponse->closeCursor();
        $bdd= null;
        ?>
            
    </body>
</html>