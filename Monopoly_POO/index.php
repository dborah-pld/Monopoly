<?php

include_once("classes/ville.php");
include_once("classes/joueur.php");
include_once("classes/carte.php");

$ville = new Ville("Rue de la Paix", 20000, 5000, 10000, 0, 2000, 4000, 2);
var_dump($ville);
$ville2 = new Ville("Avenue Foch", 20000, 5000, 10000, 0, 2000, 4000, 2);
var_dump($ville2);

echo "<br><br>";

$joueur = new Joueur("Plouc", [], 150000, []);
var_dump($joueur);

echo "<br><br>";

$carte = new Carte("Carte chance", "Recevez 5000");
var_dump($carte);

echo "<br><br>";

$joueur->achatVille($ville);
$joueur->achatVille($ville2);
var_dump($joueur);

echo "<br><br>";

$joueur->hypotheque($ville);
var_dump($joueur);

echo "<br><br>";

$joueur->loyer($ville, $joueur);
var_dump($joueur);

echo "<br><br>";

$joueur->piocher($carte);
var_dump($joueur);

echo "<br><br>";

$joueur->maison($ville);
var_dump($joueur);
