<?php
include('lib/utils/_init.php');

// functions
function validate($post, &$data, &$errors)
{
  if (!isset($post['username']) || trim($post['username']) === '') {
    $errors['username'] = 'A felhasználónév megdása kötelező!';
  } else if (strlen($post['username']) < 3) {
    $errors['username'] = 'A felhasználónévnek legalább 3 karakterből kell állnia!';
  } else {
    $data['username'] = $_POST['username'];
  }

  if (!isset($post['password']) || trim($post['password']) === '') {
    $errors['password'] = 'Jelszó megadása kötelező!';
  } else {
    $data['password'] = $_POST['password'];
  }


  return count($errors) === 0;
}

// main
session_start();
$data = [];
$errors = [];
if (count($_POST) > 0) {
  if (validate($_POST, $data, $errors)) {
    $auth_user = $auth->authenticate($data['username'], $data['password']);
    if (!$auth_user) {
      $errors['global'] = "Sikertelen bejelentkezés!";
    } else {
      $auth->login($auth_user);
      redirect('Listaoldal.php');
    }
  }
}

?>



<!DOCTYPE html>
<html lang="hu">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bejelentkezés</title>
  <link rel="stylesheet" href="lib/classes/index.css">
</head>

<body>
  <main class="center">
  <h1>Bejelentkezés</h1>
  <?php if (isset($errors['global'])) : ?>
    <p><span class="error"><?= $errors['global'] ?></span></p>
  <?php endif; ?>
  <form action="" method="post" novalidate>
    Felhasználónév: <br>
    <input type="text" name="username" value="<?= $_POST['username'] ?? "" ?>" ><br>
    <span><?= $errors['username'] ?? '' ?></span> <br>
    Jelszó: <br>
    <input type="password" name="password"> <br>
    <span><?= $errors['password'] ?? '' ?></span><br>
    <input type="submit" value="Bejelentkezés"><br>

  
  </form>

  <a href="regisztráció.php" class="main_button" id="reg-bej">Regisztráció</a><br>
  <a href="listaoldal.php">Listaoldal...</a>
  </main>
</body>

</html>