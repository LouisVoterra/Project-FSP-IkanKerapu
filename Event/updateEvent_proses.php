<?php
require_once("../Class/eventclass.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idevent = $_POST['idevent'];
    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $date = isset($_POST['date']) ? date('Y-m-d', strtotime($_POST['date'])) : null;
    $description = isset($_POST['description']) ? $_POST['description'] : null;
    $teams = isset($_POST['team']) ? $_POST['team'] : []; 

    $sql = new Event();

    
    if ($name || $date || $description) {
        $eventUpdated = $sql->updateEvent([
            'idevent' => $idevent,
            'name' => $name,
            'date' => $date,
            'description' => $description,
        ]);
    } else {
        $eventUpdated = true; 
    }

    if ($eventUpdated || !empty($teams)) {  
        if (!empty($teams)) {
            $currentTeams = $sql->getTeamsInEvent($idevent);
    
            $teamsToAdd = array_diff($teams, $currentTeams);  
            
            $teamsToRemove = array_diff($currentTeams, $teams);  
    
            foreach ($teamsToRemove as $idteam) {
                $sql->deleteEventTeams($idevent, $idteam);
            }
    
            foreach ($teamsToAdd as $idteam) {
                $sql->addEventTeams($idevent, intval($idteam)); 
            }
        }
    

        

      
        echo "<script>alert('Event and teams updated successfully');</script>";
        header("Location: ../Kelola/kelolaevent.php");
        exit();
    } else {

        echo "<script>alert('Event update failed');</script>";
        header("Location: ../Kelola/kelolaevent.php");
        exit();
    }
} else {
    echo "Data tidak terkirim.";
}
?>
