<?php
require_once("../Class/eventclass.php");

if (isset($_GET['idevent'])) {
    $idevent = intval($_GET['idevent']); 
    $object = new Event();

    $arr_col = ['idevent' => $idevent];

   
    if ($object->deleteEvent($arr_col)) {
        
        header("Location: ../Kelola/kelolaevent.php?status=success");
    } else {
        
        header("Location: ../Kelola/kelolaevent.php?status=error");
    }
} else {
    echo "ID team tidak ditemukan.";
    exit();
}

exit();
?>
