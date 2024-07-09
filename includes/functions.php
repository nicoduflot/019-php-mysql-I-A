<?php
/*
fichiers des fonctions utilitaires du projet
*/

// définir la timezone pour les fonctions de date
date_default_timezone_set('Europe/Paris');

$daysEnFr = [
    "Monday"    => "Lundi",
    "Tuesday"   => "Mardi",
    "Wednesday" => "Mercredi",
    "Thursday"  => "Jeudi",
    "Friday"    => "Vendredi",
    "Saturday"  => "Samedi",
    "Sunday"    => "Dimanche"
];

$monthEnFr = [
    "January"   => "Janvier",
    "February"  => "Fevrier",
    "March"     => "Mars",
    "April"     => "Avril",
    "May"       => "Mai",
    "June"      => "Juin",
    "July"      => "Juillet",
    "August"    => "Août",
    "September" => "Septembre",
    "October"   => "Octobre",
    "November"  => "Novembre",
    "December"  => "Décembre"
];

const TRADFR = 0;
const TRADDE = 1;

$tradDate = [
    'Monday'    => ['Lundi',        'Montag'],
    'Tuesday'   => ['Mardi',        'Dienstag'],
    'Wednesday' => ['Mercredi',     'Mittwoch'],
    'Thursday'  => ['Jeudi',        'Donnerstag'],
    'Friday'    => ['Vendredi',     'Freitag'],
    'Saturday'  => ['Samedi',       'Samstag'],
    'Sunday'    => ['Dimanche',     'Sonntag'],
    'January'   => ['Janvier',      'Januar'],
    'February'  => ['Fevrier',      'Februar'],
    'March'     => ['Mars',         'März'],
    'April'     => ['Avril',        'April'],
    'May'       => ['Mai',          'Mai'],
    'June'      => ['Juin',         'Juni'],
    'July'      => ['Juillet',      'Juli'],
    'August'    => ['Août',         'August'],
    'September' => ['Septembre',    'September'],
    'October'   => ['Octobre',      'Oktober'],
    'November'  => ['Novembre',     'November'],
    'December'  => ['Décembre',     'Dezember'],
    'AM'        => ['Matin',        'Morgen'],
    'PM'        => ['Après-midi',   'Nachmittag']
];

function pageActive($page){
    //une fonction qui renvoie la position du premier caractère d'une chaîne dans une chaine
    return ( strrpos($_SERVER['PHP_SELF'], $page) )? 'active' : false;
}

function helloFriend(){
    echo 'Hello Hello !<br />';
}

function helloFriendReturn(){
    return 'Hello Hello return !<br />';
}

// ...$variable correspond à l'opérateur variadique : cette variable admet un nombre indéfini de valeurs
function afficheListe($uneVariableNormale, ...$listeOperateurVariadique){
    var_dump($uneVariableNormale);
    var_dump($listeOperateurVariadique);
}

function tradDate($dateFormat, $lang = TRADFR){
    global $tradDate;
    $dateString = date($dateFormat);
    foreach($tradDate as $anglais => $langTrad){
        $dateString = str_replace($anglais, $langTrad[$lang], $dateString);
    }
    return $dateString;
}

function prePrint(...$values){
    echo "<pre>";
    foreach($values as $value){
        print_r($value);
    }
    echo "</pre>";
}

function decodeWiki($wikiFile){
    $bbDecode = [
        "[title]" => "<h2>",
        "[/title]" => "</h2>",
        "[g]" => "<b>",
        "[/g]" => "</b>",
        "[i]" => "<i>",
        "[/i]" => "</i>",
        "[p]" => "<p>",
        "[/p]" => "</p>",
        "[liste]" => "</ul>",
        "[/liste]" => "</ul>",
        "[li]" => "<li>",
        "[/li]" => "</li>"
    ];

    foreach($bbDecode as $bbcode => $htmlTag){
        $wikiFile = str_replace($bbcode, $htmlTag, $wikiFile);
    }

    return $wikiFile;
}


function slugTitle($title){
    $slugTitle = str_replace("'", "-", $title);
    $slugTitle = str_replace(" ", "-", $slugTitle);
    $slugTitle = str_replace("?", "", $slugTitle);
    $slugTitle = str_replace("!", "", $slugTitle);
    $slugTitle = str_replace(";", "", $slugTitle);
    $slugTitle = str_replace(",", "", $slugTitle);
    $slugTitle = str_replace(".", "", $slugTitle);
    $slugTitle = str_replace("\"", "", $slugTitle);
    $slugTitle = str_replace("----", "-", $slugTitle);
    $slugTitle = str_replace("---", "-", $slugTitle);
    $slugTitle = str_replace("--", "-", $slugTitle);
    $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð',
                'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã',
                'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ',
                'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ',
                'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę',
                'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī',
                'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ',
                'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ',
                'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 
                'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 
                'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ',
                'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');

  $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O',
                'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c',
                'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u',
                'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D',
                'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g',
                'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K',
                'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o',
                'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S',
                's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W',
                'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i',
                'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
    $slugTitle = str_replace($a, $b, $slugTitle);
    return $slugTitle;
}

function mkmap($directory){
    // faire la "cartographie" des répertoires 
    // et fichiers contenus à l'adresse indiquée
    $map = "";
    $map .= "<ul class=\"\">";
    $folder = opendir($directory);
    while( $file = readdir($folder) ){
        if( $file !== "." && $file !== ".." ){
            $pathfile = $directory. "/" . $file;
            if(filetype($pathfile) == "dir"){
                $map .= "<li class=\"active m-1\">";
                $map .= $file;
                $map .= "</li>";
            }else{
                $map .= "<li class=\"justify-content-between d-flex m-1\">";
                $map .= "<a class=\"\" href=\"?wikinote=". $pathfile ."\">";
                $map .= $file;
                $map .= "</a>";
                $map .= " <a class=\"\" href=\"?wikinote=". $pathfile .
                "&edit=true\">";
                $map .= "<button class=\"btn btn-primary btn-sm\">Éditer</button>";
                $map .= "</a>";
                $map .= "</li>";
            }
            if(filetype($pathfile) == "dir"){
                $map .= mkmap($pathfile);
            }
        }
    }
    $map .= "</ul>";
    return $map;
}

function mkmapSimple($directory){
    // faire la "cartographie" des répertoires 
    // et fichiers contenus à l'adresse indiquée
    $map = "";
    $map .= "<ul class=\"\">";
    $folder = opendir($directory);
    while( $file = readdir($folder) ){
        if( $file !== "." && $file !== ".." ){
            $pathfile = $directory. "/" . $file;
            if(filetype($pathfile) == "dir"){
                $map .= "<li class=\"active m-1\">";
                $map .= $file;
                $map .= "</li>";
            }else{
                $map .= "<li class=\"justify-content-between d-flex m-1\">";
                $map .= "<a class=\"\" target=\"_blank\" href=\"". $pathfile ."\">";
                $map .= $file;
                $map .= "</a>";
                $map .= "</li>";
            }
            if(filetype($pathfile) == "dir"){
                $map .= mkmapSimple($pathfile);
            }
        }
    }
    $map .= "</ul>";
    return $map;
}