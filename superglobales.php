<?php
/**
 * Pour pouvoir utiliser la superglobale de session
 * $_SESSION, il faut en toute première instruction de la page, 
 * démarrer la session
 */
session_start();
include './includes/functions.php';

if( isset($_GET['sessionDestroy']) && $_GET['sessionDestroy'] === 'true'){
    session_destroy();
    header('location: ./superglobales.php');
    exit();
}

/*
var_dump($_SESSION);
$tabSso = [ 'clef1' => 'valeur1', 'clef2' => 'valeur2'];
$_SESSION['nom'] = 'Duflot';
unset($_SESSION['nom']);
var_dump($_SESSION);
*/

// vérifier si on viens d'un envoi du formulaire

//initialisation des variables pour le formulaire quand on ne vient pas
// de la soumission du form

//var_dump($_GET);
if( isset($_GET['manageMonster']) ){
    $manageMonster = $_GET['manageMonster'];
    switch($manageMonster){
        case 'true':
            // nom du cookie, valeur du cookie, timestamp de la date d'expiration du cookie, chemin où le cookie peut être lu et utilisé,
            // domaine où le cookie peut être utilisé, cookie utilisable uniquement en HTTPS, cookie utilisable uniquement en HTTP
            setcookie('monster', 42, time()+(60*60), '/019-php-mysql-I-A', 'localhost', null, null);
            header('location: ./superglobales.php');
            exit();
            break;
        case 'update':
            if( isset( $_COOKIE['monster'] )){
                setcookie('monster', 'H2G2', time()+(60*60), '/019-php-mysql-I-A', 'localhost', null, null);
            }
            header('location: ./superglobales.php');
            exit();
            break;
        case 'false':
            if( isset( $_COOKIE['monster'] )){
                setcookie('monster', 'H2G2', time()-(60*60), '/019-php-mysql-I-A', 'localhost', null, null);
            }
            header('location: ./superglobales.php');
            exit();
            break;
        default: 
            header('location: ./superglobales.php');
            exit();
    }
}


$civilite = '';
$nom = '';
$prenom = '';
$age = '';
$editor = 'Veuillez entrez votre histoire';

if (isset($_POST['submitForm']) && $_POST['submitForm'] === 'Envoyer') {
    //var_dump($_POST);
    $errorForm = false;
    $civilite = (isset($_POST['civilite'])) ? $_POST['civilite'] : '';
    if (!isset($_POST['nom']) || $_POST['nom'] === '') {
        $errorForm = true;
    } else {
        $nom = (isset($_POST['nom'])) ? $_POST['nom'] : '';
    }

    $prenom = (isset($_POST['prenom'])) ? $_POST['prenom'] : '';
    $age = (isset($_POST['age'])) ? $_POST['age'] : '';

    $editor = (isset($_POST['editor'])) ? $_POST['editor'] : '';

    if (!$errorForm) {
        $_SESSION['civilite'] = $civilite;
        $_SESSION['nom'] = $nom;
        $_SESSION['prenom'] = $prenom;
        $_SESSION['age'] = $age;
        $_SESSION['editor'] = $editor;
    }
}

$a = 'coucou';

function coucouToi(){
    $a = $GLOBALS['a'];
    $varTest = 'YES !';
    echo $a . ' toi<br />';
}

for($i = 0; $i < 5; $i++){
    //
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Formation php - <?php echo 'Superglobales'; ?></title>
    <?php include './includes/appels.php' ?>
    <style>
        .limit-height {
            max-height: 20vh;
            overflow: auto;
        }
    </style>
</head>

<body>
<?php include './includes/header.php' ?>
    <?php include './includes/navigation.php' ?>
    <main class="container">
        <section class="row">
            <article class="col-lg-6">
                <h2>Renseigner la session avec des données</h2>
                <?php
                $civilites = [
                    '0' => 'Choisir une civilité',
                    'M.' => 'Monsieur',
                    'Mme' => 'Madame',
                    'NB' => 'Non binaire'
                ];
                ?>
                <form method="post">
                    <fieldset>
                        <legend>Civilité</legend>
                        <p>
                            <label for="civilite" class="form-label">
                                Civilité :
                            </label>
                            <select name="civilite" id="civilite" class="form-select">
                                <?php foreach ($civilites as $clef => $valeur) : ?>
                                    <option value="<?php echo $clef ?>" 
                                    <?php echo (isset($_SESSION['civilite']) && $_SESSION['civilite'] === $clef) ? ' selected' : ''; ?>><?php echo $valeur ?></option>
                                <?php endforeach ?>
                                <?php
                                /*
                                remplace : 
                                <?php 
                                foreach($civilites as $clef => $valeur){ 
                                    ?>
                                    <option value="<?php ?>"><?php ?></option>
                                    <?php 
                                }    
                                ?>
                                */
                                ?>
                            </select>
                        </p>
                        <p>
                            <label for="nom" class="form-label">
                                Nom :
                            </label>
                            <input type="text" class="form-control" name="nom" id="nom" value="<?php echo (isset($_SESSION['nom'])) ? $_SESSION['nom'] : '' ?>" required />
                        </p>
                        <p>
                            <label for="prenom" class="form-label">
                                Prénom :
                            </label>
                            <input type="text" class="form-control" name="prenom" id="prenom" value="<?php echo (isset($_SESSION['prenom'])) ? $_SESSION['prenom'] : '' ?>" />
                        </p>
                        <p>
                            <label for="age" class="form-label">
                                Age :
                            </label>
                            <input type="number" class="form-control" name="age" id="age" min="13" max="120" step="1" value="<?php echo (isset($_SESSION['age'])) ? $_SESSION['age'] : '' ?>" />
                        </p>
                        <textarea name="editor" id="editor"><?php
                            echo (isset($_SESSION['editor'])) ? $_SESSION['editor'] : '';
                        ?></textarea>
                        <script>
                            CKEDITOR.replace('editor');
                        </script>
                    </fieldset>
                    <p class="d-flex justify-content-between my-2">
                        <button type="submit" class="btn btn-outline-success btn-sm" name="submitForm" value="Envoyer">
                            Soumettre le formulaire
                        </button>
                        <button type="reset" class="btn btn-outline-warning btn-sm">
                            Remettre le formulaire à 0
                        </button>
                    </p>
                </form>
            </article>
            <article class="col-lg-6">
                <h2>Contenu de la session</h2>
                <?php
                if (isset($_SESSION) && count($_SESSION) > 0 ) {
                    var_dump($_SESSION);
                    foreach ($_SESSION as $label => $content) {
                        ?>
                        <div class="row">
                            <label class="col-lg-2 text-break">
                                <span class="text-uppercase"><b><?php echo $label ?></b></span>
                            </label>
                            <div class="col-lg-10">
                                <?php echo $content ?>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    var_dump($_SESSION);
                    ?>
                    <div class="row">
                        <div class="alert alert-warning alert-dismissible fade show col-lg-12" role="alert">
                            <strong>SAPERLIPOPETTE !</strong><br />
                            Il semble bien que la session soit vide.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                <?php
                }
                ?>
                <h2>Détruire la session</h2>
                <p>
                    <a href="./superglobales.php?sessionDestroy=true">
                        Détruire la session !
                    </a>
                </p>
                <h2>Contenu de $_COOKIE</h2>
                <div class="limit-height">
                <?php
                if (isset($_COOKIE)) {
                    foreach ($_COOKIE as $label => $content) {
                    ?>
                        <div class="row">
                            <label class="col-lg-3 text-break">
                                <span class="text-uppercase"><b><?php echo $label ?></b></span>
                            </label>
                            <div class="col-lg-9">
                                <?php echo $content ?>
                            </div>
                        </div>
                    <?php
                    }
                } else {
                    ?>
                    <div class="row">
                        <div class="alert alert-warning alert-dismissible fade show col-lg-12" role="alert">
                            <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                <?php
                }
                
                ?>
                </div>
            </article>
        </section>
        <section class="row">
            <article class="col-lg-6">
                <h2>Les Cookies</h2>
                <h3>Créer un cookie</h3>
                <p>
                    Créer le cookie <a href="./superglobales.php?manageMonster=true">monster</a>
                </p>
                <p>
                    Modifier le cookie <a href="./superglobales.php?manageMonster=update">monster</a>
                </p>
                <p>
                    Détruire le cookie <a href="./superglobales.php?manageMonster=false">monster</a>
                </p>
                <?php
                var_dump($_COOKIE);
                ?>
            </article>
            <article class="col-lg-6">
                <h2>Les variables globales</h2>
                <h3>Le contenu de $GLOBALS</h3>
                <div class="limit-height">
                <?php
                if (isset($GLOBALS)) {
                    foreach ($GLOBALS as $label => $content) {
                    ?>
                        <div class="row">
                            <label class="col-lg-2 text-break">
                                <span class="text-uppercase"><b><?php echo $label ?></b></span>
                            </label>
                            <div class="col-lg-10">
                                <?php var_dump($content) ?>
                            </div>
                        </div>
                    <?php
                    }
                }
                ?>
                </div>
                <p>
                    <?php
                    coucouToi();
                    ?>
                </p>
                <?php
                //var_dump($GLOBALS['GLOBALS']);
                ?>
            </article>
        </section>
    </main>
    <?php include './includes/footer.php' ?>
</body>

</html>