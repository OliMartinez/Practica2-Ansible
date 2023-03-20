<?php
include_once '../Modelo/UserSession.php';

$userSession = new UserSession();
$userSession->closeSession();

header("location: ../index.php");
?>