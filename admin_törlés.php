<?php
session_start();
include('lib/utils/_init.php');
$authenticated_user = $auth->authenticated_user(); //a bejelentkezett felhasználó adatai

//csak admin érheti el
if(!in_array("admin",$authenticated_user['roles'])){
  redirect('listaoldal.php');
}

$b_id = $_GET['teamid'];
$c_id= $_GET['commentid'];


$commentsstorage->delete($c_id);
$dir = "csapatrészletek.php?id=" . $b_id;
redirect($dir)
?>
