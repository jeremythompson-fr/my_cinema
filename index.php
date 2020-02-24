<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <title>Site du mec à la caisse</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
</head>

<body>
    <div class="row">
        <div class="col-12">
            <header class="header">
                <img src="ressources/sitedumecalacaisse.png" alt="logo">
            </header>
        </div>
    </div>

    <div class="row">
        <!--Rechercher un Membre-->
        <div class="col-6">
            <form action="index.php" method="get">
                Rechercher un membre :
                <input type="text" name="prenom" placeholder="Prénom">
                <input type="text" name="nom" placeholder="Nom">

                <button type="submit">Rechercher</button><br> Afficher
                <input type="number" name="result_page" placeholder="10 (Optionnel)"> résultat(s).
            </form>
            <br><br>

            <!--Zone Résultat-->
            <div class="row">
                <div class="col-6">
                    <?php
                        include "lister_membre.php";  
                        include "operations.php";
                    ?>
                </div>
                <div class="col-6">
                        <?php
                            include "historique_membre.php";
                        ?>
                </div>
            </div>
            <!--End Zone Résultat-->
        </div>
        <!--End Rechercher un Membre-->

        <!--Rechercher un Film-->
        <div class="col-6">
            <form action="index.php" method="get">
                Rechercher un film par 
                <select name="option">
                    <option value="nom_film" >Nom du FIlm</option>
                    <option value="genre" >Genre du Film</option>
                    <option value="distributeur">Distributeur</option>
                </select>
                <input type="search" name="recherche" placeholder="Rechercher">
                <button type="submit">Rechercher</button><br>

                Par date entre : <input type="date" name="from" date-format="ddmmYYYY" > et <input type="date" name="to">
                <button type="submit">Rechercher</button><br>
                Afficher <input type="number" name="result_page" placeholder="10 (Optionnel)"> résultat(s).
            </form> <br><br>
            <!--Zone Résultat-->
            <div class="row">
                <div class="col-6">
                    <?php 
                        include "lister_film.php";
                    ?>
                </div>
            </div>
            <!--End Zone Résultat-->
        </div>
        <!--End Rechercher un Film-->
    </div>
</body>

</html>