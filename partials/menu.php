<?php
//bejelentkezés, regisztráció és kijelentkezés "gomb"
if (isset($authenticated_user)) { ?>
    <a href="kijelentkezés.php" class="main_button">Kijelentkezés (<?= $authenticated_user['username'] ?>)</a><br>
<?php } else { ?>
    <a href="bejelentkezés.php" class="main_button">Bejelentkezés</a> <br>
    <a href="regisztráció.php" class="main_button">Regisztráció</a>
<?php }
?>