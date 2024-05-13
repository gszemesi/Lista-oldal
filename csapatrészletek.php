<?php
session_start();
include('lib/utils/_init.php');
$authenticated_user = $auth->authenticated_user(); //a bejelentkezett felhasználó adatai

$id = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Csapatrészletek</title>
    <link rel="stylesheet" href="lib/classes/index.css">
</head>

<body>
    <main>
        <h1> <?= $teamstorage->findById($id)['name'] . " (" . $teamstorage->findById($id)['city'] . ")"; ?></h1>
        <?php
        include('partials/menu.php');
        ?>
        <a href="listaoldal.php">Vissza...</a>

        <h2>Meccsek:</h2>
        <ul class="meccsek">
            <?php
            foreach ($matches as $match => $match_data) {
                $home_score = $match_data['home']['score'];
                $home_id = $match_data['home']['id'];
                $away_score = $match_data['away']['score'];
                $away_id = $match_data['away']['id'];



                if ($home_id === $id) {
                    if ($home_score > $away_score) $e = "nyert";
                    if ($home_score === $away_score) $e = "döntetlen";
                    if ($home_score < $away_score) $e = "vesztett";
                    if ($home_score === null && $away_score === null) $e = "nem lejátszott"; ?>

                    <li class=<?= $e ?>><?= $match_data['date'], "  ", $teamstorage->findById($home_id)['name'] ?> <?= $home_score  ?? "-" ?> : <?= $away_score ?? "-" ?> <?= $teamstorage->findById($away_id)['name'] ?></li>
                    
                    <?php
                    if (isset($authenticated_user) && in_array("admin", $authenticated_user['roles'])) { ?>
                        <a href="admin_modosító.php?teamid=<?= $id ?>&matchid=<?= $match_data['id'] ?>">Módosítás...</a>
                    <?php
                    }

                } elseif ($away_id === $id) {
                    if ($home_score > $away_score) $e = "vesztett";
                    if ($home_score === $away_score) $e = "döntetlen";
                    if ($home_score < $away_score) $e = "nyert";
                    if ($home_score === null && $away_score === null) $e = "nem lejátszott"; ?>

                    <li class=<?= $e ?>><?= $match_data['date'], "  ", $teamstorage->findById($home_id)['name'] ?> <?= $home_score ?? "-" ?> : <?= $away_score ?? "-" ?> <?= $teamstorage->findById($away_id)['name'] ?></li>
                    
                    <?php
                    if (isset($authenticated_user) && in_array("admin", $authenticated_user['roles'])) { ?>
                        <a href="admin_modosító.php?teamid=<?= $id ?>&matchid=<?= $match_data['id'] ?>">Módosítás...</a>
            <?php
                    }
                }
            }
            ?>
        </ul>


        <h2>Hozáászólások:</h2>
        <ul>
            <?php
            foreach ($comments as $commentid => $comment_data) {
                if ($comment_data['teamid'] == $id) { ?>
                    <li><?= $comment_data['author'], " ",  $comment_data['date'] ?> | <?= $comment_data['text'] ?></li>
                    <?php
                    if (isset($authenticated_user) && in_array("admin", $authenticated_user['roles'])) { ?>
                        <a href="admin_törlés.php?teamid=<?= $id ?>&commentid=<?= $commentid ?>">Törlés...</a>
            <?php
                    }
                }
            }
            ?>
        </ul>

        <h3>Új hozzászólás:</h3>
        <form action="" method="post" novalidate>
            <textarea name="hozzászólás" id="hozzászólás" cols="45" rows="10" <?php if (!isset($authenticated_user)) { ?> disabled=<?= "true" ?> placeholder=<?= "Kérlek_jelentkezbe_a_hozzászóláshoz!" ?> <?php } else { ?> placeholder=<?= "Hozzászólás..." ?> <?php } ?>></textarea>
            <br>
            <input type="submit" value="Hozzászólás" <?php if (!isset($authenticated_user)) { ?>disabled=<?= "true" ?><?php } ?>>

            <?php
            if (isset($_POST['hozzászólás']) && trim($_POST['hozzászólás'] !== "")) {
                $tmp = [
                    'author' => $authenticated_user['username'],
                    'text' => $_POST['hozzászólás'],
                    'teamid' => $id,
                    'date' => date("Y-m-d")
                ];

                $commentsstorage->add($tmp);
                $dir = "csapatrészletek.php?id=$id";
                redirect($dir);
            }
            ?>

        </form>

    </main>

</html>