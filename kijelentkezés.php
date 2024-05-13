<?php
session_start();
include('lib/utils/_init.php');

$auth->logout();
redirect('listaoldal.php');
?>