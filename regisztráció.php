<?php
include('lib/utils/_init.php');
// functions
function validate($post, &$data, &$errors)
{
  if (!isset($post['username']) || trim($post['username']) === '') {
    $errors['username'] = 'A felhasználónév megdása kötelező!';
  } else if (strlen($post['username']) < 3) {
    $errors['username'] = 'A felhasználónévnek legalább 3 karakterből kell állnia!';
  } else if (strlen($post['username']) >10) {
    $errors['username'] = 'A felhasználónévnek legfeljebb 10 karakterből állhat!';
  } else {
    $data['username'] = $_POST['username'];
  }

  if (!isset($post['email']) || trim($post['email']) === '') {
    $errors['email'] = 'Email cím megadása kötelező!';
  } else if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Az email cím formátuma nem megfelelő!';
  } else {
    $data['email'] = $_POST['email'];
  }

  if (!isset($post['password1']) || trim($post['password1']) === '') {
    $errors['password1'] = 'Jelszó megadása kötelező!';
  } else if (!isset($post['password2']) || trim($post['password2']) === '') {
    $errors['password1'] = 'A jelszavak nem egyeznek meg! (hibakód: 1)';
  } else if ($post['password1'] !== $post['password2']) {
    $errors['password1'] = 'A jelszavak nem egyeznek meg! (hibakód: 2)';
  } else {
    $data['password'] = $_POST['password1'];
  }

  return count($errors) === 0;
}

// main
$errors = [];
$data = [];
if (count($_POST) > 0) {
  if (validate($_POST, $data, $errors)) {
    if ($auth->user_exists($data['username'])) {
      $errors['global'] = "A felhasználó már létezik!";
    } else {
      $auth->register($data);
      redirect('bejelentkezés.php');
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
  <title>Regisztráció</title>
  <link rel="stylesheet" href="lib/classes/index.css">
</head>

<body>
  <main class="center">
    <h1>Regisztráció</h1>

    <?php if (isset($errors['global'])) : ?>
      <p><span class="error"><?= $errors['global'] ?></span></p>
    <?php endif; ?>
    <form action="" method="post" novalidate>
      Felhasználónév: <br>
      <input type="text" name="username" value="<?= $_POST['username'] ?? "" ?>" required> <span><?= $errors['username'] ?? '' ?> </span><br>
        E-mail: <br>
        <input type="email" name="email" value="<?= $_POST['email'] ?? "" ?>" placeholder="minta@gmail.com" required> <span><?= $errors['email'] ?? '' ?></span><br>
          Jelszó: <br>
          <input type="password" name="password1" required> <span><?= $errors['password1'] ?? '' ?></span> <br>
            Jelszó mégegyszer: <br>
            <input type="password" name="password2" required> <br>
            <input type="submit" value="Regisztáció"><br>

    </form>
    <a href="bejelentkezés.php" class="main_button" id="reg-bej">Bejelentkezés</a><br>
    <a href="listaoldal.php">Listaoldal...</a>
  </main>
</body>

</html>