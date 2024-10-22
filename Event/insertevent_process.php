<?php
require_once("../Class/eventclass.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $date = date('Y-m-d', strtotime($_POST['date']));
    $description = $_POST['description'];
    $teams = $_POST['team']; 

    $event = new Event();
    
    
    $idevent = $event->insertEvent([
        'name' => $name,
        'date' => $date,
        'description' => $description,
    ]);

    if ($idevent) {
        
        foreach ($teams as $idteam) {
            $event->event_team([
                'idevent' => $idevent,
                'idteam' => intval($idteam) 
            ]);
        }
        echo "<script>alert('Event and teams inserted successfully');</script>";
        header("Location: ../Kelola/kelolaevent.php");
        exit();
    } else {
        echo "<script>alert('Event insertion failed');</script>";
        header("Location: insertevent.php");
        exit();
    }
} else {
    echo "Form belum disubmit.";
}
?>
