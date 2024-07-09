<?php
session_start();
include './includes/functions.php';
//var_dump($_SESSION);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Formation php - <?php echo 'Accueil';  ?></title>
    <?php include './includes/appels.php' ?>
</head>

<body>
    <?php include './includes/header.php' ?>
    <?php include './includes/navigation.php' ?>
    <main class="container">
        <section class="row">
            <article class="col-lg-6">
                <h2>Les variables en PHP</h2>
                <?php
                // commentaire en une ligne
                /*
                Commentaire en bloc.
                Généralement utilisé en début de page pour les information concernant le code
                */

                // variable en php 
                $variable = null;
                echo $variable;
                // variable de type texte
                $monTexte = '<p>Ceci est mon texte, l\'apostrophe doit être échapée avec un anti-slash</p>';
                $monTexte2 = "<p>Ceci est mon texte, l'apostrophe           ne doit pas 
                être échapée avec un anti-slash mais les \" doivent eux être échappés avec une anti-slash</p>";

                echo $monTexte;
                echo $monTexte2;

                //nombre entier
                $monEntier = 12;
                echo '<p>Mon entier : ' . $monEntier . '</p>';

                $monEntier += 0.3; //$monEntier = $monEntier + 0.3;
                echo '<p>Mon entier + 0.3 : ' . $monEntier . '</p>';
                // décimal / virgule flottant
                $monDecimal = 12.3;

                $monEntier .= 15; //$monEntier = $monEntier . '€';
                echo '<p>Mon entier .= 15 : ' . $monEntier . '</p>';

                $monEntier += 12;
                echo '<p>Mon entier += 12 : ' . $monEntier . '</p>';

                $monEntier .= '€'; //$monEntier = $monEntier . '€';
                echo '<p>Mon entier .= \'€\' : ' . $monEntier . '</p>';

                // booléen
                $bouleenVrai = true;
                $bouleenFaux = false;

                echo '<p>Mon bouleenVrai : ' . $bouleenVrai . '</p>';
                echo '<p>Mon bouleenFaux : ' . $bouleenFaux . '</p>';

                function peutImporte(float $variable, string $unMessage){
                    return $variable . ' ' . $unMessage;//transtypage : changer le type d'une variable suite à la concaténation
                }

                echo peutImporte(12.3, 'test');
                ?>
                <h2>Opérateurs de comparaison</h2>
                <?php 
                $maValeurEntiere = 22;

                if('22' == $maValeurEntiere){
                    echo '<p>ma valeur est == 22</p>';
                }

                if(intval('22') === $maValeurEntiere){
                    echo '<p>ma valeur est === intval(22)</p>';
                }

                /**
                 * //hérité de Java
                 * // java
                 * 
                 * String a = "Chaîne";
                 * a.equal("Chaîne"); // true
                 * 
                 * String b = null;
                 * b.equal("Chaîne"); // retourne une exception de type nullPointerException
                 * 
                 * // yoda code
                 * "Chaîne".equal(b); // false
                 * 
                */

                // autres comparaisons
                /*
                 >
                 >=
                 <
                 <=
                 !
                 != différent en valeur contraire direct de == en valeur
                 !== différent en valeur et type contraire direct de == en valeur et type
                 */
                $bouleen = true;
                if(!$bouleen){
                    //action si $bouleen === false
                }else{
                    //action si $bouleen !== de false
                }

                /*
                if(condition){

                }else if(condition){

                }else if(condition){

                }else{

                }
                */

                // switch case

                $parfumDeGlace = 'vanille';

                switch($parfumDeGlace){
                    case 'chocolat': // if($parfumDeGlace === 'chocolat' || $parfumDeGlace === 'orgeat')
                    case 'orgeat':
                        echo '<p>rime avec beluga</p>';
                        break;
                    case 'framboise':
                        echo '<p>rime avec gerboise</p>';
                        break;
                    case 'vanille':
                        echo '<p>rime avec gerbille</p>';
                        break;
                    case 'rhum raisin':
                        echo '<p>rime avec pangolin</p>';
                        break;
                    default:
                        echo '<p>Comprends pas</p>';
                }

                // ternaire : un si en une ligne
                // (condition)? résultat si vrai : résultat si faux ;
                $age = 24;
                if(18 <= $age){
                    $majeur = true;
                }else{
                    $majeur = false;
                }

                // avec un ternaire
                $majeur = (18 <= $age)? true : false;

                // opérateurs logiques
                /*
                ET      =>  &&
                $a = true; $b = true;
                $a && $b => true;

                $a = true; $b = false;
                $a && $b => false;

                $a = false; $b = true;
                $a && $b => false;

                $a = false; $b = false;
                $a && $b => false;

                OU      =>  ||
                $a = true; $b = false;
                $a || $b => true;
                */
                $a = false; $b = false;
                if($a && $b){
                    echo '$a && $b';
                }else{
                    echo 'no !';
                }

                /*
                OU EXCLUSIF => xor
                $a xor $b => true si $a OU $b est vrai
                ça ranvoie false si $a ET $b sont vrai
                */

                ?>
            </article>
            <article class="col-lg-6">
                <h2>Les tableaux php</h2>
                <?php
                $tableauDeParfums = array('framboise', 'chocolat', 'meringue', 'fraise tagada');
                var_dump($tableauDeParfums);
                $testTab = [1, 2, 3, 4];
                echo '<p>' . print_r($tableauDeParfums) . '</p>';

                echo '<p>' . $tableauDeParfums[0] . '</p>';

                echo '<p>' . implode(', ', $tableauDeParfums) . '</p>';

                $tabText = '1, 2, 3, 4';
                var_dump(explode(', ', $tabText));
                ?>
                <h2>Remplir le tableau</h2>
                <?php
                $tableauDAnimaux[0] = 'Gerboise';
                $tableauDAnimaux[4] = 'Serval';
                $tableauDAnimaux[1] = 'Beluga';
                echo '<p>' . print_r($tableauDAnimaux) . '</p>'; // interdit !!!!!
                $tableauDArtistes[] = 'Tiziano Vedello';
                $tableauDArtistes[] = 'Camille Claudel';
                $tableauDArtistes[] = 'Auguste Rodin';
                $tableauDArtistes[] = 'Rembrandt Harmenszoon Van Rijn';
                echo '<p>' . print_r($tableauDArtistes) . '</p>';
                ?>
            </article>
        </section>
        <section class="row">
            <article class="col-lg-12">
                <h2>Les tableaux associatifs</h2>
                <p>
                    Les tableaux associatifs ont des clefs à la place 
                    d'index en références des données qu'ils contiennent.
                </p>
                <?php
                $donneesUtilisateur01 = [
                    'nom' => 'Duflot',
                    'prenom' => 'Nicolas',
                    'age' => 42,
                    'ville' => 'Lille'
                ];

                $donneesUtilisateur02 = [
                    'nom' => 'Sno',
                    'prenom' => 'John',
                    'age' => 15,
                    'ville' => 'Castleblack'
                ];

                var_dump($donneesUtilisateur01);
                var_dump($donneesUtilisateur02);

                //var_dump($_SERVER);
                //var_dump($GLOBALS);
                
                //taille d'un tableau
                $tailleTableauDAnimaux = count($tableauDAnimaux);
                echo '<p>Mon tableau d\'animaux contient ' . $tailleTableauDAnimaux . ' éléments </p>';
                ?>
            </article>
        </section>
        <section class="row">
            <article class="col-lg-6">
                <h2>Les boucles</h2>
                <h3>La boucle for</h3>
                <?php
                /* 
                for( $i = <une valeur type numérique>; $i différent <valeur limite>; $i++ OU $i-- OU $i +- valeur numérique ){

                }
                */
                echo '<ul>';
                for($i = 0; $i <= 10; $i++){
                    echo '<li>' . $i .'</li>';
                }
                echo '</ul>';
                /*
                en itération, on peut avoir les formes :
                    $i++ <=> $i = $i + 1 on incrémente après l'utilisation
                    $i-- <=> $i = $i - 1 on décrémente après l'utilisation
                    ++$i on incrémente avant l'utilisation on incrémente avant l'utilisation
                    --$i on incrémente avant l'utilisation on décrémente avant l'utilisation
                */
                
                $i = 11;
                echo '<p>' . $i . '</p>';       // affiche 11
                echo '<p>' . $i++ . '</p>';     // affiche 11
                echo '<p>' . $i . '</p>';       // affiche 12
                echo '<p>' . ++$i . '</p>';     // affiche 13
                ?>
                <h3>La boucle tant que</h3>
                <?php
                $compteur = 1;
                echo '<ul>';
                while($compteur <= 10){
                    echo '<li>' . $compteur .'</li>';
                    $compteur++;
                }
                echo '</ul>';
                ?>
                <h3>La boucle faire tant que</h3>
                <?php
                $compteur = 11;
                echo '<ul>';
                do{
                    echo '<li>' . $compteur .'</li>';
                    $compteur++;
                }while($compteur <= 10);
                echo '</ul>';
                ?>
            </article>
            <article class="col-lg-6">
                <h3>La boucle foreach</h3>
                <p>
                    La boucle foreach permet de parcourir tous les éléments d'un tableau, même les tableaux associatifs, sans avoir recours à un compteur.
                </p>
                <?php
                //tableDAnimaux
                echo '<p>';
                foreach($tableauDAnimaux as $value){
                    echo $value . '<br />';
                }
                echo '</p>';

                echo '<p>';
                foreach($donneesUtilisateur01 as $clef => $value){
                    echo $clef . ' : ' . $value . '<br />';
                }
                echo '</p>';
                ?>
                <h2>Les fonctions sur les tableaux</h2>
                <h3>Si la clef existe dans le tableau</h3>
                <p>
                    array_key_exists('la clef recherchée', $leTableauAssociatifTeste); // retourne vrai ou faux
                </p>
                <p>
                    <?php
                    echo (array_key_exists('nom', $donneesUtilisateur01)) ? 'la clef "nom" est dans le tableau<br />' : 'la clef "nom" n\'est pas dans le tableau<br />';
                    echo (array_key_exists('adresse', $donneesUtilisateur01)) ? 'la clef "adresse" est dans le tableau<br />' : 'la clef "adresse" n\'est pas dans le tableau<br />';
                    ?>
                </p>
                <h3>Si la valeur est présente dans le tableau</h3>
                <p>
                    in_array('valeur recherchée', $tableauTeste); // retourne vrai ou faux
                </p>
                <p>
                    <?php
                    echo (in_array('Auguste Rodin', $tableauDArtistes))? 'Auguste Rodin est dans le tableau':'Auguste Rodin n\'est pas dans le tableau';
                    ?>
                </p>
                <h4>Retrouver la position d'une valeur dans un tableau</h4>
                <p>
                    array_search('valeur recherchée', $tableauTeste); // retourne l'index de la valeur ou faux
                </p>
                <p>
                <?php
                echo 'framboise se trouve à la position '. array_search('framboise', $tableauDeParfums) . ' dans le tableau<br />';
                echo 'gerbille se trouve à la position '. array_search('gerbille', $tableauDeParfums) . ' dans le tableau';
                ?>
                </p>
            </article>
        </section>
        <section class="row">
            <article class="col-lg-12">
                <h3>Le tri des tableaux</h3>
                <p>
                    sort : trie les valeurs d'un tableau croissant en conservant la place des index<br />
                    asort : trie les valeurs d'un tableau croissant en ne conservant pas la place des index<br />
                    ksort : trie les valeurs d'un tableau croissant selon les clefs<br />
                    rsort : trie les valeurs d'un tableau décroissant en conservant la place des index<br />
                    arsort : trie les valeurs d'un tableau décroissant en ne conservant pas la place des index<br />
                    krsort : trie les valeurs d'un tableau décroissant selon les clefs<br />
                </p>
                <pre>
                    <?php
                    print_r($tableauDArtistes);
                    sort($tableauDArtistes);
                    print_r($tableauDArtistes);
                    ?>
                </pre>
                <pre>
                    <?php
                    print_r($tableauDArtistes);
                    arsort($tableauDArtistes);
                    print_r($tableauDArtistes);
                    ?>
                </pre>
                <pre>
                    <?php
                    print_r($tableauDArtistes);
                    ksort($tableauDArtistes);
                    print_r($tableauDArtistes);
                    ?>
                </pre>
            </article>
        </section>
    </main>
    <?php include './includes/footer.php' ?>
</body>

</html>