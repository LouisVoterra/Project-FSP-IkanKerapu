<?php
require_once("../Class/gameclass.php");

if (isset($_GET['idgame'])) {
    $idgame = intval($_GET['idgame']); 
    $object = new Game();

    $arr_col = ['idgame' => $idgame];

   
    if ($object->deleteGame($arr_col)) {
        
        header("Location: ../Kelola/kelolagame.php?status=success");
    } else {
        
        header("Location: deletegame.php?status=error");
    }
} else {
    echo "ID team tidak ditemukan.";
    exit();
}

exit();
?>
