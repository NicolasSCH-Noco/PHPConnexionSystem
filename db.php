<?php

/** ********************************************
 *   **          Nicolas Projects              **   
 *   ********************************************
 *   @author Nicolas Scharre [bibadel] (Noco#2808)
 *   @email nicolasscharre@outlook.fr
 *   @description Classe Database
 */
namespace  db;

use Exception;
use PDO;
use PDOException;

Class Database 
{
    
    // -------- Connexion --------
    // Valeur = Nom d'hôte de la base de donnée
    private $host;

    // Valeur = Nom d'utilisateur de la base de donnée
    private $user;

    // Valeur = Nom de la base de donnée
    private $database;

    // Valeur = Mot de passe de l'utilisateur de la base de donnée
    private $password;

    // -------- Utilisation --------

    // Valeur = Stocker la connexion
    private $connexion;
    
    // Valeur = Nom de la table concernée par la requête
    private $table;

    // Valeur = Arguments pour des conditions
    private $cond;

    // Constructeur
    public function __construct($host, $db, $user, $pass)
    {
        $this->setHost($host);
        $this->setDatabase($db);
        $this->setUser($user);
        $this->setPassword($pass);
    }

    // Initialise la valeur de $host
    public function setHost(string $host)
    {
        $this->host = $host;
    }

    // Retourne la valeur de $host
    public function getHost(): String
    {
        return $this->host;
    }

    // Initialise la valeur de $user
    public function setUser(string $user)
    {
        $this->user = $user;
    }

    // Retourne la valeur de $user
    public function getUser(): String 
    {
        return $this->user;
    }

    // Initialise la valeur de $database
    public function setDatabase(string $db)
    {
        $this->database = $db;
    }

    // Retourne la valeur de $database
    public function getDatabase(): String 
    {
        return $this->database;
    }

    // Initialise la valeur de $password
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    // Retourne la valeur de $password
    public function getPassword(): String
    {
        return $this->password;
    }

    // Initialise la valeur de $table
    public function setTable(string $table)
    {
        $this->table = $table;
    }

    // Retourne la valeur de $table
    public function getTable(): String
    {
        return $this->table;
    }

    // Initialise la valeur de $cond
    public function setCond(string $cond)
    {
        $this->cond = $cond;
    }

    // Retourne la valeur de $cond
    public function getCond(): String
    {
        return $this->cond;
    }

    // Fonction permettant la connexion à la base de donnée (La connexion sera stocké dans la variable local $connexion)
    public function connect(): PDO
    {
        $dsn = "mysql:dbname=".$this->database.";host=".$this->host;
        try{
            $this->connexion = new PDO($dsn, $this->user, $this->password);
            return $this->connexion;
        }catch(PDOException $e)
        {
            throw new Exception("Erreur :".$e);
        }
    }

    // Fonction permettant de faire une requête Select avec une condition
    //  $arg = Élements récupérer
    // Requis : Init des variables $table et $cond
    public function selectQueryWhere($arg): Array 
    {
        if($this->table === null or $this->cond === null) throw new Exception("Merci de notifier la table et les conditions");
        $stmt = $this->connexion->prepare("SELECT $arg FROM $this->table WHERE :cond");
        $stmt->bindValue(':cond', $this->cond, PDO::PARAM_STR);
        $stmt->execute(); 

        return $stmt->fetchAll();
    }

    // Simple requête select sans conditions
    public function selectThis(string $arg): Array 
    {
        $stmt = $this->connexion->prepare("SELECT $arg FROM $this->table");
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function insertInto(Array $champs, Array $args): String
    {
        try{
            $req = "";
            $champ = "";
            foreach($args as $arg)
            {
                $test = '"'.$arg.'",';
                $req = $req.$test;
            }
            foreach($champs as $ch)
            {
                $champ = $champ.",".$ch;
            }
            str_replace($req, "\\", "");
            $stmt = $this->connexion->prepare("INSERT INTO $this->table ($champ) VALUES (:args)");
            $stmt->bindParam(':args', $req, PDO::PARAM_STR);
            $stmt->execute();
        return "La ligne à bien été prise en compte";
        }catch(Exception $e)
        {
            return "Oups il y a une erreur: $e";
        }
    }
}