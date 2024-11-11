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
            $res = $eventObj->getAchievement_Teams($idTeam, "", $offset, $perhalaman);
            $totaldata = $eventObj->getTotalDataAchievementTeams($idTeam, "");

            $jumlahhalaman = ceil($totaldata / $perhalaman);

            echo "<h2>Detail Event Team</h2>";
            echo "<table>
                <tr>
                    <th>ID EveAchievementnt</th>
                    <th>Nama Achievement</th>
                    <th>Deskripsi</th>
                </tr>";

            while ($row = $res->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["idachievement"]) . "</td>
                        <td>" . htmlspecialchars($row["name_achievement"]) . "</td>
                        <td>" . htmlspecialchars($row["deskripsi"]) . "</td>
                    </tr>";
            }
            echo "</table>";

            echo "<div>Total Data: " . $totaldata . "</div>";

            
            echo "<div class='pagination'>";
            echo "<a href='achievement_detail.php?idteam=$idTeam&offset=0'>First</a> ";

            for ($i = 1; $i <= $jumlahhalaman; $i++) {
                $off = ($i - 1) * $perhalaman;
                if ($currenthalaman == $i) {
                    echo "<strong>$i</strong> ";
                } else {
                    echo "<a href='achievement_detail.php?idteam=$idTeam&offset=" . $off . "'>$i</a> ";
                }
            }

            $lastoffset = ($jumlahhalaman - 1) * $perhalaman;
            echo "<a href='achievement_detail.php?idteam=$idTeam&offset=" . $lastoffset . "'>Last</a>";
            echo "</div>";
        } else {
            echo "<p>ID Team tidak ditemukan.</p>";
        }
        ?>
    </div>
</body>
</html>
