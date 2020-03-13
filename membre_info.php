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
        <form class="forms1" method="get">
			<h2>Rechercher un membre par<br><br></h2>
				<label for="membreName">Nom :</label>
				<input type="text" name="nom" placeholder="nom de famille">
				<input type="submit" value="Chercher"><br><br>

				<label for="membrePrenom">Prénom :</label>
				<input type="text" name="prenom" placeholder="prénom">					
                <input type="submit" value="Chercher"><br><br>

                <a href="nouveau_membre.php"><button class="ajouter" type="button">Ajouter membre</button></a>
        </form>
        
        <div class="rep_forms1">
		    <h2>Résultat de votre recherche :</h2><br><br>
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
	
		    <?php
		    try{
			    $bdd = new PDO('mysql:host=localhost;dbname=cinema;charset=utf8', 'root', '');
		    }
		    catch(Exception $e){
			    die('Erreur : '.$e->getMessage());
		    }
		
		    $membre_nom = $_GET['nom'];
            $membre_prenom = $_GET['prenom'];
            $id_perso = $_GET['id_perso'];
            $homeId= $_GET['id'];

            $reponse = $bdd->query("SELECT * FROM fiche_personne LEFT JOIN membre ON fiche_personne.id_perso=membre.id_fiche_perso WHERE id_perso=$homeId");
                while ($donnees = $reponse->fetch()){
                    $id = $donnees['id_perso'];
                    echo '
                        <tr>
                            <td>'.$homeId.'</td>
                            <td>'.$donnees['id_membre'].'</td>
                            <td>'.$donnees['nom'].'</td>
                            <td>'.$donnees['prenom'].'</td>
                            <td>'.$donnees['email'].'</td>
                            <td>'.$donnees['adresse'].'</td>
                            <td>'.$donnees['cpostal'].'</td>
                            <td>'.$donnees['ville'].'</td>
                            <td>'.$donnees['date_naissance'].'</td>
                            <td><a href="voirPlus.php?id='.$id.'"><button class="voirPlus" type="button">Voir +</button></a></td>
                            <td><a href="suppr_membre.php?id='.$id.'"><button class="supp" type="button">Supprimer</button></a></td>
                        </tr>';
                }
                $reponse->closeCursor();

		    if (empty($titre_film) && empty($genre_film) && empty($distrib_film) && empty($membre_nom) && empty($membre_prenom)){
			    echo '';
            }
            
            if(!empty($membre_nom)){
                $reponse = $bdd->query("SELECT * FROM fiche_personne LEFT JOIN membre ON fiche_personne.id_perso=membre.id_fiche_perso WHERE nom LIKE '%$membre_nom%' ORDER BY nom ASC");
                while ($donnees = $reponse->fetch()){
                    $id = $donnees['id_perso'];
                    echo '
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
                            <td><a href="voirPlus.php?id='.$id.'"><button class="voirPlus" type="button">Voir +</button></a></td>
                            <td><a href="suppr_membre.php?id='.$id.'"><button class="supp" type="button">Supprimer</button></a></td>
                        </tr>';
                    $requete=1;
                }
                $reponse->closeCursor();
                if($requete!=1){
                    echo "Aucun membre ne correspond à votre recherche...";
                    echo '<br><br><br><br>';
                }
                $reponse->closeCursor();
            }
    
            if(!empty($membre_prenom)){
                $reponse = $bdd->query("SELECT * FROM fiche_personne INNER JOIN membre ON fiche_personne.id_perso=membre.id_fiche_perso WHERE prenom LIKE '%$membre_prenom%' ORDER BY nom ASC");
                while ($donnees = $reponse->fetch()){
                    $id = $donnees['id_perso'];
                    echo '
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
                            <td><a href="voirPlus.php?id='.$id.'"><button class="voirPlus" type="button">Voir +</button></a></td>
                            <td><a href="supp_membre.php?id='.$id.'"><button class="supp" type="button">Supprimer</button></a></td>
                        </tr>';
                    $requete=1;
                }
                $reponse->closeCursor();
                if($requete!=1){
                    echo "Aucun membre ne correspond à votre recherche...";
                    echo '<br><br><br><br>';
                }
                
                $reponse->closeCursor();
            }
            ?>
            </table>
            <a href="index.php"><button class="retour" type="button">Retour</button></a>
        </div>
    </body>
</html>