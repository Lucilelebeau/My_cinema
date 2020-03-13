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
                <h2>Supprimer le membre :<h3><br><br>
                    <input type="hidden" name="suppr" value="'.$id.'">
                    <input type="checkbox" name="choix" value="1"> oui<br>
                    <input type="checkbox" name="choix" value="2"> non<br>
                    <input type="submit" class="confirm_supp" value="Confirmer">
                    <a href="index.php"><button class="retour" type="button">Retour</button></a><br>		

        <?php
        try{
            $bdd = new PDO('mysql:host=localhost;dbname=cinema;charset=utf8', 'root', '');
        }
        catch(Exception $e){
            die('Erreur : '.$e->getMessage());
        }
        $homeId= $_GET['id'];
        $id_membre = $_GET['id_membre'];
        $check = $_POST['choix'];
            
        if($check==2){
            echo"rien";
        }
        if($check==1){
            $reponse = $bdd->query("DELETE FROM fiche_personne WHERE id_perso=$homeId");
            $reponse1 = $bdd->query("DELETE FROM membre WHERE id_membre=$id_membre");
            $reponse2 = $bdd->query("DELETE FROM historique_membre WHERE id_membre=$id_membre");
            $reponse->closeCursor();
            $reponse1->closeCursor();
            $reponse2->closeCursor();
            echo "<div class='rep_forms'>Cette fiche a été supprimé</div>";
        }
        ?>
		    </form>
    </body>
</html>