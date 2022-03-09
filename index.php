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


try{
    $connexion = new Database("localhost", "ConnexionBdd", "root", "");
    $connexion->connect();
    $connexion->setTable("test");
    $connexion->setCond("email='nicolas@piryata.fr'");
    $nico = $connexion->selectQueryWhere("*");
    $tchouba = $connexion->selectThis("*");


    foreach($tchouba as $te)
    {
        echo $te['nom']."<br />";
    }

}catch(Exception $e)
{
    echo("Erreur ".$e);
}