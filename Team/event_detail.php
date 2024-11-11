<?php
require_once("../Class/teamclass.php");

$eventObj = new Team();
$idTeam = isset($_GET['idteam']) ? $_GET['idteam'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Event Team</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="table-container">
        <?php
        if ($idTeam) {
            $totaldata = 0;
            $perhalaman = 5;
            $currenthalaman = 1;

            if (isset($_GET['offset'])) {
                $offset = $_GET['offset'];
                $currenthalaman = $offset / $perhalaman + 1;
            } else {
                $offset = 0;
            }

            // Ambil data event yang terkait dengan tim
            $res = $eventObj->getEvent_Teams($idTeam, "", $offset, $perhalaman);
            $totaldata = $eventObj->getTotalDataEventTeams($idTeam, "");

            $jumlahhalaman = ceil($totaldata / $perhalaman);

            echo "<h2>Detail Event Team</h2>";
            echo "<table>
                <tr>
                    <th>ID Event</th>
                    <th>Nama Team</th>
                    <th>Nama Event</th>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
                </tr>";

            while ($row = $res->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["event_id"]) . "</td>
                        <td>" . htmlspecialchars($row["team_name"]) . "</td>
                        <td>" . htmlspecialchars($row["event_name"]) . "</td>
                        <td>" . htmlspecialchars($row["event_description"]) . "</td>
                        <td>" . htmlspecialchars($row["event_date"]) . "</td>
                    </tr>";
            }
            echo "</table>";

            echo "<div>Total Data: " . $totaldata . "</div>";

            // Pagination
            echo "<div class='pagination'>";
            echo "<a href='event_detail.php?idteam=$idTeam&offset=0'>First</a> ";

            for ($i = 1; $i <= $jumlahhalaman; $i++) {
                $off = ($i - 1) * $perhalaman;
                if ($currenthalaman == $i) {
                    echo "<strong>$i</strong> ";
                } else {
                    echo "<a href='event_detail.php?idteam=$idTeam&offset=" . $off . "'>$i</a> ";
                }
            }

            $lastoffset = ($jumlahhalaman - 1) * $perhalaman;
            echo "<a href='event_detail.php?idteam=$idTeam&offset=" . $lastoffset . "'>Last</a>";
            echo "</div>";
        } else {
            echo "<p>ID Team tidak ditemukan.</p>";
        }
        ?>
    </div>
</body>
</html>
