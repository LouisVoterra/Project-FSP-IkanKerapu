<?php
require_once("../Class/userclass.php");


if (isset($_GET['id'])) {
    $idproposal = intval($_GET['id']); 
    $object = new User();

    $arr_col = ['id' => $idproposal];

    if ($object->acceptProposal($arr_col)) {

        header("Location: ../Kelola/daftar_proposal.php?status=success");
    } else {
        
        header("Location: ../Kelola/daftar_proposal.php?status=error");
    }
} else {
    echo "ID proposal tidak ditemukan.";
    exit();
}

exit();
?>