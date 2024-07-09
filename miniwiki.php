<?php

session_start();
include "./includes/functions.php";
$creationFichier = false;
$creaFichierOk = false;
$messageCrea = "";
$titre = "";
$wikinote = "";
$fileEdit = "";
$wikistatus = "create";
//vérification de création / modification d'une note
if (isset($_POST["subNote"]) && $_POST["subNote"] === "Envoyer") {
    $titre = $_POST["titre"];
    $wikinote = $_POST["wikinote"];
    $fileEdit = $_POST["editFile"];
    $creationFichier = true;
    //var_dump($_POST);
    if ($titre !== "") {
        //si en création
        if ($fileEdit === "") {
            $repAnnee = date("Y");
            $repMois = date("m");
            $prefixeNote = date("d-h-i");
            //création du répertoire année s'il n'existe pas
            if (!file_exists("./wiki/" . $repAnnee)) {
                mkdir("./wiki/" . $repAnnee, 0777);
            }
            //création du répertoire mois s'il n'existe pas
            if (!file_exists("./wiki/" . $repAnnee . "/" . $repMois)) {
                mkdir("./wiki/" . $repAnnee . "/" . $repMois, 0777);
            }
            //création du fichier texte
            if (!$fichier = fopen("./wiki/" . $repAnnee . "/" . $repMois . "/" . $prefixeNote . "-" . slugTitle($titre) . ".txt", "w+")) {
                //$messageCrea = $messageCrea . "xcvvbb";
                $messageCrea .= "impossible d'écrire dans le fichier : " .
                    "<q>./wiki/" . $repAnnee . "/" . $repMois . "/" . $prefixeNote . "-" . slugTitle($titre) . ".txt</q>";
                exit();
            } else {
                $creaFichierOk = true;
            }
            //écriture dans le fichier texte
            //fwrite qui soit écrit dans le fichier et renvoie true, soit renvoi false
            if (!fwrite($fichier, "[title]" . $titre . "[/title]\n")) {
                $messageCrea .= "impossible d'écrire dans le fichier : " .
                    "<q>./wiki/" . $repAnnee . "/" . $repMois . "/" . $prefixeNote . "-" . slugTitle($titre) . ".txt</q>";
                $creaFichierOk = false;
                exit();
            } else {
                $creaFichierOk = true;
            }

            if (!fwrite($fichier, $wikinote)) {
                $messageCrea .= "impossible d'écrire dans le fichier : " .
                    "<q>./wiki/" . $repAnnee . "/" . $repMois . "/" . $prefixeNote . "-" . slugTitle($titre) . ".txt</q>";
                $creaFichierOk = false;
                exit();
            } else {
                $creaFichierOk = true;
            }
            $messageCrea .= "la wikinote a bien été créé";
            fclose($fichier);
        } else {
            //si en édition
            prePrint($fileEdit);
            if (!$wikiFic = fopen($fileEdit, "w+")) {
                exit();
            } else {
                if (!fwrite($wikiFic, "[title]" . $titre . "[/title]\n")) {
                    $messageCrea .= "impossible d'écrire dans le fichier : " .
                        "<q>" . $wikiFic . "</q>";
                    $creaFichierOk = false;
                    exit();
                } else {
                    $creaFichierOk = true;
                }

                if (!fwrite($wikiFic, $wikinote)) {
                    $messageCrea .= "impossible d'écrire dans le fichier : " .
                        "<q>" . $wikiFic . "</q>";
                    $creaFichierOk = false;
                    exit();
                } else {
                    $creaFichierOk = true;
                }
                $messageCrea .= "la wikinote <q>" . $fileEdit . "</q> a bien été modifiée";
                $titre = "";
                $wikinote = "";
                $fileEdit = "";
                fclose($wikiFic);
            }
        }
    } else {
        $messageCrea .= "La note ne comporte pas de titre";
    }
}
//éditer la note dans le formulaire
if (
    isset($_GET["wikinote"]) && $_GET["wikinote"] !== ""
    && isset($_GET["edit"]) && $_GET["edit"] === "true"
) {
    //var_dump($_GET);
    $fileEdit = $_GET["wikinote"];
    if (!$wikiFic = fopen($_GET["wikinote"], "r")) {
        exit();
    } else {
        $wikistatus = "edit";
        $titre = fgets($wikiFic);
        $titre = str_replace("[title]", "", $titre);
        $titre = str_replace("[/title]", "", $titre);
        while (!feof($wikiFic)) {
            $wikinote .= fgets($wikiFic);
        }
        fclose($wikiFic);
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Formation php - <?php echo 'Miniwiki';  ?></title>
    <?php include './includes/appels.php' ?>
</head>

<body>
    <?php include './includes/header.php' ?>
    <?php include './includes/navigation.php' ?>
    <main class="container">
        <section class="row">
            <article class="col-lg-6">
                <h2>Markup du Wiki</h2>
                <div class="alert alert-success">
                    <p>
                        [title]titre h2[/title]
                    </p>
                    <p>
                    <span class="h2">titre h2</span>
                    </p>
                    <p>
                        [g]  gras [/g]
                    </p>
                    <p>
                        <b>gras</b>
                    </p>
                    <p>
                        [i] italique [/i]
                    </p>
                    <p>
                        <i> italique </i>
                    </p>
                    <p>
                        [p] Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quod tempore qui hic magnam fugiat, ducimus fugit repudiandae eos, ut nesciunt commodi impedit ea ipsa itaque veritatis beatae a! Facilis, aliquam. [/p]
                    </p>
                    <p>
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quod tempore qui hic magnam fugiat, ducimus fugit repudiandae eos, ut nesciunt commodi impedit ea ipsa itaque veritatis beatae a! Facilis, aliquam.
                    </p>
                    <p>
                        [liste]<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;[li] élément [/li]<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;[li] élément [/li]<br />
                        &nbsp;&nbsp;&nbsp;&nbsp;[li] élément [/li]<br />
                        [/liste]
                    </p>
                    <ul>
                        <li> élément </li>
                        <li> élément </li>
                        <li> élément </li>
                    </ul>
                </div>
            </article>
            <article class="col-lg-6">
                <h2>
                    <?php
                    echo ($wikistatus === 'create') ? 'Créer' : 'Editer';
                    ?>
                    une note de wiki</h2>
                    <?php
                    if($wikistatus === 'edit'){
                        ?>
                        <p>
                        <a href="./miniwiki.php">Annuler l'édition de la note</a>
                        </p>
                        <?php
                    }
                    ?>
                <?php if ($creationFichier) : ?>
                    <div class="alert 
                <?php echo ($creaFichierOk) ? " alert-success" : " alert-warning"; ?>
                alert-dismissible fade show" role="alert">
                        <?php echo $messageCrea; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif ?>
                <form method="post" action="./miniwiki.php">
                    <p>
                        <input type="text" class="form-control" name="titre" placeholder="Titre de la note" value="<?php echo $titre ?>" />
                    </p>
                    <p>
                        <textarea class="form-control" name="wikinote" placeholder="Votre note ici :" rows="15"><?php echo $wikinote ?></textarea>
                    </p>
                    <input type="hidden" name="editFile" value="<?php echo $fileEdit ?>" />
                    <p>
                        <button type="submit" name="subNote" value="Envoyer" class="btn btn-success bouton-validation">
                            <?php
                            echo ($wikistatus === 'create') ? 'Créer' : 'Editer';
                            ?> la note
                        </button>
                        <button type="reset" name="resetForm" value="Annuler" class="btn btn-warning">
                            Vider le formulaire
                        </button>
                    </p>
                </form>
            </article>
            <article class="col-lg-6">
                <h2>Archives des notes</h2>
                <?php
                echo mkmap("./wiki");
                ?>
            </article>
            <div class="col-lg-6">
                <?php
                if (isset($_GET["wikinote"]) && $_GET["wikinote"] !== "" && !isset($_GET["edit"])) {
                    ?>
                    <h2>Afficher la note</h2>
                    <p>
                        <a href="./miniwiki.php">Vider le panneau de la note</a>
                    </p>
                    <?php
                    //var_dump($_GET);
                    if (!$wikiFic = fopen($_GET["wikinote"], "r")) {
                ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            Le fichier <?php echo $_GET["wikinote"] ?> n'existe pas !
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                    } else {
                    ?>
                        <article class="col-lg-12">
                            <?php echo decodeWiki(fread($wikiFic, filesize($_GET["wikinote"]))) ?>
                        </article>
                <?php
                        fclose($wikiFic);
                    }
                }
                ?>
            </div>
        </section>
    </main>
    <?php include './includes/footer.php' ?>
</body>
</html>