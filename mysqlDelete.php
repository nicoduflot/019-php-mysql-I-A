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
                <?php if( isset( $_GET['id'] ) && $_GET['id'] != '') : ?>
                    <?php
                    // requête de vérification de présence de la donnée a supprimer
                    $link = openConn();

                    $sql = '
                    SELECT
                        `jv`.`nom`
                    FROM
                        `jeux_video` as `jv` 
                        -- as permet de créer des alias de nom de table
                    WHERE 
                        `jv`.`ID` = '.$_GET['id'] .';
                        ';
                    //variable de resultat = mysqli_query(lien de connexion vers la bdd, requête sql);
                    $result = mysqli_query($link, $sql);
                    //var_dump($result);
                    $nbRows = mysqli_num_rows($result);
                    if($nbRows > 0){
                        $row = mysqli_fetch_assoc($result);
                        ?>
                        <div class="text-center">
                            Êtes-vous sûr de vouloir supprimer <?php echo $row['nom'] ?> ?
                        </div>
                        <form method="post" action="./mysqlDelete.php">
                            <p class="text-center">
                                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" />
                                <input type="hidden" name="nom" value="<?php echo $row['nom'] ?>" />
                                <button type="submit" name="confirm" value="true" class="btn btn-danger">
                                    CONFIRMER LA SUPPRESSION
                                </button>
                            </p>
                        </form>
                        <p class="text-center">
                            <a href="./mysql.php">
                                <button name="cancel" class="btn btn-outline-warning">
                                    ANNULER LA SUPPRESSION
                                </button>
                            </a>
                        </p>
                        <?php
                    }else{
                        closeConn($link);
                        header('location: ./mysql.php?message=supressionKO&id='.$_GET['id']);
                        exit();
                    }
                    closeConn($link);
                    ?>
                <?php else : ?>
                    <?php if( isset( $_POST['id'] ) && $_POST['id'] != '' && $_POST['confirm'] === 'true') : ?>
                        on confirme le kill
                        <?php
                        $nom = $_POST['nom'];
                        $link = openConn();
                        $id = mysqli_real_escape_string($link, $_POST['id']);
                        $sql = 'DELETE FROM `jeux_video` WHERE `ID` = '. $id . ';';
                        if(mysqli_query($link, $sql)){
                            ?>
                            <div class="text-center alert alert-success">
                                Le jeu : <?php echo mb_convert_encoding($nom, 'UTF-8', 'ISO-8859-1'); ?> a bien été supprimé
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
                                Le jeu : <?php echo mb_convert_encoding($nom, 'UTF-8', 'ISO-8859-1'); ?> n'a pu être supprimé ou 
                                a déjà été supprimé
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
                    <?php else : ?>
                        <?php 
                        header('location: ./mysql.php?message=supressionKO&id='.$_GET['id']);
                        exit();
                        ?>
                    <?php endif ?>
                <?php endif ?>
            </article>
        </section>
    </main>
    <?php include './includes/footer.php' ?>
</body>

</html>