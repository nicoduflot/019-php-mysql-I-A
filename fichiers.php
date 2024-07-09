<?php
session_start();
include './includes/functions.php';

$messageUpload = '';
$upload = false;
$uploadOk = false;
if (isset($_POST['submitForm']) && $_POST['submitForm'] === 'Envoyer') {
    $upload = true;
    $uploadDir = './uploads/';
    // les information du fichier se trouvent dans la superglobale $_FILES
    //var_dump($_FILES);
    $uploadFile = $uploadDir . basename($_FILES['fichier']['name']);
    //var_dump($uploadFile);
    try {
        if (move_uploaded_file($_FILES["fichier"]["tmp_name"], $uploadFile)) {
            $messageUpload = "le fichier " . $_FILES["fichier"]["name"] .
                " a bien été téléversé<br />";
            $uploadOk = true;
        } else {
            throw new Exception('le fichier ' . $_FILES["fichier"]["name"] . ' n\'a pas bien été téléversé');
        }
    } catch (Exception $e) {
        $messageUpload = $e->getMessage() . '<br />' . $e->getLine() . '<br />';
    }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Formation php - <?php echo 'Fichiers'; ?></title>
    <?php include './includes/appels.php' ?>
    <style>
        .limit-height {
            max-height: 40vh;
            overflow: auto;
        }
    </style>
</head>

<body>
    <?php include './includes/header.php' ?>
    <?php include './includes/navigation.php' ?>
    <main class="container">
        <section class="row">
            <article class="col-md-6 col-lg-12">
                <h2>Les fichiers</h2>
                <h3>Ouvrir et fermer un fichier</h3>
                <p>
                    Pour ouvrir et fermer un fichier, on va utiliser les fonctions suivantes :
                </p>
                <ul>
                    <li>fopen()</li>
                    <li>fclose()</li>
                </ul>
                <?php
                if (!$monFichierTexte = fopen('./files/file.txt', 'r')) {
                    echo 'Fichier non trouvé<br />';
                    exit();
                } else {
                    echo 'Fichier trouvé<br />';
                    var_dump($monFichierTexte);
                    fclose($monFichierTexte);
                }
                ?>
            </article>
            <article class="col-lg-6">
                <h3>Lire la totalité d'un fichier</h3>
                <p class="limit-height ">
                    <?php
                    if (!$monFichierTexte = fopen('./files/file.txt', 'r')) {
                        echo 'Fichier non trouvé<br />';
                        exit();
                    } else {
                        echo 'Fichier trouvé<br />';
                        var_dump($monFichierTexte);
                        $monFichierRecupere = fread($monFichierTexte, filesize('./files/file.txt'));
                        $monFichierRecupere = nl2br($monFichierRecupere);
                        echo $monFichierRecupere;
                        fclose($monFichierTexte);
                    }
                    ?>
                </p>
            </article>
            <article class="col-lg-6">
                <h3>Lire un fichier partiellement</h3>
                <p>
                    fgets() lire ou la ligne du fichier (sans option) ou le nombre de caractère indiqué après le chemin du fichier
                </p>
                <p class="limit-height">
                    <?php
                    if (!$monFichierTexte = fopen('./files/file.txt', 'r')) {
                        echo 'Fichier non trouvé<br />';
                        exit();
                    } else {
                        echo 'Fichier trouvé<br />';
                        echo fgets($monFichierTexte, 10) . '<br />';
                        echo fgets($monFichierTexte, 10) . '<br />';
                        echo fgets($monFichierTexte) . '<br />';
                        echo fgets($monFichierTexte) . '<br />';
                        echo fgets($monFichierTexte) . '<br />';
                        echo fgets($monFichierTexte) . '<br />';
                    }
                    ?>
                </p>
                <h3>La fin de fichier</h3>
                <p>
                    feof()
                </p>
                <p class="limit-height">
                <?php
                while (!feof($monFichierTexte)) {
                    echo fgets($monFichierTexte) . '<br />';
                }
                fclose($monFichierTexte);
                ?>
                </p>
            </article>
            <article class="limit-height col-lg-6">
                <h3>Simulation d'un fichier wiki</h3>
                <p>
                    [title]Mon super fichier wiki[/title]<br />
                    [p]<br />
                    &nbsp;&nbsp;&nbsp;&nbsp;[g]en gras[/g], en [i]italique[/i].<br />
                    [/p]<br />
                    [p]<br />
                    &nbsp;&nbsp;&nbsp;&nbsp;une liste<br />
                    [/p]<br />
                    [liste]<br />
                    &nbsp;&nbsp;&nbsp;&nbsp;[li]1er élément[/li]<br />
                    &nbsp;&nbsp;&nbsp;&nbsp;[li]2ème élément[/li]<br />
                    &nbsp;&nbsp;&nbsp;&nbsp;[li]3ème élément[/li]<br />
                    &nbsp;&nbsp;&nbsp;&nbsp;[li]Dernier élément[/li]<br />
                    [/liste]<br />

                </p>
                <p>
                    <?php
                    if (!$monFichierTexte = fopen('./files/wikiTest.txt', 'r')) {
                        echo 'Fichier non trouvé<br />';
                        exit();
                    } else {
                        echo 'Fichier trouvé<br />';
                        var_dump($monFichierTexte);
                        echo decodeWiki(fread($monFichierTexte, filesize('./files/wikiTest.txt')));
                        fclose($monFichierTexte);
                    }
                    ?>
                </p>
            </article>
            <article class="limit-height col-lg-6">
                <h2>Upload (téléversement) de fichier</h2>
                <?php if ($upload) : ?>
                    <div class="alert <?php echo ($uploadOk) ? ' alert-success' : ' alert-warning' ?> alert-dismissible fade show" role="alert">
                        <?php echo $messageUpload ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif ?>
                <form method="POST" action="./fichiers.php" enctype="multipart/form-data">
                    <input type="hidden" name="MAX_FILE_SIZE" value="700000" />
                    <p>
                        <label for="fichier" class="form-label">Fichier :</label>
                        <input type="file" class="form-control" name="fichier" />
                    </p>
                    <p class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-outline-success btn-sm" name="submitForm" value="Envoyer">
                            charger le fichier
                        </button>
                        <button type="reset" class="btn btn-outline-warning btn-sm">
                            annuler
                        </button>
                    </p>
                </form>
                <div>
                    <?php
                    echo mkmapSimple("./uploads");
                    ?>
                </div>
            </article>
        </section>
    </main>
    <?php include './includes/footer.php' ?>
</body>

</html>