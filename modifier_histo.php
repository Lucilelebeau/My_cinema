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

        <form class="forms" method="post">
        <h2>Historique des films vus</h2>
        <a href="voirPlus.php?id=<?php $homeId= $_GET['id'];echo $homeId;?>"><button class="retour" type="button">Retour</button></a>
        <a href="modifier_histo.php?id_membre=<?php $id_membre= $_GET['id_membre'];echo $id_membre;?>&id=<?php $homeId= $_GET['id'];echo $homeId;?>"><button class="retour" type="button">Actualiser</button></a><br><br><br>
        
            
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
                $homeId= $_GET['id'];
                $id_membre= $_GET['id_membre'];

                $reponse = $bdd->query("SELECT * FROM historique_membre LEFT JOIN film USING(id_film) WHERE id_membre=$id_membre ORDER BY date DESC");
                while ($donnees = $reponse->fetch()){
                    echo '
                        <tr>
                            <td>'.$id_membre.'</td>
                            <td>'.$donnees['id_film'].'</td>
                            <td>'.$donnees['titre'].'</td>
                            <td>'.$donnees['date'].'</td>
                            <td>'.$donnees['avis'].'</td>
                            <td><a href="ajouter_avis.php?id_film='.$donnees['id_film'].'&id_membre='.$id_membre.'&id='.$homeId.'"><button class="membre_info" type="button">ajouter avis</button></a></td>
                        </tr>';
                }
                $reponse->closeCursor();
                ?>
            </table>
        </form>

        <form class="forms" method="get">
                <h2>Rechercher un film<br></h2><br><br>
			        <label for="filmName">Titre :</label>
                    <input type="hidden" name="id_membre" value="<?php echo "$id_membre";?>">
                    <input type="hidden" name="id" value="<?php echo "$homeId";?>">
			        <input type="text" name="film" placeholder="titre du film">
                    <input type="submit" value="Chercher"><br><br><br>
                    
                    <table>
                        <tr>
                            <th>id film</th>
                            <th>Titre film</th>
                        </tr>
                    <?php
                    //recherche titre film
                    $titre_film = $_GET['film'];
                    if (empty($titre_film)){
                        echo '';
                    }
                    if(!empty($titre_film)){
                        $reponse = $bdd->query("SELECT id_film, titre FROM film WHERE titre LIKE '%$titre_film%' ORDER BY titre ASC");
			            while ($donnees = $reponse->fetch()){
                            echo '
                                <tr>
                                    <td><a href="membre_info.php?id='.$id.'"><input name="id_film" type="submit" value="'.$donnees['id_film'].'"></a></td>
                                    <td>'.$donnees['titre'].'</td>
                                </tr>';
                        }
                        $reponse->closeCursor();
                    }
                    $id_ajout = $_GET['id_film'];
                    
                    $reponse = $bdd->query("SELECT * FROM film INNER JOIN historique_membre USING (id_film)");

                    $sql = "INSERT INTO historique_membre(id_membre, id_film, date) VALUES('$id_membre', '$id_ajout', NOW())";
                    $bdd->exec($sql);
                    $sql = null;

                    ?>
                    </table>
        </form>
    </boby>
</html>