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
				<a href="espaceMembre.php"><li>Espace membre</li></a>
			</ul>
		</nav>
		<h1>My cinema</h1>
		<form class="forms" method="get">
			<h2>Rechercher un film par</h2><br /><br />
			<label for="filmName">Titre :</label>
			<input type="text" name="film" placeholder="titre du film"><br><br>

			<label for="filmGenre">Genre :</label>
			<input type="text" name="genre" placeholder="genre du film"><br><br>
			
			<label for="filmDistrib">Distributeur :</label>
			<input type="text" name="distrib" placeholder="nom du distributeur"><br><br>
			
			<label for="limit">Afficher par : </label>
			<select name="limit">
                <option value="10">10</option>
                <option value="30">30</option>
                <option value="60">60</option>
                <option value="100">100</option>
                <option value="200">200</option>
			</select>
			<input type="submit" class="chercher" value="Chercher"><br><br>
			
		</form>

		<form class="forms" method="get">
			<h2>Rechercher un membre par<br><br></h2>
			<label for="membreName">Nom :</label>
			<input type="text" name="nom" placeholder="nom de famille"><br><br>

			<label for="membrePrenom">Prénom :</label>
			<input type="text" name="prenom" placeholder="prénom"><br><br>

			<label for="limit">Afficher par : </label>
			<select name="limit">
                <option value="10">10</option>
                <option value="30">30</option>
                <option value="60">60</option>
                <option value="100">100</option>
                <option value="200">200</option>
			</select><br>
			<input type="submit" class="chercher" value="Chercher">
			<a href="nouveau_membre.php"><button class="ajouterMembre" type="button" >Ajouter membre</button></a>
		</form>

		<form class="forms" method="get">
			<h2>Quels films passent ce soir ?<br><br></h2>
			<label for="membreName">Date :</label>
			<input type="date" name="date" max="2008-02-01"><br><br>

			<label for="limit">Afficher par : </label>
			<select name="limit">
                <option value="10">10</option>
                <option value="30">30</option>
                <option value="60">60</option>
                <option value="100">100</option>
                <option value="200">200</option>
			</select>
			<input type="submit" class="chercher" value="Chercher"><br><br>
		</form>

		<div class="rep_forms">
			<h2>Résultat de votre recherche :</h2>
			<table>
		
		<?php
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=cinema;charset=utf8', 'root', '');
		}
		catch(Exception $e){
			die('Erreur : '.$e->getMessage());
		}
		
		$titre_film = $_GET['film'];
		$genre_film = $_GET['genre'];
		$distrib_film = $_GET['distrib'];
		$membre_nom = $_GET['nom'];
		$membre_prenom = $_GET['prenom'];
		$date = $_GET['date'];
		$limit = $_GET['limit'];

		if (empty($titre_film) && empty($genre_film) && empty($distrib_film) && empty($membre_nom) && empty($membre_prenom) && empty($date)){
			echo '';
		}

		if(!empty($titre_film)){
			$reponse = $bdd->query("SELECT * FROM film INNER JOIN genre USING (id_genre) WHERE titre LIKE '%$titre_film%' LIMIT $limit");
			while ($donnees = $reponse->fetch()){
				echo '<br /><h3>'.$donnees['titre']. '</h3>';
				echo ' (' . $donnees['duree_min']. ' min | '. $donnees['annee_prod']. ' | '. $donnees['nom'].')'.'<br />';
				echo '<br />'. $donnees['resum'].'<br />';
				echo '_____________<br />';
				$requete=1;
			}
			if($requete!=1){
				echo "Oups.... aucun titre de film ne correspond à votre recherche";
			}
			echo '<br />';
			$reponse->closeCursor();
		}

		if(!empty($genre_film)){
			$reponse = $bdd->query("SELECT * FROM film INNER JOIN genre USING (id_genre) WHERE nom LIKE '%$genre_film%' ORDER BY nom, titre ASC LIMIT $limit");
			while ($donnees = $reponse->fetch()){
				echo '<br /><h3>'.$donnees['titre']. '</h3>';
				echo ' (' . $donnees['duree_min']. ' min | '. $donnees['annee_prod']. ' | '. $donnees['nom'].')'.'<br />';
				echo '<br />'. $donnees['resum'].'<br />';
				echo '_____________<br />';
				$requete=1;
			}
			if($requete!=1){
				echo "Oups.... aucun genre de film ne correspond à votre recherche".'<br />'.'<br />';
				$reponse = $bdd->query("SELECT nom FROM genre ORDER BY nom ASC");
				while ($donnees = $reponse->fetch()){
					echo $donnees['nom'].' | ';
				}
				$reponse->closeCursor();
			}
			echo '<br />';
		}

		if(!empty($distrib_film)){
			$reponse = $bdd->query("SELECT * FROM film INNER JOIN distrib USING (id_distrib) WHERE nom LIKE '%$distrib_film%' ORDER BY nom, titre ASC LIMIT $limit");
			while ($donnees = $reponse->fetch()){
				echo '<br /><h3>'.$donnees['titre']. '</h3>';
				echo ' (' . $donnees['duree_min']. ' min | '. $donnees['annee_prod']. ' | '. $donnees['nom'].')'.'<br />';
				echo '<br />'. $donnees['resum'].'<br />';
				echo '_____________<br />';
				$requete=1;
			}
			$reponse->closeCursor();
			if($requete!=1){
				echo "Oups.... aucun distributeur de film ne correspond à votre recherche";
			}
			echo '<br />';
		}

		if(!empty($membre_nom)){
			$reponse = $bdd->query("SELECT * FROM fiche_personne WHERE nom LIKE '%$membre_nom%' ORDER BY nom ASC LIMIT $limit");
			while ($donnees = $reponse->fetch()){
				$id = $donnees['id_perso'];
				echo '
					<tr>
						<td>'.$donnees['nom']. '</td>
						<td>'. $donnees['prenom']. '</td>
						<td>'. $donnees['email'].'</td>
						<td><a href="voirPlus.php?id='.$id.'"><button class="voirPlus" type="button">Voir +</button></a></td>
					</tr>';
				$requete=1;
			}
			$reponse->closeCursor();
			if($requete!=1){
				echo "Aucun membre ne correspond à votre recherche...";
			}
			echo '<br />';
		}

		if(!empty($membre_prenom)){
			$reponse = $bdd->query("SELECT * FROM fiche_personne WHERE prenom LIKE '%$membre_prenom%' ORDER BY nom ASC LIMIT $limit");
			while ($donnees = $reponse->fetch()){
				$id = $donnees['id_perso'];
				echo '
					<tr>
						<td>'.$donnees['nom']. '</td>
						<td>'. $donnees['prenom']. '</td>
						<td>'. $donnees['email'].'</td>
						<td><a href="voirPlus.php?id='.$id.'"><button class="voirPlus" type="button">Voir +</button></a></td>
					</tr>';
				$requete=1;
			}
			$reponse->closeCursor();
			if($requete!=1){
				echo "Aucun membre ne correspond à votre recherche...";
			}
			echo '<br />';
		}

		if(!empty($date)){
			$reponse = $bdd->query("SELECT * FROM film WHERE date_debut_affiche>=$date AND date_fin_affiche<=$date LIMIT $limit");
			while($donnees = $reponse->fetch()){
				echo "<tr>
						<th>id film</th>
						<th>Titre du film</th>
						<th>Genre</th>
						<th>Durée</th>
						<th>Résum</th>
						<th>Date début d'affiche</th>
						<th>Date fin d'affiche</th>
					</tr>";
				echo '<tr>
						<td>'.$donnees['id_film']. '</td>
						<td>'.$donnees['titre']. '</td>
						<td>'.$donnees['id_genre'].'</td>
						<td>'.$donnees['duree_min']. '</td>
						<td>'.$donnees['resum']. '</td>
						<td>'.$donnees['date_debut_affiche']. '</td>
						<td>'.$donnees['date_fin_affiche']. '</td>
					</tr>';
				$requete=1;
			}
			if($requete!=1){
			echo "Aucune projection n'est prévue à la date du : ";
			echo $date;
			}
		}
		?>
			</table>
	</div>
		
	</body>
</html>
