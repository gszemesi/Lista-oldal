<?php
include('lib/utils/datastorage.php');
include('lib/utils/helper.php');
include('lib/utils/auth.php');



$teamstorage = new TeamStorage();
$matchesstorage = new MatchesStorage();
$usersstorage = new UsersStorage();
$commentsstorage = new CommentsStorage();

$team = $teamstorage->findAll();
$matches = $matchesstorage->findAll();
$auth = new Auth($usersstorage);
$comments = $commentsstorage->findAll();
?>