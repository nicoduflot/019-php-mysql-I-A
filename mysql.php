<?php
session_start();
include './includes/functions.php';
include './includes/sql.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Formation php - <?php echo 'MySql'; ?></title>
    <?php include './includes/appels.php' ?>
    <style>
        .limit-height {
            max-height: 50vh;
            overflow: auto;
        }
    </style>
</head>

<body>
<?php include './includes/header.php' ?>
    <?php include './includes/navigation.php' ?>
    <main class="container">
        <section class="row">
            <article class="col-lg-12">
                <h2>Les Bases de données (MySQL)</h2>
                <h3>Les fichiers de la bdd jeux vidéos</h3>
                <?php
                echo mkmapSimple("./dump");
                ?>
            </article>
            <article class="col-lg-12">
                <div class="row">
                    <h3>Les requêtes en SQL</h3>
                    <div class="col-lg-6">
                        <p>
                            Sélection dans la table jeux_video :
                        </p>
                        <code>
                            <p>
                                SELECT<br />
                                &nbsp;&nbsp;&nbsp;&nbsp;*<br />
                                FROM<br />
                                &nbsp;&nbsp;&nbsp;&nbsp;`jeux_video` as `jv` <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;-- as permet de créer des alias de nom de table;<br />
                            </p>
                        </code>
                        <p>
                            Selectionner dans une table selon des critères :
                        </p>
                        <code>
                            <p>
                                SELECT<br />
                                &nbsp;&nbsp;&nbsp;&nbsp;*<br />
                                FROM <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;`jeux_video` as `jv`<br />
                                WHERE <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;LOWER(`jv`.`console`) = LOWER('xbox') <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;-- la console est une xbox<br />
                                &nbsp;&nbsp;&nbsp;&nbsp;-- LOWER(`console`) LIKE LOWER('PS%') <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;-- la console commence par les lettres ps<br />
                                &nbsp;&nbsp;&nbsp;&nbsp;-- LOWER(`console`) LIKE LOWER('PS_') <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;-- la console contient 3 lettres et commence par ps<br />
                                &nbsp;&nbsp;&nbsp;&nbsp;-- LOWER(`console`) LIKE LOWER('%am%') <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;-- la console contient les lettres am<br />
                                &nbsp;&nbsp;&nbsp;&nbsp;-- LOWER(`possesseur`) = 'Florent' <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;-- le possesseur est Florent<br />
                                &nbsp;&nbsp;&nbsp;&nbsp;-- LOWER() permet de passer le contenu texte en minuscule<br />
                                ORDER BY<br />
                                &nbsp;&nbsp;&nbsp;&nbsp;-- ORDER BY permet d'ordonner par ordre, croissant par défaut (ou ASC)<br />
                                &nbsp;&nbsp;&nbsp;&nbsp;-- décroissant DESC<br />
                                &nbsp;&nbsp;&nbsp;&nbsp;`jv`.`nom` ASC;<br />
                            </p>
                        </code>
                    </div>
                    <div class="col-lg-6">
                        <p>
                            Selectionner avec des agrégations :
                        </p>
                        <code>
                            <p>
                                SELECT DISTINCT <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;`jv`.`id_possesseur`, <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;`jv`.`console`,<br />
                                &nbsp;&nbsp;&nbsp;&nbsp;COUNT(`nom`) as `nb_jeux-vendu`, <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;-- comptera le nombre de jeux vendu par console par id_possesseur<br />
                                &nbsp;&nbsp;&nbsp;&nbsp;SUM(`jv`.`prix`) as `total_vente`, <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;-- la somme des jeux vendu par console par id_possesseur<br />
                                &nbsp;&nbsp;&nbsp;&nbsp;AVG(`jv`.`prix`) as `moyenne_vente` <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;-- la moyenne de vente par console par id_possesseur<br />
                                FROM <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;`jeux_video` as `jv`<br />
                                GROUP BY <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;`jv`.`id_possesseur`,<br />
                                &nbsp;&nbsp;&nbsp;&nbsp;`jv`.`console`<br />
                                ORDER BY <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;`jv`.`id_possesseur`,<br />
                                &nbsp;&nbsp;&nbsp;&nbsp;`jv`.`console`;<br />
                            </p>
                        </code>
                        <p>
                            Selectionner dans des tables avec des jointures et de l'aggrégation :
                        </p>
                        <code>
                            <p>
                                SELECT DISTINCT <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;`p`.`prenom`, `p`.`nom`, `p`.`identifiant`, `p`.`email`, <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;COUNT(`jv`.`nom`) as `nb_jeux-vendu`, <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;-- comptera le nombre de jeux vendu par console par possesseur<br />
                                &nbsp;&nbsp;&nbsp;&nbsp;IFNULL(SUM(`jv`.`prix`), 0) as `total_vente` <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;-- la somme des jeux vendu par console par possesseur<br />
                                FROM <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;`possesseur` as `p` LEFT OUTER JOIN <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;`jeux_video` as `jv` ON `p`.`id` = `jv`.`id_possesseur` <br />
                                GROUP BY <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;`p`.`id`<br />
                                ORDER BY <br />
                                &nbsp;&nbsp;&nbsp;&nbsp;`p`.`id`;<br />
                            </p>
                        </code>
                        
                    </div>
                    
                </div>
            </article>
            <article class="col-lg-12">
                <div class="row">
                    <h2>Connexion à une bdd</h2>
                    <div class="col-lg-6">
                        <p>
                            Pour se connecter à une BDD, en utilisant MySqli, il faut utiliser la fonction <code>mysqli_connect()</code> qui demande les paramètres suivants :
                        </p>
                        <ul>
                            <li>L'hôte de la BDD (l'adresse du serveur de la BDD)</li>
                            <li>Un utilisateur autorisé à faire des modifications dans les tables de cette BDD</li>
                            <li>Le mot de passe de l'utillisateur de la BDD</li>
                            <li>Le nom de la BDD à laquelle on se connecte</li>
                            <li>Le port de connexion utilisé par la BDD</li>
                        </ul>
                        <p>
                            dans un fichier, ici nommé <code>sql.php</code>, nous allons définir des constantes qui contiendrons les information demandées comme ceci :
                        </p>
                        <p>
                            <code>
                            //Constantes de connexion à la bdd<br />
                            define('DBHOST', 'localhost');<br />
                            define('DBUSER', 'admin-php');<br />
                            define('DBPASS', 'admin');<br />
                            define('DBNAME', 'php-mysql-i-a');<br />
                            define('DBPORT', '3306');
                            </code>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <p>
                            Ensuite, il faut créer une fonction de connexion :
                        </p>
                        <p>
                            <code>
                                function openConn(){<br />
                                &nbsp;&nbsp;/* la fonction php mysqli_connect() a besoin des informations de connexion <br />
                                &nbsp;&nbsp;pour créer un objet qui servira à toutes les manipulations bdd */<br />
                                &nbsp;&nbsp;$conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME, DBPORT);<br />
                                &nbsp;&nbsp;if( !$conn ){<br />
                                &nbsp;&nbsp;&nbsp;&nbsp;echo 'Erreur de connexion : &lt;br /&gt;' . mysqli_connect_error() . '&lt;br /&gt;';<br />
                                &nbsp;&nbsp;}else{<br />
                                &nbsp;&nbsp;&nbsp;&nbsp;//echo 'Connexion bdd : ' . DBNAME . '&lt;br /&gt;';<br />
                                &nbsp;&nbsp;}<br />
        
                                &nbsp;&nbsp;return $conn;<br />
                                }
                            </code>
                        </p>
                        <p>
                            Il faut aussi penser, après l'ouverture d'une connexion, de fermer la connexion, en créant une fonction idoine.
                        </p>
                        <p>
                            <code>
                                function closeConn($conn){<br />
                                &nbsp;&nbsp;// fermeture de la connexion<br />
                                &nbsp;&nbsp;mysqli_close($conn);<br />
                                }
                            </code>
                        </p>
                        <p>
                            <?php
                            // création du lien vers la bdd en ouvrant la connexion
                            $link = openConn();
        
                            // fermeture du lien vers la bdd en fermant la connexion
                            closeConn($link);
                            ?>
                        </p>
                    </div>
                </div>
            </article>
            <article class="col-lg-12">
                <h2>Afficher tous les jeux</h2>
                <p>
                    <code>
                    SELECT <br />
                    &nbsp;&nbsp;`jv`.`id`, `jv`.`nom`, CONCAT(`p`.`prenom`, ' ', `p`.`nom`) as 'possesseur', <br />
                    &nbsp;&nbsp;`jv`.`console`, `jv`.`prix`, `jv`.`nbre_joueurs_max`, `jv`.`commentaires`, <br />
                    &nbsp;&nbsp;`jv`.`date_ajout`, `jv`.`date_modif` <br />
                    FROM <br />
                    &nbsp;&nbsp;`jeux_video` as `jv` Left JOIN <br />
                    &nbsp;&nbsp;`possesseur` as `p` ON `jv`.`id_possesseur` = `p`.`id` <br />
                    ORDER BY <br />
                    &nbsp;&nbsp;`p`.`prenom`, `p`.`nom` ASC;
                    </code>
                </p>
            </article>
            <article class="col-lg-12">
                <?php
                if (isset($_GET['message']) && $_GET['message'] === 'supressionKO') {
                    $id = (isset($_GET['id'])) ? $_GET['id'] : 'jeu introuvable';
                ?>
                    <div class="text-center alert alert-danger alert-dismissible fade show">
                        Impossible de supprimer le jeu avec l'id : <?php echo $_GET['id']; ?>
                        <a href="./mysql.php">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </a>
                    </div>
                <?php
                }
                ?>
                <p class="text-end">
                    <a href="./mysqlAdd.php?action=addGame">
                        <button class="btn btn-success">
                            Ajouter un jeu
                        </button>
                    </a>
                </p>
                <?php
                // création du lien vers la bdd en ouvrant la connexion
                $link = openConn();

                $sql = "
                SELECT 
                    `jv`.`id`, `jv`.`nom`, CONCAT(`p`.`prenom`, ' ', `p`.`nom`) as 'possesseur', 
                    `jv`.`console`, `jv`.`prix`, `jv`.`nbre_joueurs_max`, `jv`.`commentaires`, 
                    `jv`.`date_ajout`, `jv`.`date_modif` 
                FROM 
                    `jeux_video` as `jv` Left JOIN 
                    `possesseur` as `p` ON `jv`.`id_possesseur` = `p`.`id` 
                ORDER BY 
                    `p`.`prenom`, `p`.`nom` ASC;
                ";
                //variable de resultat = mysqli_query(lien de connexion vers la bdd, requête sql);
                $result = mysqli_query($link, $sql);

                $nbRows = mysqli_num_rows($result);
                if ($nbRows > 0) {
                ?>
                    <div class="limit-height">
                        <table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nom du jeu</th>
                                    <th>Possesseur</th>
                                    <th>Console</th>
                                    <th>Prix</th>
                                    <th>Nombre de joueurs max</th>
                                    <th>Commentaire</th>
                                    <th>Date Ajout</th>
                                    <th>Date Modif</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                    <tr>
                                        <td>
                                            <?php echo mb_convert_encoding($row['nom'], 'UTF-8'); ?> 
                                        </td>
                                        <td><?php echo mb_convert_encoding($row['possesseur'], 'UTF-8'); ?></td>
                                        <td><?php echo mb_convert_encoding($row['console'], 'UTF-8'); ?></td>
                                        <td><?php echo $row['prix']; ?></td>
                                        <td><?php echo $row['nbre_joueurs_max']; ?></td>
                                        <td>
                                            <?php echo mb_convert_encoding($row['commentaires'], 'UTF-8'); ?>
                                        </td>
                                        <td>
                                            <?php
                                            $dateAjout = date('d/m/Y', strtotime($row['date_ajout']));
                                            echo $dateAjout;
                                            $dateAjout = '';
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $dateAjout = date('d/m/Y', strtotime($row['date_modif']));
                                            echo $dateAjout;
                                            $dateAjout = '';
                                            ?>
                                        <td>
                                            <p>
                                                <a href="./mysqlDelete.php?id=<?php echo $row['id'] ?>">
                                                    <button class="btn btn-danger">
                                                        Supprimer
                                                    </button>
                                                </a>
                                            </p>
                                            <p>
                                                <a href="./mysqlUpdate.php?action=modGame&id=<?php echo $row['id'] ?>">
                                                    <button class="btn btn-success">
                                                        M.A.J.
                                                    </button>
                                                </a>
                                            </p>
                                        </td>
                                    </tr>
                                <?php endwhile ?>
                            </tbody>
                        </table>
                    </div>
                <?php
                }
                // fermeture du lien vers la bdd en fermant la connexion
                closeConn($link);
                ?>
            </article>
        </section>
    </main>
    <?php include './includes/footer.php' ?>
</body>

</html>