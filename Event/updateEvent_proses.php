<?php
require_once("../Class/eventclass.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idevent = $_POST['idevent'];
    $name = $_POST['name'];
    $date = date('Y-m-d', strtotime($_POST['date']));
    $description = $_POST['description'];
    $teams = $_POST['teams']; // Assuming this is an array of selected teams (use <select multiple> or checkboxes)

    $sql = new Event();
    
    // Update the event first
    $eventUpdated = $sql->updateEvent([
        'idevent' => $idevent,
        'name' => $name,
        'date' => $date,
        'description' => $description,
    ]);

    if ($eventUpdated) {
        // First, delete the previous team associations for the event
        $sql->deleteEventTeams($idevent);

        // Then, insert the new team associations
        foreach ($teams as $idteam) {
            $sql->update_event_team([
                'idevent' => $idevent,
                'idteam' => intval($idteam) // Ensure team ID is an integer
            ]);
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
