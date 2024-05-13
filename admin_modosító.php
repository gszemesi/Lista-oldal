<?php
session_start();
include('lib/utils/_init.php');
$authenticated_user = $auth->authenticated_user(); //a bejelentkezett felhasználó adatai

//csak admin érheti el
if(!in_array("admin",$authenticated_user['roles'])){
  redirect('listaoldal.php');
}

$back_id= $_GET['teamid'];
$m_id = $_GET['matchid'];
?>

<!DOCTYPE html>
<html lang="hu">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Csapatszerkesztés</title>
  <link rel="stylesheet" href="lib/classes/index.css">
</head>

<body>
  <main>
    <h1> Mérkőzés szerkesztés</h1>
    <?php
    $matchid = $matchesstorage->findById($m_id);
    $home_name=$teamstorage->findById($matchid['home']['id'])['name'];
    $away_name=$teamstorage->findById($matchid['away']['id'])['name'] 
    ?>
    <div><?= $home_name ?> <?= $matchid['home']['score'] ?> : <?= $matchid['away']['score'] ?> <?= $away_name ?></div><br>

    <div>Adja meg a mérközés eredményét. Ha az eredmény törölni szeretné akkor hagya üresen a mezőket (törölje ki az eredményeket).</div><br>

    <form action="" method="post" novalidate>
      <?= $home_name ?>= <input type="number" name="home_score" value="<?= $matchid['home']['score'] ?>"><br>
      <?= $away_name ?>= <input type="number" name="away_score" value="<?= $matchid['away']['score'] ?>"><br><br>
      <?= $matchid['date'] ?>= <input type="date" name="date" value="<?= $matchid['date'] ?>"><br><br>

      <input type="submit" value="Modósítás">

      <?php
      if (isset($_POST['home_score']) && isset($_POST['away_score']) && $_POST['home_score'] === ""  && $_POST['away_score'] === "") {
        $matchid['home']['score'] = null;
        $matchid['away']['score'] = null;
        $matchid['away']['score'] = $_POST['date'];


        $matchesstorage->update($m_id, $matchid);
        $dir = "csapatrészletek.php?id=" . $back_id;
        redirect($dir);
      } else if (isset($_POST['home_score']) && isset($_POST['away_score'])) {
        $matchid['home']['score'] = strval($_POST['home_score']);
        $matchid['away']['score'] = strval($_POST['away_score']);
        $matchid['date'] = $_POST['date'];

        $matchesstorage->update($m_id, $matchid);
        $dir = "csapatrészletek.php?id=" . $back_id;
        redirect($dir);
      }
      ?>

    </form>



  </main>

</html>