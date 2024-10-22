<?php
require_once("../Class/userclass.php");

if (isset($_GET['id'])) {
    $idproposal = intval($_GET['id']);
    $object = new User();

    
    $arr_col = ['id' => $idproposal];
    if ($object->acceptProposal($arr_col)) {

        
        $proposal_data = $object->getProposalDataById($idproposal);

        if ($proposal_data) {
            $idteam = $proposal_data['idteam'];
            $idmember = $proposal_data['idmember'];
            $description = $proposal_data['description'];


            $team_member = [
                'idteam' => $idteam,
                'idmember' => $idmember,
                'description' => $description
            ];
            $object->joinTeam($team_member);

            
            header("Location: ../Kelola/daftar_proposal.php?status=success");
        } else {
            
            header("Location: ../Kelola/daftar_proposal.php?status=missing_data");
        }

    } else {
        
        header("Location: ../Kelola/daftar_proposal.php?status=error");
    }

} else {
    echo "ID proposal tidak ditemukan.";
    exit();
}
?>
