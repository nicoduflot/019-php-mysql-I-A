<?php
/**
 * 
 * Script pour : 
 * - le paramétrage de connexion à la bdd
 * - les fonction d'ouverture et de fermeture de la connexion
 * 
 */

//Constantes de connexion à la bdd
define('DBHOST', 'localhost');
define('DBUSER', 'admin-php');
define('DBPASS', 'admin');
define('DBNAME', 'php-mysql-i-a');
define('DBPORT', '3306');

//fontction de connexion à la bdd
function openConn(){
    // la fonction php mysqli_connect() a besoin des informations de connexion pour créer un objet qui servira à toutes les manipulations bdd
    $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME, DBPORT);
    /*
    var_dump($conn);
    mysqli_close($conn);
    */
    if( !$conn ){
        echo 'Erreur de connexion : <br />' . mysqli_connect_error() . '<br />';
    }else{
        //echo 'Connexion bdd : ' . DBNAME . '<br />';
    }

    // ouverture de connexion en utilisant PDO (Php Data Object)
    /*
    $conn = new PDO('mysql:host='.DBHOST.';dbname:'.DBNAME, DBUSER, DBPASS);
    */

    return $conn;
}

// fermeture de la connexion 
function closeConn($conn){
    // autres traitement avant la fermeture de la connexion
    /**
     * 
     * 
     * 
     */

     // fermeture de la connexion
    mysqli_close($conn);
}