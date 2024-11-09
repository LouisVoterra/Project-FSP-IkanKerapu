<?php
require_once("../Class/teamclass.php");

if (isset($_POST['idteam'])) {
    $idteam = $_POST['idteam'];
    $teamObj = new Team();
    $members = $teamObj->displayTeam_Member($idteam);

    if ($members) {
        echo json_encode($members);
    } else {
        echo json_encode([]);
    }
}
?>
