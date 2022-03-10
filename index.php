<?php
/** ********************************************
 *   **          Nicolas Projects              **   
 *   ********************************************
 *   @author Nicolas Scharre [bibadel] (Noco#2808)
 *   @email nicolasscharre@outlook.fr
 *   @description Page de test
 */
include "db.php";
use db\Database;
$connexion = new Database("localhost", "ConnexionBdd", "root", "");
$connexion->connect();

//  Essaie de SelectThis
try{ 
    $connexion->setTable("test");
    $connexion->setCond("email='nicolas@piryata.fr'");
    $tchouba = $connexion->selectThis("*");


    foreach($tchouba as $te)
    {
        echo $te['nom']."<br />";
    }

}catch(Exception $e)
{
    echo("Erreur ".$e);
}
// Essaie de SelectQueryWhere
try{
    $connexion->setTable("test");
    $connexion->setCond("email='nicolas@piryata.fr'");
    $nico = $connexion->selectQueryWhere("*");

}catch(Exception $e)
{
    die("Erreur : $e");
}
 
// Essaie de InsertInto [Encore en cours de dev afin d'automatiser la complétion des requêtes SQL]
// try {
//     $connexion->setTable("test");
//     $champs = ["nom", "prenom", "email"];
//     $args =["nicolas", "SCHARRE", "nicolas@piryata.fr"];
//     $test = $connexion->insertInto($champs, $args);
//     echo $test;
// } catch (\Throwable $th) {
//     throw $th;
// }