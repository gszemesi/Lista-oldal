<?php
session_start();
include('lib/utils/_init.php');
$authenticated_user=$auth->authenticated_user(); //a bejelentkezett felhasználó adatai
?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listaoldal</title>
    <link rel="stylesheet" href="lib/classes/index.css">
</head>

<body>
    <main>
    <h1>Eötvös Loránd Stadion</h1>
    <div id=stadion>
    <img src="lib/utils/stadion.jpg" alt="stadion">
    </div>
    <?php
    include('partials/menu.php');
    ?>
    <p>
    Köszöntelek a Eötvös Loránd Stadion holnapán. 
    A kezdőoldalon láthatod a csapatokat és a legfrissebb eredményeket. Csapatokra kattintva átléphetsza a csapatoldalára, ahol bejelenkezés után hozzászólást írhatsz!
    </p>
    
    <h2>Csapatok:</h2>
    <ul>
        <?php
        foreach ($team as $id => $match) { ?>
                <li><a href="csapatrészletek.php?id=<?= $match['id'] ?>"><?=$match['name']  ?></a></li>
        <?php } ?>
    </ul>

    <h2>Legutóbbi 5 lejátszott meccs:</h2>
    <ul class="meccsek">
        <?php
        $s=0;
        
       
        foreach (array_reverse($matches) as $match => $match_data) {
            if($match_data['home']['score']!==null && $match_data['away']['score']!==null) { ?>
                <li><?=$match_data['date'] . " " . 
                    $teamstorage->findById($match_data['home']['id'])['name'] ?> <?=$match_data['home']['score']?> : 
                    <?= $match_data['away']['score']?> <?= $teamstorage->findById($match_data['away']['id'])['name']?>
                </li>
        <?php 
            $s++;
            } 
            if($s===5) break;
        }?>
    </ul>
    </main>
</html>