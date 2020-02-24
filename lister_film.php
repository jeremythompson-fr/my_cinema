<?php

$bdd = new PDO("mysql:host=localhost;dbname=epitech_tp", "root", "root", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

$recherche = !empty($_GET["recherche"]) ? $_GET["recherche"] : NULL;
$option = !empty($_GET["option"]) ? $_GET["option"] : NULL;

$fromDate = !empty($_GET["from"]) ? $_GET["from"] : NULL;
$toDate = !empty($_GET["to"]) ? $_GET["to"] : NULL;


$resultPerPage = isset($_GET["result_page"]) > 0 && $_GET["result_page"] != NULL ? intval($_GET["result_page"]) : 10;

if(isset($_GET["page"]) && $_GET["page"] > 0 )
{
    $currentPage = intval($_GET["page"]);
}
else
{
    $currentPage = 1;
}

$start = ($currentPage-1)*$resultPerPage;

if(isset($recherche))
{
    if($option == "nom_film")
    {
        $requete = $bdd->query("SELECT * FROM film WHERE titre LIKE '%$recherche%' LIMIT $start, $resultPerPage");
        $count_req = $bdd->query("SELECT * FROM film WHERE titre LIKE '%$recherche%' LIMIT 0, $resultPerPage");
        $response_tot = $count_req->rowCount();
    }
    elseif($option == "genre")
    {
        $requete = $bdd->query("SELECT film.titre FROM film INNER JOIN genre ON film.id_genre = genre.id_genre WHERE genre.nom = '$recherche' LIMIT $start, $resultPerPage");
        $count_req = $bdd->query("SELECT film.titre FROM film INNER JOIN genre ON film.id_genre = genre.id_genre WHERE genre.nom = '$recherche'");
        $response_tot = $count_req->rowCount();
    }
    elseif($option == "distributeur")
    {
        $requete = $bdd->query("SELECT film.titre, distrib.nom FROM film INNER JOIN distrib ON film.id_distrib = distrib.id_distrib WHERE distrib.nom LIKE '%$recherche%' LIMIT $start, $resultPerPage");
        $count_req = $bdd->query("SELECT film.titre FROM film INNER JOIN distrib ON film.id_distrib = distrib.id_distrib WHERE distrib.nom LIKE '%$recherche%'");
        $response_tot = $count_req->rowCount();
    }
    else
    {
        return NULL;
    }
}
elseif(!isset($recherche))
{
    if(isset($fromDate) && isset($toDate))
    {
        $requete = $bdd->query("SELECT * FROM film WHERE date_debut_affiche >= '$fromDate' && date_fin_affiche <= '$toDate' LIMIT $start, $resultPerPage");
        $count_req = $bdd->query("SELECT * FROM film WHERE date_debut_affiche >= '$fromDate' && date_fin_affiche <= '$toDate'");
        $response_tot = $count_req->rowCount();
    }
    else
    {
        return NULL;
    }
}
else 
{
    return NULL;
}

$films = $requete->fetchAll();

$nbrPage = isset($response_tot) ? ceil($response_tot/$resultPerPage) : NULL;

if($response_tot > 1)
{
    echo $response_tot . " résultats trouvés ";
}
else
{
    echo $response_tot . " résultat trouvé "; 
}

if(!isset($fromDate) && !isset($toDate))
{
    if($nbrPage > 1)
    {
        for($i = 1; $i <= $nbrPage; $i++)
        {
            echo "<a href='index.php?recherche=" . $recherche . "&option=" . $option . "&result_page=" . $resultPerPage . "&page=" . $i . "'>" . $i . "</a> ";
        }
    }
}
elseif(isset($fromDate) && isset($toDate))
{
    if($nbrPage > 1)
    {
        for($i = 1; $i <= $nbrPage; $i++)
        {
            echo "<a href='index.php?recherche=" . $recherche . "&option=" . $option . "&from=" . $fromDate . "&to=" . $toDate . "&result_page=" . $resultPerPage . "&page=" . $i . "'>" . $i . "</a> ";
        }
    }
}

if(isset($films))
{
    if($option == "nom_film")
        foreach($films as $film)
        {
            echo
            "<h3>" . $film["titre"] . " (" . $film["annee_prod"] . ")" . " [" . $film["id_genre"] . "]" ."</h3>" .
            "<h4>" . $film["duree_min"] . " mins" . " | A l'affiche du " . $film["date_debut_affiche"] . 
            " au " . $film["date_fin_affiche"] . "</h4>" .
            $film["resum"];
        }
    elseif($option == "genre")
    {
        foreach($films as $film)
        {
            echo
            "<h3>" . $film["titre"] . "</h3>";
        }
    }
    elseif($option == "distributeur")
    {
        foreach($films as $film)
        {
            echo
            "<h3>" . $film["titre"] . "</h3> (" . $film["nom"] . ")<br>";
        }
    }
}

