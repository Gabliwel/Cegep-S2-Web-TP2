<?php
    declare(strict_types=1);

    define("SITEURL", $_SERVER["HTTP_HOST"]);
    define("SITESTATE", "dev"); //dev ou prod

    define("TITRE", "漫画 - LA BOUTIQUE");
    define("SITEDESC", "TP2");
    define("ANNEE", date("Y")); //année seul pour le copyright
    define("PROPRIETAIRE", "Gabriel Bertrand & Nicolas Pellerin");

    define("DBNAME", "ecommerce");
    define("DBUSERNAME", "webphp");
    define("DBPASSWORD", "qwerty123");
    // Section BD

?>
