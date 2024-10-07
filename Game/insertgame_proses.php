<?php
require_once("../Database/db.php"); //
require_once("../Class/gameclass.php"); //

if (isset($_POST['Submit'])) {

    var_dump($_POST);

    $name = $_POST['name'];
    $description = $_POST['description'];

    $object =  new Game();
    $game = $object->insertGame([
        'name' => $name,
        'description' => $description,
    ]);

    if ($sql) {
        echo "<script>alert('Data inserted');</script>";
        header("Location: ../Kelola/kelolagame.php");
    } else {
        echo "<script>alert('Data not inserted');</script>";
        header("Location: insertgame_proses.php");
    }
    
} else {
    echo "Form belum disubmit.";
}
?>