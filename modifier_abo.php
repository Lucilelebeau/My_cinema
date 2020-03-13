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

        <form class="rep_forms" method="post">
        <h2>Abonnement actuel</h2><br>
		    <table>
                <tr>
                    <th>id perso</th>
                    <th>id abonnement</th>
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
                    
                $homeId= $_GET['id'];

                $reponse = $bdd->query("SELECT * FROM membre INNER JOIN abonnement USING(id_abo) WHERE id_fiche_perso=$homeId");
                $donnees = $reponse->fetch();
                echo '
                    <tr>
                        <td>'.$homeId.'</td>
                        <td>'.$donnees['id_abo'].'</td>
                        <td>'.$donnees['nom'].'</td>
                        <td>'.$donnees['resum'].'</td>
                        <td>'.$donnees['prix'].'</td>
                        <td>'.$donnees['duree_abo'].'</td>
                        <td>'.$donnees['date_inscription'].'</td>
                    </tr>';
                $reponse->closeCursor();
                ?>

            </table><br><br><br><br>
           
            <h2>Modifier l'abonnement<br><br></h2>
            <label for="abonnement">Choisissez l'abonnement :</label>

            <select name="abo" id="abo">
                <option value="">--Abonnement--</option>
                <option value="4">Pass day</option>
                <option value="3">Classic</option>
                <option value="2">GOLD</option>
                <option value="1">VIP</option>
                <option value="0">SUPPRIMER ABO</option>
            </select><br><br>

            <a href="voirPlus.php?id=<?php echo $homeId;?>"><button class="retour" type="button">Retour</button></a>
            <input class="enregistrer" type="submit" value="Enregistrer" />
        </form>

        <?php
            try{
			    $bdd = new PDO('mysql:host=localhost;dbname=cinema;charset=utf8', 'root', '');
		    }
		    catch(Exception $e){
			    die('Erreur : '.$e->getMessage());
            }
            
            $homeId= $_GET['id'];
            $id_abo = $_POST['abo'];

            $reponse = $bdd->query("UPDATE membre SET id_abo=$id_abo WHERE id_fiche_perso=$homeId");
            $donnees = $reponse->fetch();
            $reponse1 = $bdd->query("SELECT * FROM membre INNER JOIN abonnement USING(id_abo) WHERE id_fiche_perso=$homeId");
            $donnees1 = $reponse1->fetch();
            echo "
                <div class='rep_forms'>
                <h2>Abonnement modifiée avec succés !</h2>
                    <table><br><br>
                        <tr>
                            <th>id membre</th>
                            <th>id abonnement</th>
                            <th>Nom de l'abonnement</th>
                            <th>Resum</th>
                            <th>Prix</th>
                            <th>Durée de l'abonnement</th>
                            <th>Date d'inscription</th>
                        </tr>
                        <tr>
                            <td>$homeId</td>
                            <td>$id_abo</td>
                            <td>".$donnees1['nom']."</td>
                            <td>".$donnees1['resum']."</td>
                            <td>".$donnees1['prix']."</td>
                            <td>".$donnees1['duree_abo']."</td>
                            <td>".$donnees1['date_inscription']."</td>
                        </tr>
                    </table>
                </div>";
            $reponse->closeCursor();
            $reponse1->closeCursor();
        ?>
    </boby>
</html>