<?php

$bdd = new PDO("mysql:host=localhost;dbname=epitech_tp", "root", "root", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

if($response_tot == 1)
{

    if(isset($_GET["pageHist"]) && $_GET["pageHist"] > 0 )
    {   
        $currentPageHist = intval($_GET["pageHist"]);
    }
    else
    {
        $currentPageHist = 1;
    }

    $startHist = ($currentPageHist-1)*$resultPerPage;

    $historiqueReq = $bdd->query("SELECT film.titre FROM film INNER JOIN historique_membre ON historique_membre.id_film = film.id_film 
    WHERE id_membre ='" . $membre['id_perso'] . "'" . "ORDER BY film.titre ASC LIMIT $startHist, $resultPerPage");
   
    $count_historique = $bdd->query("SELECT film.titre FROM film INNER JOIN historique_membre ON historique_membre.id_film = film.id_film 
    WHERE id_membre ='" . $membre['id_perso'] . "'");
    
    $historiqueNbr = $count_historique->rowCount();

    $nbrPageHist = isset($historiqueNbr) ? ceil($historiqueNbr/$resultPerPage) : NULL;

    if(!is_null($historiqueReq))
    {
       if($historiqueNbr > 1)
       {
            echo "<h4>Films Vues :</h4>" . $historiqueNbr . " films trouvés ";
       }
       else
       {
            echo "<h4>Film Vue :</h4>" . $historiqueNbr . " film trouvé "; 
       }   
       
        $historiques = $historiqueReq->fetchAll();

        if($nbrPageHist > 1)
        {
            for($i = 1; $i <= $nbrPageHist; $i++)
            {
                echo "<a href='index.php?prenom=" . $prenom . "&nom=" . $nom . "&result_page=" . $resultPerPage . "&pageHist=" . $i . "'>" . $i . "</a> ";
            }
        }

        foreach($historiques as $historique)
        {
            echo "<h3>" . $historique["titre"] . "</h3>";
        }
    }
}
