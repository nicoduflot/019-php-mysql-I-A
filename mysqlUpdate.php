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
            <article class="offset-4 col-md-4">
                <?php if (isset($_GET['action']) && $_GET['action'] === 'modGame' && $_GET['id'] != '') : ?>
                    <?php
                    // requête de vérification de présence de la donnée a supprimer
                    $link = openConn();
                    $idJV = mysqli_real_escape_string($link, $_GET['id']);
                    /*
                    $sql = '
                    SELECT 
                        *
                    FROM
                        `jeux_video` as `jv` 
                    WHERE `jv`.`ID` = '. $idJV .';
                        ';
                    */
                    
                    $sql = "
                        SELECT 
                            `jv`.`id`, `jv`.`nom`, `jv`.`id_possesseur`, CONCAT(`p`.`prenom`, ' ', `p`.`nom`) as 'possesseur', 
                            `jv`.`console`, `jv`.`prix`, `jv`.`nbre_joueurs_max`, `jv`.`commentaires`, 
                            `jv`.`date_ajout`, `jv`.`date_modif` 
                        FROM 
                            `jeux_video` as `jv` Left JOIN 
                            `possesseur` as `p` ON `jv`.`id_possesseur` = `p`.`id` 
                        WHERE `jv`.`ID` = '". $idJV ."';
                        ";

                    $result = mysqli_query($link, $sql);

                    $nbRows = mysqli_num_rows($result);
                    if ($nbRows > 0) {
                        if($row = mysqli_fetch_assoc($result)){
                            $nom = mysqli_real_escape_string($link, mb_convert_encoding($row['nom'], 'UTF-8'));
                            //$possesseurId = mysqli_real_escape_string($link, mb_convert_encoding($row['possesseur'], 'UTF-8'));
                            $id_possesseur = $row['id_possesseur'];
                            $console = mysqli_real_escape_string($link, $row['console']);
                            $prix = $row['prix'];
                            $nbjm = $row['nbre_joueurs_max'];
                            $commentaires = mysqli_real_escape_string($link, mb_convert_encoding($row['commentaires'], 'UTF-8'));
                        }else{
                            $nom = '';
                            //$possesseurId = '';
                            $id_possesseur = '';
                            $console = '';
                            $prix = '';
                            $nbjm = '';
                            $commentaires = '';
                        }
                        
                    }else{
                        $nom = '';
                        //$possesseurId = '';
                        $id_possesseur = '';
                        $console = '';
                        $prix = '';
                        $nbjm = '';
                        $commentaires = '';
                    }

                    $sql = '
                    SELECT DISTINCT
                        `p`.`prenom`, `p`.`nom`, `p`.`id` 
                    FROM
                        `possesseur` as `p` 
                        -- as permet de créer des alias de nom de table
                    ORDER BY `p`.`prenom`, `p`.`nom` ASC;
                        ';
                    //variable de resultat = mysqli_query(lien de connexion vers la bdd, requête sql);
                    $result = mysqli_query($link, $sql);
                    //var_dump($result);
                    $nbRows = mysqli_num_rows($result);
                    if ($nbRows > 0) {
                        $selectPossesseur = '<select class="form-select" name="possesseur">';
                        while ($row = mysqli_fetch_assoc($result)) {
                            $selectPossesseur .= '<option value="' . $row['prenom'] . '|' . $row['id'] . '"';
                            if($row['id'] == $id_possesseur){
                                $selectPossesseur .= ' selected ';
                            }
                            $selectPossesseur .= '>' . mb_convert_encoding($row['prenom'], 'UTF-8')
                                . " "
                                . mb_convert_encoding($row['nom'], 'UTF-8')
                                . '</option>';
                        }
                        $selectPossesseur .= '</select>';
                    }

                    $sql = '
                    SELECT DISTINCT
                        `jv`.`console`
                    FROM
                        `jeux_video` as `jv` 
                        -- as permet de créer des alias de nom de table
                    ORDER BY `jv`.`console` ASC;
                        ';

                    $result = mysqli_query($link, $sql);
                    
                    $nbRows = mysqli_num_rows($result);
                    if ($nbRows > 0) {
                        $selectConsole = '<select class="form-select" name="console">';
                        while ($row = mysqli_fetch_assoc($result)) {
                            $selectConsole .= '<option value="' . $row['console'] . '" 
                            ' . ( ($row['console'] == $console)? ' selected ' : '' ) . '>'
                                . mb_convert_encoding($row['console'], 'UTF-8')
                                . '</option>';
                        }
                        $selectConsole .= '</select>';
                    }

                    
                    ?>
                    <h2 class="text-center">
                        Modification du jeu 
                    </h2>
                    <form method="post" action="./mysqlUpdate.php">
                        <input type="hidden" name="ID" value="<?php echo $idJV ?>" />
                        <p>
                            <label class="form-label" for="nom">Nom du jeu</label>
                            <input class="form-control" type="text" name="nom" value="<?php echo $nom ?>" required />
                        </p>
                        <p>
                            <label class="form-label" for="possesseur">Possesseur</label>
                            <?php echo $selectPossesseur ?>
                        </p>
                        <p>
                            <label class="form-label" for="console">Console</label>
                            <?php echo $selectConsole ?>
                        </p>
                        <p>
                            <label class="form-label" for="prix">Prix</label>
                            <input class="form-control" type="number" name="prix" value="<?php echo $prix ?>" />
                        </p>
                        <p>
                            <label class="form-label" for="nbjm">Nombre de joueurs max</label>
                            <input class="form-control" type="number" name="nbjm" value="<?php echo $nbjm ?>" />
                        </p>
                        <p>
                            <label class="form-label" for="commentaires">Commentaires</label>
                            <textarea class="form-control" name="commentaires"><?php echo $commentaires ?></textarea>
                        </p>
                        <p class="text-center">
                            <button type="submit" name="confirm" value="true" class="btn btn-success">
                                METTRE À JOUR
                            </button>
                            <button type="reset" name="reset" class="btn btn-warning">
                                VIDER LE FORMULAIRE
                            </button>
                        </p>
                    </form>
                    <p class="text-center">
                        <a href="./mysql.php">
                            <button name="cancel" class="btn btn-outline-warning">
                                ANNULER LA M.A.J.
                            </button>
                        </a>
                    </p>
                    <?php

                    closeConn($link);
                    ?>
                <?php else : ?>
                    <?php if (isset($_POST['confirm']) && $_POST['confirm'] === 'true') : ?>
                        <p>on ajoute le jeu</p>
                        <p>
                        <?php
                        $link = openConn();
                        $idJv = mysqli_real_escape_string($link, $_POST['ID']);
                        $nom = mysqli_real_escape_string($link, $_POST['nom']);
                        $possesseurId = explode('|', mysqli_real_escape_string($link, $_POST['possesseur']));
                        $possesseur = $possesseurId[0];
                        $id_possesseur = $possesseurId[1];
                        $console = mysqli_real_escape_string($link, $_POST['console']);
                        $prix = $_POST['prix'];
                        $nbjm = $_POST['nbjm'];
                        $commentaires = mysqli_real_escape_string($link, $_POST['commentaires']);
                        
                        $sql = '
                        UPDATE 
                            `jeux_video` 
                            SET 
                            `nom` = \'' . $nom . '\', 
                            `id_possesseur` = '. $id_possesseur .', 
                            `console` = \'' . $console . '\', 
                            `prix` = '.$prix.', 
                            `nbre_joueurs_max` = '.$nbjm.', 
                            `commentaires` = \'' . $commentaires . '\', 
                            `date_modif` = CURRENT_TIMESTAMP
                        WHERE
                        `jeux_video`.`ID` = ' . $idJv . '
                        ';
                        
                        if(mysqli_query($link, $sql)){
                            ?>
                            <div class="text-center alert alert-success">
                                Le jeu : <?php echo mb_convert_encoding($nom, 'UTF-8'); ?> a bien été modifié
                            </div>
                            <p class="text-center">
                                <a href="./mysql.php">
                                    <button class="btn btn-outline-success">
                                        Retour à la liste des jeux
                                    </button>
                                </a>
                            </p>
                            <?php
                        }else{
                            ?>
                            <div class="text-center alert alert-danger">
                                Le jeu : <?php echo mb_convert_encoding($nom, 'UTF-8'); ?> n'a pu être modifié
                            </div>
                            <p class="text-center">
                                <a href="./mysql.php">
                                    <button class="btn btn-outline-warning">
                                        Retour à la liste des jeux
                                    </button>
                                </a>
                            </p>
                            <?php
                        }
                        
                        closeConn($link);
                        ?>
                        </p>
                    <?php else : ?>
                        <?php
                        //header('location: ./mysql.php?message=addKO');
                        //exit();
                        ?>
                    <?php endif ?>
                <?php endif ?>
            </article>
        </section>
    </main>
    <?php include './includes/footer.php' ?>
</body>

</html>