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
                <?php if (isset($_GET['action']) && $_GET['action'] === 'addGame') : ?>
                    <?php
                    // requête de vérification de présence de la donnée a supprimer
                    $link = openConn();

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
                            $selectPossesseur .= '<option value="' . $row['prenom'] . '|' . $row['id'] . '">'
                                . mb_convert_encoding($row['prenom'], 'UTF-8')
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
                    //variable de resultat = mysqli_query(lien de connexion vers la bdd, requête sql);
                    $result = mysqli_query($link, $sql);
                    //var_dump($result);
                    $nbRows = mysqli_num_rows($result);
                    if ($nbRows > 0) {
                        $selectConsole = '<select class="form-select" name="console">';
                        while ($row = mysqli_fetch_assoc($result)) {
                            $selectConsole .= '<option value="' . $row['console'] . '">'
                                . mb_convert_encoding($row['console'], 'UTF-8')
                                . '</option>';
                        }
                        $selectConsole .= '</select>';
                    }

                    ?>
                    <h2 class="text-center">
                        Ajout d'un jeu
                    </h2>
                    <form method="post" action="./mysqlAdd.php">
                        <p>
                            <label class="form-label" for="nom">Nom du jeu</label>
                            <input class="form-control" type="text" name="nom" required />
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
                            <input class="form-control" type="number" name="prix" value="0" />
                        </p>
                        <p>
                            <label class="form-label" for="nbjm">Nombre de joueurs max</label>
                            <input class="form-control" type="number" name="nbjm" value="1" />
                        </p>
                        <p>
                            <label class="form-label" for="commentaires">Commentaires</label>
                            <textarea class="form-control" name="commentaires"></textarea>
                        </p>
                        <p class="text-center">
                            <button type="submit" name="confirm" value="true" class="btn btn-success">
                                AJOUTER LE JEU
                            </button>
                            <button type="reset" name="reset" class="btn btn-warning">
                                VIDER LE FORMULAIRE
                            </button>
                        </p>
                    </form>
                    <p class="text-center">
                        <a href="./mysql.php">
                            <button name="cancel" class="btn btn-outline-warning">
                                ANNULER L'AJOUT
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
                        $nom = mysqli_real_escape_string($link, $_POST['nom']);
                        $possesseurId = explode('|', mysqli_real_escape_string($link, $_POST['possesseur']));
                        $possesseur = $possesseurId[0];
                        $id_possesseur = $possesseurId[1];
                        $console = mysqli_real_escape_string($link, $_POST['console']);
                        $prix = $_POST['prix'];
                        $nbjm = $_POST['nbjm'];
                        $commentaires = mysqli_real_escape_string($link, $_POST['commentaires']);
                        
                        $sql = '
                        INSERT INTO 
                            `jeux_video` 
                            (`nom`, `id_possesseur`, `console`, `prix`, '
                            .'`nbre_joueurs_max`, `commentaires`, `date_ajout`, `date_modif`) 
                            VALUES
                            (\'' . $nom . '\', '. $id_possesseur .' ,\'' 
                            . $console . '\', '.$prix.', '.$nbjm.', \'' . $commentaires 
                            . '\', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);';
                        
                        if(mysqli_query($link, $sql)){
                            ?>
                            <div class="text-center alert alert-success">
                                Le jeu : <?php echo mb_convert_encoding($nom, 'UTF-8', 'ISO-8859-1'); ?> a bien été créé
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
                                Le jeu : <?php echo mb_convert_encoding($nom, 'UTF-8', 'ISO-8859-1'); ?> n'a pu être créé
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