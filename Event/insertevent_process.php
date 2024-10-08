<?php
require_once("../Class/eventclass.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $date = date('Y-m-d', strtotime($_POST['date']));
    $description = $_POST['description'];
    $teams = $_POST['team']; // Array of selected teams

    $event = new Event();
    
    // Insert the event first
    $idevent = $event->insertEvent([
        'name' => $name,
        'date' => $date,
        'description' => $description,
    ]);

    if ($idevent) {
        // If event insertion is successful, insert into event_teams for each selected team
        foreach ($teams as $idteam) {
            $event->event_team([
                'idevent' => $idevent,
                'idteam' => intval($idteam) // Ensure team ID is an integer
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
