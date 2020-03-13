
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
            
        <div class="rep_forms1">
            <h2>Fiche membre</h2>
            <table>
                <tr>
                    <th>id perso</th>
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
            
            $homeId= $_GET['id'];

            $reponse = $bdd->query("SELECT id_perso, UPPER(nom), prenom, email, adresse, cpostal, ville, date_naissance FROM fiche_personne WHERE id_perso=$homeId");
            while ($donnees = $reponse->fetch()){
                echo '
                    <tr>
                        <td>'.$donnees['id_perso'].'</td>
                        <td>'.$donnees['UPPER(nom)'].'</td>
                        <td>'.$donnees['prenom'].'</td>
                        <td>'.$donnees['email'].'</td>
                        <td>'.$donnees['adresse'].'</td>
                        <td>'.$donnees['cpostal'].'</td>
                        <td>'.$donnees['ville'].'</td>
                        <td>'.$donnees['date_naissance'].'</td>';
            }
            $reponse->closeCursor();
            ?>
            </table>

            <h2>Abonnement</h2>
		    <table>
                <tr>
                    <th>id perso</th>
                    <th>id membre</th>
                    <th>id abo</th>
                    <th>Nom de l'abonnement</th>
                    <th>Resum</th>
                    <th>Prix</th>
                    <th>Durée de l'abonnement</th>
                    <th>Date d'inscription</th>
                </tr>

                <?php
		        try{
			        $bdd = new PDO('mysql:host=localhost;dbname=cinema;charset=utf8', 'root', '');
		        }
		        catch(Exception $e){
			        die('Erreur : '.$e->getMessage());
                }

                $reponse = $bdd->query("SELECT * FROM membre LEFT JOIN abonnement USING(id_abo) WHERE id_fiche_perso=$homeId");
                while ($donnees = $reponse->fetch()){
                    echo '
                        <tr>
                            <td>'.$donnees['id_fiche_perso'].'</td>
                            <td>'.$donnees['id_membre'].'</td>
                            <td>'.$donnees['id_abo'].'</td>
                            <td>'.$donnees['nom'].'</td>
                            <td>'.$donnees['resum'].'</td>
                            <td>'.$donnees['prix'].'</td>
                            <td>'.$donnees['duree_abo'].'</td>
                            <td>'.$donnees['date_inscription'].'</td>
                        </tr>';
                        $id_membre = $donnees['id_membre'];
                        
                }
                $reponse->closeCursor();
                
                ?>
                </table>

            <h2>Historique</h2>
		    <table>
                <tr>
                    <th>id membre</th>
                    <th>id film</th>
                    <th>Titre du film</th>
                    <th>Date de vue</th>
                    <th>Avis</th>
                </tr>

                <?php
		        try{
			        $bdd = new PDO('mysql:host=localhost;dbname=cinema;charset=utf8', 'root', '');
		        }
		        catch(Exception $e){
			        die('Erreur : '.$e->getMessage());
                }
              
                $reponse = $bdd->query("SELECT * FROM historique_membre LEFT JOIN film USING(id_film) WHERE id_membre=$id_membre ORDER BY date DESC");
                while ($donnees = $reponse->fetch()){
                    echo '
                        <tr>
                            <td>'.$id_membre.'</td>
                            <td>'.$donnees['id_film'].'</td>
                            <td>'.$donnees['titre'].'</td>
                            <td>'.$donnees['date'].'</td>
                            <td>'.$donnees['avis'].'</td>
                        </tr>';
                }
                $reponse->closeCursor();
            
                
                ?>
            </table>
            <a href="modifier_membre.php?id=<?php echo $homeId;?>"><button class="retour" type="button">Modifier<br>fiche membre</button></a>
            <a href="modifier_abo.php?id=<?php echo $homeId;?>"><button class="retour" type="button">Gérer<br>abonnement</button></a>
            <a href="modifier_histo.php?id=<?php echo $homeId;?>&id_membre=<?php echo $id_membre;?>"><button class="retour" type="button">Gérer<br>historique</button></a><br />
            <a href="suppr_membre.php?id=<?php echo $homeId;?>&id_membre=<?php echo $id_membre;?>"><button class="suppr" type="button">Supprimer<br>fiche</button></a>
            <a href="index.php"><button class="retour" type="button">Retour</button></a>
        </div>
    </body>
</html>