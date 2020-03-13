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
            <h2>Ajouter un avis pour le film :</h2><br>
        <?php
            $avis = $_POST['avis'];
            $id_film = $_GET['id_film'];
            $id_membre = $_GET['id_membre'];
            $homeId= $_GET['id'];
		        try{
			        $bdd = new PDO('mysql:host=localhost;dbname=cinema;charset=utf8', 'root', '');
		        }
		        catch(Exception $e){
			        die('Erreur : '.$e->getMessage());
                }
                $id_film= $_GET['id_film'];
                $id_membre= $_GET['id_membre'];

                $reponse = $bdd->query("SELECT * FROM film WHERE id_film=$id_film");
                while($donnees=$reponse->fetch()){
                    echo '<h3>'.'" '.$donnees['titre'].' "'.'</h3>';
                }
                $reponse->closeCursor();
        ?>
        <label for="msg"></label>
        <textarea id="avis" name="avis" rows="10" cols="33" maxlength="250" placeholder="Votre avis..."></textarea><br><br>
        <input type="submit" value="Valider"><br>

        <a href="voirPlus.php?id_membre=<?php echo $id_membre;?>&id=<?php echo $homeId;?>"><button class="retour" type="button">Retour</button></a>
        </form>

        <?php
            try{
			    $bdd = new PDO('mysql:host=localhost;dbname=cinema;charset=utf8', 'root', '');
		    }
		    catch(Exception $e){
			    die('Erreur : '.$e->getMessage());
            }

            if(empty($avis)){
                echo'';
            }
            else{
            $reponse = $bdd->query("UPDATE historique_membre SET avis='$avis' WHERE id_film=$id_film AND id_membre=$id_membre");
            $donnees = $reponse->fetch();
            $reponse1 = $bdd->query("SELECT * FROM historique_membre LEFT JOIN film USING(id_film) WHERE id_film=$id_film AND id_membre=$id_membre");
            $donnees1 = $reponse1->fetch();
            echo "
                <div class='rep_forms'>
                <h2>Avis ajouté avec succés !</h2>
                    <table><br><br>
                        <tr>
                            <th>id membre</th>
                            <th>id film</th>
                            <th>Titre du film</th>
                            <th>Date de vue</th>
                            <th>Avis</th>
                        </tr>
                        <tr>
                            <td>$id_membre</td>
                            <td>$id_film</td>
                            <td>".$donnees1['titre']."</td>
                            <td>".$donnees1['date']."</td>
                            <td>".$donnees1['avis']."</td>
                        </tr>
                    </table>
                </div>";
            }
            $reponse->closeCursor();
            $reponse1->closeCursor();
        ?>  
    </body>
</html>