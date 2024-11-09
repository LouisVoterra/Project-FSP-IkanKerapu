<?php
require_once("../Class/teamclass.php"); // Pastikan path ini sesuai

if (isset($_POST['idgame'])) {
    $idgame = $_POST['idgame'];
    $teamObj = new Team();
    $teams = $teamObj->getTeamsByGameId($idgame);
    echo json_encode($teams);
}
?>
