<?php

$bdd = new PDO("mysql:host=localhost;dbname=epitech_tp", "root", "root", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

$prenom = !empty($_GET["prenom"]) ? $_GET["prenom"] : NULL;
$nom = !empty($_GET["nom"]) ? $_GET["nom"] : NULL;

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


if (isset($prenom) && isset($nom))
{
    $reponse = $bdd->query("SELECT * FROM membre INNER JOIN fiche_personne ON membre.id_fiche_perso = fiche_personne.id_perso 
    WHERE fiche_personne.prenom='$prenom' && fiche_personne.nom='$nom' LIMIT $start, $resultPerPage");

    $count_resp = $bdd->query("SELECT * FROM membre INNER JOIN fiche_personne ON membre.id_fiche_perso = fiche_personne.id_perso 
    WHERE fiche_personne.prenom='$prenom' && fiche_personne.nom='$nom'");

    $response_tot = $count_resp->rowCount();
}
elseif (!isset($prenom) || !isset($nom))
{
    $reponse = $bdd->query("SELECT * FROM membre INNER JOIN fiche_personne ON membre.id_fiche_perso = fiche_personne.id_perso 
    WHERE fiche_personne.prenom='$prenom' || fiche_personne.nom='$nom' LIMIT $start, $resultPerPage");

    $count_resp = $bdd->query("SELECT * FROM membre INNER JOIN fiche_personne ON membre.id_fiche_perso = fiche_personne.id_perso 
    WHERE fiche_personne.prenom='$prenom' || fiche_personne.nom='$nom'");
    
    $response_tot = $count_resp->rowCount();
}
else
{
    return NULL;
}

$membres = $reponse->fetchAll();

$nbrPage = isset($response_tot) ? ceil($response_tot/$resultPerPage) : NULL;

if($response_tot > 0 )
{
    if($response_tot > 1)
    {
        echo "<h4>Membres :</h4>" . $response_tot . " membres trouvés ";
    }
    else
    {
        echo "<h4>Membre :</h4>" . $response_tot . " membre trouvé "; 
    }
}

if($nbrPage > 1)
{
    for($i = 1; $i <= $nbrPage; $i++)
    {
        echo "<a href='index.php?prenom=" . $prenom . "&nom=" . $nom . "&result_page=" . $resultPerPage . "&page=" . $i . "'>" . $i . "</a> ";  
    }
}

if (isset($membres))
{
    foreach($membres as $membre)
    {
        echo 
        "<h3>" . $membre["prenom"] . " " . $membre["nom"] . "</h3>".
        "<ul>" .
        "<li>" . "Email : " . $membre["email"] . " " . "</li>".
        "<li>" . "Ville : " . $membre["ville"] . " " . "</li>".
        "<li>" . "Code Postal : " . $membre["cpostal"] . "</li>
        </ul>";
    }
}
