<?php

$bdd = new PDO("mysql:host=localhost;dbname=epitech_tp", "root", "root", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

if($response_tot == 1)
{
    $ask_abonnement = $bdd->query("SELECT abonnement.nom, abonnement.duree_abo FROM abonnement INNER JOIN membre 
    ON abonnement.id_abo = membre.id_abo WHERE membre.id_fiche_perso = '" . $membre['id_perso'] . "'");

    $abonnements = $ask_abonnement->fetchAll();

    if(isset($abonnements))
    {
        foreach($abonnements as $abonnement)
        {
            echo "<div class='col-15'>Abonnement <strong>" . $abonnement["nom"] . "</strong> pour <strong>" . $abonnement["duree_abo"] . " jours</strong></div><br><br>";
        }
    }

    if($nom == NULL)
    {
        $nom = $membre["nom"];
    }

    echo 
    "<br><form action='index.php' method='get'>
    <input type='text' name='nom' value='" . $nom . "' readonly='readonly'>
    <input type='text' name='addFilm' placeholder='Ajouter un film'><input type='text' name='comment' placeholder='commentaire'><button type='submit'>Ajouter</button>
    </form>";

    $film = !empty($_GET["addFilm"]) ? $_GET["addFilm"] : NULL;
    $comment = !empty($_GET["comment"]) ? $_GET["comment"] : NULL;
    $id_membre = $membre["id_fiche_perso"];

    if(isset($film))
    {
        //recupere l'ID du film
        $reqIdFilm = $bdd->query("SELECT id_film FROM film WHERE titre='$film'");
        $idFilm = $reqIdFilm->fetchAll();
        $nbrFilm = $reqIdFilm->rowCount();
        
        if(isset($idFilm))
        {
                foreach($idFilm as $id)
                {
                    $id = $id["id_film"];
                }
        }

        if($nbrFilm != NULL)
        {
            if(!isset($comment))
            {
                $addFilm = $bdd->query("INSERT INTO historique_membre (id_membre, id_film, date) VALUES ('$id_membre', '$id', '2019-06-06')");
            }
            elseif(isset($comment))
            {
                $addComment = $bdd->query("INSERT INTO historique_membre (id_membre, id_film, date, comment) VALUES ('$id_membre', '$id', '2019-06-06', '$comment')");
            } 
        }
        elseif($nbrFilm == NULL)
        {
            echo "Ce Film n'existe pas dans la base de données";
        }
    }
}