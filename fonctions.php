<?php
session_start();
include './includes/functions.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Formation php - <?php echo 'Fonctions'; ?></title>
    <?php include './includes/appels.php' ?>
    <script>
        window.addEventListener('DOMContentLoaded', function(){
            const dateTest = document.querySelector('#dateTest');
            const affDate = document.querySelector('#affDate');
            dateTest.addEventListener('change', function(){
                console.log(`Datetest : ${dateTest.value}`);
                affDate.append(document.createTextNode(dateTest.value));
            });
            console.log(`Datetest : ${dateTest.value}`);
        });
    </script>
</head>

<body>
    <?php include './includes/header.php' ?>
    <?php include './includes/navigation.php' ?>
    <main class="container">
        <section class="row">
            <article class="col-md-6 col-lg-4">
                <h2>Les fonctions</h2>
                <p>
                    Les fonctions sont déclarée avant leur utilisation.
                    Il faut qu'elles soient compilée par le serveur,
                    donc qu'elle "existe" dans la portée de la page 
                    pour être utilisées.<br />
                    <?php
                    //var_dump($_SERVER);
                    // helloFriend fait un echo d'une chaîne de caractère
                    helloFriend();
                    echo helloFriend();
                    $message = helloFriend();
                    echo $message;
                    $message = '';
                    // helloFriendReturn retourne une chaîne de caractère
                    helloFriendReturn();
                    $message = helloFriendReturn();
                    echo helloFriendReturn();
                    echo $message;
                    ?>
                </p>
                <p>
                    Les fonctions peuvent admettre des paramètres ou non.
                    Et elle peuvent agir directement et / ou retourner un résultat.
                </p>
                <p>
                    Au niveau des paramètres, il existe l'opérateur variadique 
                    ou en anglais rest parameter <q> ... </q>
                </p>
                <p>
                    <?php
                    afficheListe('test');
                    afficheListe('test', 12, 'mama', 130.5);
                    ?>
                </p>
                <p>
                    Il est obligatoire qu'un opérateur variadique soit déclaré comme dernière
                    variable d'une fonction
                </p>
            </article>
            <article class="col-md-6 col-lg-4">
                <h2>La portée des variables</h2>
                <h3>Locale et globale</h3>
                <p>
                    La portée locale : propre au périmètre 
                    de déclaration de la variable,
                    si la variable est déclarée au sein 
                    d'une fonction elle n'aura d'effet que dans 
                    cette fonction.
                </p>
                <p>
                    La portée globale étend à tous les périmètres 
                </p>
                <p>
                <?php
                $a = 1;
                /*
                function test(){
                    echo $a.'<br />';
                }
                
                test();
                */
                function test($a){
                    echo 'la variable $a dans la fonction test : ' .  $a.'<br />';
                }
                
                test(2);

                for($a = 0; $a < 3; $a++){
                    echo $a.'<br />';
                }
                echo 'sorti du for, a = '. $a .'<br />';
                ?>
                </p>
                <p>
                    Pour "globaliser" une variable, deux méthodes :
                </p>
                <ul>
                    <li>Utiliser le mot clef <q>global</q></li>
                    <li>Utiliser le tableau de superblogales $GLOBALS</li>
                </ul>
                <?php
                function test2(){
                    global $a;
                    // ou on fait : $a = $GLOBALS['a'];
                    echo 'la variable $a dans la fonction test2 : ' .  $a.'<br />';
                }

                test2();
                ?>
            </article>
            <article class="col-md-6 col-lg-4">
            <h3>Les variables statiques (récursivité)</h3>
                <p>
                    Variable statique : peut être utilisée par exemple dans 
                    une fonction, si la variable change de valeur 
                    lors d'une première utilisation de la fonction,
                    elle aura toujours cette valeur à la seconde utlisation.
                </p>
                <p>
                <?php
                function maVariableStatique(){
                    static $testStatic = 0;
                    $testStatic++;
                    return $testStatic;
                }

                echo maVariableStatique().'<br />';
                echo maVariableStatique().'<br />';
                echo maVariableStatique().'<br />';
                echo maVariableStatique().'<br />';
                ?>
                </p>
                <p>
                    Une variable statique n'est pas une constante.
                    <?php
                    // constante globale uniquement déclarable au plus haut niveau
                    const UNECONSTANTE = 12;
                    echo '<br />UNECONSTANTE : '.UNECONSTANTE.'<br />';
                    // une constante déclarable en fonction
                    define('FOO', 'bar');
                    echo '<br />FOO : '.FOO.'<br />';
                    /*
                    Contrairement aux constantes définies en utilisant l'instruction define(), les constantes définies 
                    en utilisant le mot-clé const doivent être déclarées au plus haut niveau du contexte, car elles 
                    seront définies au moment de la compilation. Cela signifie qu'elles ne peuvent être déclarées 
                    à l'intérieur de fonctions, boucles, instructions if ou blocs try/catch.
                    */

                    ?>
                </p>
                <h3>Les fonctions récursives</h3>
                <p>
                    La fonction récursive va s'appeler elle-même 
                    jusqu'à atteindre le résultat défini par un nombre d'itération.
                </p>
                <p>
                    <?php
                    function fibonacci($nbElement, $reset = false){
                        //les variables
                        static $count = 0, $num1 = 0, $num2 = 1, $num3 = 0;
                        if($reset){
                            $count = 0;
                            $num1 = 0;
                            $num2 = 1;
                            $num3 = 0;
                        }
                        // affichage du chiffre calculé de la suite
                        echo $num1 . ' ';
                        // les calculs
                        $num3 = $num1 + $num2;
                        $num1 = $num2;
                        $num2 = $num3;
                        // la récursivité
                        if($count < $nbElement){
                            $count++;
                            fibonacci($nbElement);
                        }
                    }

                    fibonacci(5);
                    echo ' <===> ';
                    fibonacci(12);
                    echo ' <===> ';
                    fibonacci(12, true);

                    ?>
                </p>
            </article>
            <article class="col-lg-6">
                <h2>Les fonctions PHP prédéfinies</h2>
                <p>
                    <a href="https://www.php.net/manual/fr/funcref.php" target="_target">
                        Référence des fonctions (php.net)
                    </a>
                </p>
                <p>
                    <a href="https://www.php.net/manual/fr/book.array.php" target="_target">
                        Référence des fonctions pour les tableaux (php.net)
                    </a>
                </p>
                <h3>Les fonctions mathématiques</h3>
                <?php
                $floatValue01 = 32.4;
                $floatValue02 = 32.5;
                ?>
                <p>
                    Arrondir à l'inférieur :<br />
                    <?php
                    echo $floatValue01 . ' devient : ' . floor($floatValue01) . '<br />';
                    echo $floatValue02 . ' devient : ' . floor($floatValue02) . '<br />';
                    ?>
                    Arrondir au supérieur :<br />
                    <?php
                    echo $floatValue01 . ' devient : ' . ceil($floatValue01) . '<br />';
                    echo $floatValue02 . ' devient : ' . ceil($floatValue02) . '<br />';
                    ?>
                    Arrondi mathématique :<br />
                    <?php
                    echo $floatValue01 . ' devient : ' . round($floatValue01) . '<br />';
                    echo $floatValue02 . ' devient : ' . round($floatValue02) . '<br />';
                    ?>
                </p>
                <p>
                    Générer un chiffre aléatoire entre 0 et 100 compris : <br />
                    <?php
                    echo rand(0, 100).'<br />';
                    ?>
                </p>
            </article>
            <article class="col-lg-3">
                <h2>Fonctions sur les chaînes de caractère</h2>
                <?php
                $chaineTest = 'une phrase d\'exemple du explode';
                $tableauDeChaine = explode(' ', $chaineTest);
                var_dump($tableauDeChaine);
                $tableauDeChaine = preg_split('/[\s,]+/', $chaineTest);
                var_dump($tableauDeChaine);
                ?>
                Mettre tout en majuscule : <br />
                <?php echo strtoupper($chaineTest) ?><br />
                Mettre tout en minuscule : <br />
                <?php echo strtolower($chaineTest) ?>
            </article>
            <article class="col-lg-3">
                <h2>Les fonctions sur les dates</h2>
                <p>
                    getDate()<br />
                    <?php //var_dump(getdate()) ?><br />
                    <?php echo getdate()['month'] ?><br />
                </p>
                <p>
                    date() => affiche la date selon un format défini par un chaîne de caractère en variable<br />
                    <?php echo date('d/m/Y') ?><br />
                    <?php echo date('l jS \a\s F Y h:m:s A P I') ?><br />
                </p>
                <p>
                    petit exercice :<br />
                    Afficher la date du jour avec les jours de la semaine et les mois de l'année en français.<br />
                    Astuce : on utilisera la fonction date() et pensez aux tableaux associatifs.<br />
                    <b><?php echo date('l j F Y') ?></b>
                </p>
                <p>
                    <?php 
                    echo $daysEnFr[date('l')]. ' ' . date('j') . ' ' . $monthEnFr[date('F')] . ' ' . date('Y');
                    ?>
                </p>
                <p>
                    <?php 
                    echo tradDate('l j F Y');
                    echo '<br />';
                    echo tradDate('l j F Y h:m:s A P I');
                    echo '<br />';
                    echo tradDate('l j F Y', TRADDE);
                    echo '<br />';
                    echo tradDate('l j F Y h:m:s A P I', TRADDE);
                    ?>
                </p>
            </article>
            <article class="col-lg-12">
                <h2>Récupérer une date en js</h2>
                <input type="date" name="dateTest" id="dateTest" value="" />
                <p id="affDate">

                </p>
                <h2>Ajout de durée à une date</h2>
                <p>
                    date_add(date créée, interval de date);
                </p>
                <?php
                var_dump(date('Y-m-d h:m:s'));
                // création de l'objet date qui contient la date de départ
                $dateNow = date_create( date('Y-m-d h:m:s') ); 
                var_dump($dateNow);
                echo 'Date du jour'
                .'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                .'&nbsp;&nbsp; : ' 
                . date_format($dateNow, 'd/m/Y') . '<br />';
                // création de l'objet intervalle qui contient l'interval temps a ajouter
                $plus20Jours = date_interval_create_from_date_string('20 days'); 
                var_dump(date_interval_create_from_date_string('20 days'));
                $datePlus20Jours = date_add($dateNow, $plus20Jours);
                var_dump($datePlus20Jours);
                echo 'Date du jour + 20 jours'
                .'&nbsp; : '
                . date_format($datePlus20Jours, 'd/m/Y').'<br />';
                ?>
            </article>
        </section>
    </main>
    <?php include './includes/footer.php' ?>
</body>

</html>